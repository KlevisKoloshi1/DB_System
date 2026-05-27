<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $admin = User::factory()->create([
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ]);

            $users = User::factory(20)->create();
            $categories = Category::factory(20)->create();
            $suppliers = Supplier::factory(120)->create();
            $customers = Customer::factory(150)->create();

            $products = Product::factory(200)->make()->map(function ($product) use ($categories, $suppliers) {
                $product->category_id = $categories->random()->id;
                $product->supplier_id = $suppliers->random()->id;

                return $product;
            });
            $products->each->save();

            foreach (range(1, 180) as $i) {
                $user = $users->random();
                $customer = $customers->random();
                $order = SalesOrder::create([
                    'customer_id' => $customer->id,
                    'user_id' => $user->id,
                    'order_number' => 'SO-'.str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                    'order_date' => fake()->dateTimeBetween('-12 months', 'now'),
                    'status' => fake()->randomElement(['completed', 'completed', 'draft']),
                    'subtotal' => 0,
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => 0,
                ]);

                $items = $products->random(fake()->numberBetween(1, 5));
                $subtotal = 0;

                foreach ($items as $product) {
                    $qty = fake()->numberBetween(1, 7);
                    $lineTotal = $qty * (float) $product->selling_price;
                    $subtotal += $lineTotal;

                    SalesOrderItem::create([
                        'sales_order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $product->selling_price,
                        'line_total' => $lineTotal,
                    ]);

                    StockMovement::create([
                        'product_id' => $product->id,
                        'movement_type' => 'out',
                        'quantity' => $qty,
                        'reference_type' => SalesOrder::class,
                        'reference_id' => $order->id,
                        'notes' => 'Auto sales issue',
                        'created_by' => $user->id,
                    ]);
                }

                $tax = $subtotal * 0.12;
                $discount = $subtotal * 0.03;
                $total = $subtotal + $tax - $discount;
                $order->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $tax,
                    'discount_amount' => $discount,
                    'total_amount' => $total,
                ]);

                if ($order->status === 'completed') {
                    Payment::create([
                        'sales_order_id' => $order->id,
                        'amount' => $total,
                        'method' => fake()->randomElement(['cash', 'card', 'bank_transfer']),
                        'paid_at' => $order->order_date,
                    ]);
                }
            }

            foreach (range(1, 150) as $i) {
                $user = $users->random();
                $supplier = $suppliers->random();
                $po = PurchaseOrder::create([
                    'supplier_id' => $supplier->id,
                    'user_id' => $user->id,
                    'po_number' => 'PO-'.str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                    'po_date' => fake()->dateTimeBetween('-12 months', 'now'),
                    'status' => fake()->randomElement(['completed', 'completed', 'draft']),
                    'total_amount' => 0,
                ]);

                $items = $products->random(fake()->numberBetween(2, 6));
                $poTotal = 0;

                foreach ($items as $product) {
                    $qty = fake()->numberBetween(4, 20);
                    $lineTotal = $qty * (float) $product->purchase_price;
                    $poTotal += $lineTotal;

                    PurchaseOrderItem::create([
                        'purchase_order_id' => $po->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_cost' => $product->purchase_price,
                        'line_total' => $lineTotal,
                    ]);

                    StockMovement::create([
                        'product_id' => $product->id,
                        'movement_type' => 'in',
                        'quantity' => $qty,
                        'reference_type' => PurchaseOrder::class,
                        'reference_id' => $po->id,
                        'notes' => 'Auto purchase receipt',
                        'created_by' => $user->id,
                    ]);
                }

                $po->update(['total_amount' => $poTotal]);
            }

            User::firstOrCreate(
                ['email' => 'test@example.com'],
                ['name' => 'Test User', 'password' => bcrypt('password'), 'role' => 'user']
            );

            User::firstOrCreate(
                ['email' => 'admin@inventory.local'],
                ['name' => 'Inventory Admin', 'password' => bcrypt('password'), 'role' => 'admin']
            );
        });
    }
}
