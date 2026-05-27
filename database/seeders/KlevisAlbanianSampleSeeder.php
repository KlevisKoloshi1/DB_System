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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlevisAlbanianSampleSeeder extends Seeder
{
    private const USER_EMAIL = 'kleviskoloshi8@gmail.com';

    public function run(): void
    {
        DB::transaction(function (): void {
            $user = User::updateOrCreate(
                ['email' => self::USER_EMAIL],
                [
                    'name' => 'Klevis Koloshi',
                    'password' => 'Klevis2008',
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]
            );

            if (Category::where('slug', 'elektronike')->exists()) {
                $this->command?->info('Të dhënat shqipe ekzistojnë tashmë — përdoruesi u përditësua.');

                return;
            }

            $categories = [
                Category::create([
                    'name' => 'Elektronikë',
                    'slug' => 'elektronike',
                    'description' => 'Pajisje elektronike, telefona dhe aksesorë kompjuteri.',
                ]),
                Category::create([
                    'name' => 'Ushqim dhe Pije',
                    'slug' => 'ushqim-dhe-pije',
                    'description' => 'Produkte ushqimore, pije dhe artikuj të përditshëm.',
                ]),
                Category::create([
                    'name' => 'Higjienë Personale',
                    'slug' => 'higjiene-personale',
                    'description' => 'Kozmetikë, pastë dhëmbësh dhe produkte higjiene.',
                ]),
            ];

            $suppliers = [
                Supplier::create([
                    'name' => 'Furnizuesi Shqiptar SH.P.K',
                    'email' => 'info@furnizuesishqiptar.al',
                    'phone' => '+355 4 223 4567',
                    'city' => 'Tiranë',
                    'address' => 'Rruga e Durrësit, Nr. 120, Tiranë',
                ]),
                Supplier::create([
                    'name' => 'Balkan Trade Ltd',
                    'email' => 'shitje@balkantrade.al',
                    'phone' => '+355 52 123 890',
                    'city' => 'Durrës',
                    'address' => 'Zona Industriale, Durrës',
                ]),
                Supplier::create([
                    'name' => 'Adriatik Logistics',
                    'email' => 'magazina@adriatik.al',
                    'phone' => '+355 33 456 789',
                    'city' => 'Vlorë',
                    'address' => 'Lagjia Skele, Vlorë',
                ]),
            ];

            $customers = [
                Customer::create([
                    'name' => 'Arben Krasniqi',
                    'email' => 'arben.krasniqi@email.al',
                    'phone' => '+355 69 123 4567',
                    'city' => 'Tiranë',
                    'address' => 'Blloku, Rruga Ismail Qemali, Tiranë',
                ]),
                Customer::create([
                    'name' => 'Elona Hoxha',
                    'email' => 'elona.hoxha@email.al',
                    'phone' => '+355 68 234 5678',
                    'city' => 'Shkodër',
                    'address' => 'Rruga Kolë Idromeno, Shkodër',
                ]),
                Customer::create([
                    'name' => 'Marin Gjoka',
                    'email' => 'marin.gjoka@email.al',
                    'phone' => '+355 67 345 6789',
                    'city' => 'Korçë',
                    'address' => 'Rruga Republika, Korçë',
                ]),
                Customer::create([
                    'name' => 'Drita Shehu',
                    'email' => 'drita.shehu@email.al',
                    'phone' => '+355 69 456 7890',
                    'city' => 'Elbasan',
                    'address' => 'Lagjia Universiteti, Elbasan',
                ]),
            ];

            $products = collect([
                [
                    'category' => $categories[0],
                    'supplier' => $suppliers[0],
                    'name' => 'Laptop Dell Inspiron 15',
                    'sku' => 'AL-ELE-001',
                    'description' => 'Laptop 15.6", Intel Core i5, 8GB RAM, 512GB SSD.',
                    'purchase_price' => 650.00,
                    'selling_price' => 899.00,
                    'reorder_level' => 5,
                    'stock' => 12,
                ],
                [
                    'category' => $categories[0],
                    'supplier' => $suppliers[0],
                    'name' => 'Telefon Samsung Galaxy A54',
                    'sku' => 'AL-ELE-002',
                    'description' => 'Smartphone 128GB, ekran 6.4", kamera 50MP.',
                    'purchase_price' => 280.00,
                    'selling_price' => 399.00,
                    'reorder_level' => 8,
                    'stock' => 25,
                ],
                [
                    'category' => $categories[0],
                    'supplier' => $suppliers[1],
                    'name' => 'Kufje Bluetooth JBL Tune',
                    'sku' => 'AL-ELE-003',
                    'description' => 'Kufje pa tela me izolim zhurme aktiv.',
                    'purchase_price' => 35.00,
                    'selling_price' => 59.99,
                    'reorder_level' => 15,
                    'stock' => 40,
                ],
                [
                    'category' => $categories[1],
                    'supplier' => $suppliers[1],
                    'name' => 'Miell Treteshtë 1kg',
                    'sku' => 'AL-USH-001',
                    'description' => 'Miell i bardhë për bukë dhe ëmbëlsira.',
                    'purchase_price' => 0.85,
                    'selling_price' => 1.50,
                    'reorder_level' => 50,
                    'stock' => 200,
                ],
                [
                    'category' => $categories[1],
                    'supplier' => $suppliers[2],
                    'name' => 'Ujë Mineral Poliçani 1.5L',
                    'sku' => 'AL-USH-002',
                    'description' => 'Ujë natyral mineral, paketim 6 copë.',
                    'purchase_price' => 2.40,
                    'selling_price' => 4.20,
                    'reorder_level' => 30,
                    'stock' => 150,
                ],
                [
                    'category' => $categories[1],
                    'supplier' => $suppliers[2],
                    'name' => 'Vaj Ulliri Extra Virgjër 1L',
                    'sku' => 'AL-USH-003',
                    'description' => 'Vaj ulliri i prodhuar në Berat, i ftohtë-shtrënguar.',
                    'purchase_price' => 6.50,
                    'selling_price' => 11.90,
                    'reorder_level' => 20,
                    'stock' => 60,
                ],
                [
                    'category' => $categories[2],
                    'supplier' => $suppliers[0],
                    'name' => 'Shampo Antidandruff 400ml',
                    'sku' => 'AL-HIG-001',
                    'description' => 'Shampo kundër zbokthit, formulë e butë.',
                    'purchase_price' => 3.20,
                    'selling_price' => 5.99,
                    'reorder_level' => 25,
                    'stock' => 80,
                ],
                [
                    'category' => $categories[2],
                    'supplier' => $suppliers[1],
                    'name' => 'Krem Hidratues për Fytyrë 50ml',
                    'sku' => 'AL-HIG-002',
                    'description' => 'Krem ditor me SPF 15 për lëkurë normale.',
                    'purchase_price' => 8.00,
                    'selling_price' => 14.50,
                    'reorder_level' => 15,
                    'stock' => 45,
                ],
            ])->map(function (array $row) use ($user) {
                $product = Product::create([
                    'category_id' => $row['category']->id,
                    'supplier_id' => $row['supplier']->id,
                    'name' => $row['name'],
                    'sku' => $row['sku'],
                    'description' => $row['description'],
                    'purchase_price' => $row['purchase_price'],
                    'selling_price' => $row['selling_price'],
                    'reorder_level' => $row['reorder_level'],
                    'current_stock' => 0,
                    'is_active' => true,
                ]);

                StockMovement::create([
                    'product_id' => $product->id,
                    'movement_type' => 'in',
                    'quantity' => $row['stock'],
                    'reference_type' => 'seed',
                    'reference_id' => null,
                    'notes' => 'Stok fillestar — hyrje në magazinë',
                    'created_by' => $user->id,
                ]);

                return $product->fresh();
            });

            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $suppliers[0]->id,
                'user_id' => $user->id,
                'po_number' => 'BL-2026-001',
                'po_date' => now()->subDays(14)->toDateString(),
                'status' => 'received',
                'total_amount' => 0,
            ]);

            $poTotal = 0;
            foreach ([$products[0], $products[1]] as $product) {
                $qty = 5;
                $cost = (float) $product->purchase_price;
                $line = $qty * $cost;
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_cost' => $cost,
                    'line_total' => $line,
                ]);
                $poTotal += $line;
            }
            $purchaseOrder->update(['total_amount' => $poTotal]);

            $this->seedSalesOrder(
                user: $user,
                customer: $customers[0],
                orderNumber: 'SO-2026-001',
                orderDate: now()->subMonths(2)->startOfMonth()->addDays(4),
                status: 'completed',
                lines: [
                    ['product' => $products[1], 'qty' => 2],
                    ['product' => $products[2], 'qty' => 3],
                ],
                paymentMethod: 'card',
                userId: $user->id,
            );

            $this->seedSalesOrder(
                user: $user,
                customer: $customers[1],
                orderNumber: 'SO-2026-002',
                orderDate: now()->subMonth()->startOfMonth()->addDays(10),
                status: 'completed',
                lines: [
                    ['product' => $products[3], 'qty' => 20],
                    ['product' => $products[4], 'qty' => 12],
                    ['product' => $products[5], 'qty' => 4],
                ],
                paymentMethod: 'cash',
                userId: $user->id,
            );

            $this->seedSalesOrder(
                user: $user,
                customer: $customers[2],
                orderNumber: 'SO-2026-003',
                orderDate: now()->subDays(5),
                status: 'completed',
                lines: [
                    ['product' => $products[0], 'qty' => 1],
                    ['product' => $products[6], 'qty' => 2],
                ],
                paymentMethod: 'transfer',
                userId: $user->id,
            );

            $pendingOrder = SalesOrder::create([
                'customer_id' => $customers[3]->id,
                'user_id' => $user->id,
                'order_number' => 'SO-2026-004',
                'order_date' => now()->subDays(2),
                'status' => 'pending',
                'subtotal' => 59.99,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => 59.99,
            ]);

            SalesOrderItem::create([
                'sales_order_id' => $pendingOrder->id,
                'product_id' => $products[2]->id,
                'quantity' => 1,
                'unit_price' => 59.99,
                'line_total' => 59.99,
            ]);

            $this->command?->info('U krijuan të dhënat shqipe për kleviskoloshi8@gmail.com');
        });
    }

    /**
     * @param  array<int, array{product: Product, qty: int}>  $lines
     */
    private function seedSalesOrder(
        User $user,
        Customer $customer,
        string $orderNumber,
        \DateTimeInterface $orderDate,
        string $status,
        array $lines,
        string $paymentMethod,
        int $userId,
    ): void {
        $subtotal = 0;

        $order = SalesOrder::create([
            'customer_id' => $customer->id,
            'user_id' => $user->id,
            'order_number' => $orderNumber,
            'order_date' => $orderDate,
            'status' => $status,
            'subtotal' => 0,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'total_amount' => 0,
        ]);

        foreach ($lines as $line) {
            $unitPrice = (float) $line['product']->selling_price;
            $lineTotal = $line['qty'] * $unitPrice;
            $subtotal += $lineTotal;

            SalesOrderItem::create([
                'sales_order_id' => $order->id,
                'product_id' => $line['product']->id,
                'quantity' => $line['qty'],
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
            ]);

            StockMovement::create([
                'product_id' => $line['product']->id,
                'movement_type' => 'out',
                'quantity' => $line['qty'],
                'reference_type' => SalesOrder::class,
                'reference_id' => $order->id,
                'notes' => 'Dalje stoku për porosinë '.$orderNumber,
                'created_by' => $userId,
            ]);
        }

        $order->update([
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
        ]);

        if ($status === 'completed') {
            Payment::create([
                'sales_order_id' => $order->id,
                'amount' => $subtotal,
                'method' => $paymentMethod,
                'paid_at' => $orderDate,
            ]);
        }
    }
}
