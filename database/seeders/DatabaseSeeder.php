<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories and get their IDs
        $categoryNames = [
            'personal_care',
            'oral_care',
            'beverages',
            'dairy',
        ];
        $categoryIds = [];
        foreach ($categoryNames as $name) {
            $category = \App\Models\Category::firstOrCreate(['name' => $name]);
            $categoryIds[$name] = $category->id;
        }

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sample products with packaging
        $products = [
            [
                'name' => 'Lux Cotton Soap',
                'sku' => 'LUX-COTTON-001',
                'description' => 'Premium cotton soap for daily use',
                'category_id' => $categoryIds['personal_care'],
                'price' => 45.00,
                'cost_price' => 30.00,
                'stock_quantity' => 144,
                'min_stock_level' => 24,
                'unit' => 'pcs',
                'packaging_type' => 'carton',
                'pieces_per_pack' => 72,
                'barcode' => '1234567890123',
                'is_active' => true,
            ],
            [
                'name' => 'Dove Shampoo',
                'sku' => 'DOVE-SHAMPOO-002',
                'description' => 'Moisturizing shampoo for all hair types',
                'category_id' => $categoryIds['personal_care'],
                'price' => 120.00,
                'cost_price' => 85.00,
                'stock_quantity' => 48,
                'min_stock_level' => 12,
                'unit' => 'pcs',
                'packaging_type' => 'box',
                'pieces_per_pack' => 12,
                'barcode' => '1234567890124',
                'is_active' => true,
            ],
            [
                'name' => 'Colgate Toothpaste',
                'sku' => 'COLGATE-TOOTH-003',
                'description' => 'Fluoride toothpaste for cavity protection',
                'category_id' => $categoryIds['oral_care'],
                'price' => 85.00,
                'cost_price' => 60.00,
                'stock_quantity' => 120,
                'min_stock_level' => 30,
                'unit' => 'pcs',
                'packaging_type' => 'carton',
                'pieces_per_pack' => 24,
                'barcode' => '1234567890125',
                'is_active' => true,
            ],
            [
                'name' => 'Lipton Tea Bags',
                'sku' => 'LIPTON-TEA-004',
                'description' => 'Premium tea bags for daily consumption',
                'category_id' => $categoryIds['beverages'],
                'price' => 150.00,
                'cost_price' => 100.00,
                'stock_quantity' => 200,
                'min_stock_level' => 50,
                'unit' => 'pcs',
                'packaging_type' => 'box',
                'pieces_per_pack' => 100,
                'barcode' => '1234567890126',
                'is_active' => true,
            ],
            [
                'name' => 'Nestle Milk Powder',
                'sku' => 'NESTLE-MILK-005',
                'description' => 'Full cream milk powder for daily use',
                'category_id' => $categoryIds['dairy'],
                'price' => 450.00,
                'cost_price' => 350.00,
                'stock_quantity' => 60,
                'min_stock_level' => 15,
                'unit' => 'pcs',
                'packaging_type' => 'carton',
                'pieces_per_pack' => 12,
                'barcode' => '1234567890127',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Seed customers and towns
        $this->call([
            TownSeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            RouteSeeder::class,
        ]);
    }
}
