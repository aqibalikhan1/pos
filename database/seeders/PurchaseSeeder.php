<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $users = User::all();

        if ($suppliers->isEmpty() || $products->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Create sample purchases
        for ($i = 1; $i <= 10; $i++) {
            $supplier = $suppliers->random();
            $user = $users->random();
            
            $purchase = Purchase::create([
                'purchase_number' => 'PO-2024-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'supplier_id' => $supplier->id,
                'purchase_date' => now()->subDays(rand(1, 30)),
                'expected_delivery_date' => now()->addDays(rand(1, 7)),
                'subtotal' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => 0,
                'status' => collect(['pending', 'ordered', 'partially_received', 'received'])->random(),
                'payment_status' => collect(['pending', 'partial', 'paid'])->random(),
                'notes' => 'Sample purchase order #' . $i,
                'created_by' => $user->id,
            ]);

            // Create purchase items
            $subtotal = 0;
            $taxAmount = 0;
            $discountAmount = 0;

            $itemCount = rand(2, 5);
            for ($j = 1; $j <= $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 10);
                $unitPrice = $product->price * (0.8 + (rand(0, 20) / 100)); // 80-100% of product price
                $discountPercent = rand(0, 10);
                $taxPercent = rand(0, 15);

                $itemTotal = $quantity * $unitPrice;
                $itemDiscount = $itemTotal * ($discountPercent / 100);
                $itemTax = ($itemTotal - $itemDiscount) * ($taxPercent / 100);
                $netAmount = $itemTotal - $itemDiscount + $itemTax;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $itemTotal,
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $itemDiscount,
                    'tax_percent' => $taxPercent,
                    'tax_amount' => $itemTax,
                    'net_amount' => $netAmount,
                ]);

                $subtotal += $itemTotal;
                $discountAmount += $itemDiscount;
                $taxAmount += $itemTax;
            }

            $purchase->update([
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $subtotal - $discountAmount + $taxAmount,
            ]);
        }
    }
}
