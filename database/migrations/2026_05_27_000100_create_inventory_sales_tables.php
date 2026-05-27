<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone', 30)->nullable();
            $table->string('city')->nullable()->index();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone', 30)->nullable();
            $table->string('city')->nullable()->index();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('selling_price', 12, 2);
            $table->unsignedInteger('reorder_level')->default(10);
            $table->unsignedInteger('current_stock')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['category_id', 'supplier_id']);
            $table->index(['name', 'sku']);
        });

        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('order_number')->unique();
            $table->date('order_date')->index();
            $table->string('status', 20)->default('draft')->index();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
            $table->unique(['sales_order_id', 'product_id']);
            $table->index(['product_id', 'quantity']);
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('po_number')->unique();
            $table->date('po_date')->index();
            $table->string('status', 20)->default('draft')->index();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_cost', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
            $table->unique(['purchase_order_id', 'product_id']);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method', 20)->default('cash')->index();
            $table->date('paid_at')->index();
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('movement_type', 20)->index();
            $table->unsignedInteger('quantity');
            $table->string('reference_type', 40)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->index(['reference_type', 'reference_id']);
        });

        DB::unprepared('
            CREATE OR REPLACE VIEW monthly_sales_summary AS
            SELECT
                DATE_TRUNC(\'month\', so.order_date)::date AS month_start,
                COUNT(DISTINCT so.id) AS orders_count,
                SUM(so.total_amount) AS gross_sales,
                SUM(COALESCE(p.total_paid, 0)) AS collected_amount
            FROM sales_orders so
            LEFT JOIN (
                SELECT sales_order_id, SUM(amount) AS total_paid
                FROM payments
                GROUP BY sales_order_id
            ) p ON p.sales_order_id = so.id
            WHERE so.status = \'completed\'
            GROUP BY DATE_TRUNC(\'month\', so.order_date)
            ORDER BY month_start DESC;
        ');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION refresh_product_stock(p_product_id BIGINT)
            RETURNS VOID AS $$
            BEGIN
                UPDATE products
                SET current_stock = COALESCE((
                    SELECT SUM(
                        CASE
                            WHEN movement_type = \'in\' THEN quantity
                            WHEN movement_type = \'out\' THEN -quantity
                            ELSE 0
                        END
                    ) FROM stock_movements WHERE product_id = p_product_id
                ), 0)
                WHERE id = p_product_id;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION stock_movement_after_insert()
            RETURNS TRIGGER AS $$
            BEGIN
                PERFORM refresh_product_stock(NEW.product_id);
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE TRIGGER trg_stock_movement_insert
            AFTER INSERT ON stock_movements
            FOR EACH ROW
            EXECUTE FUNCTION stock_movement_after_insert();
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_stock_movement_insert ON stock_movements;');
        DB::unprepared('DROP FUNCTION IF EXISTS stock_movement_after_insert();');
        DB::unprepared('DROP FUNCTION IF EXISTS refresh_product_stock(BIGINT);');
        DB::unprepared('DROP VIEW IF EXISTS monthly_sales_summary;');

        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('sales_order_items');
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
    }
};
