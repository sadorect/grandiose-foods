<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Premium Basmati Rice',
                'description' => 'Long-grain aromatic rice perfect for various cuisines',
                'price' => 45.99,
                'min_order_quantity' => 25,
                'stock_quantity' => 1000,
                'sku' => 'GRN-BSM-001',
                'specifications' => [
                    'Origin' => 'India',
                    'Grade' => 'Premium',
                    'Package Size' => '25kg'
                ]
            ],
            [
                'category_id' => 2,
                'name' => 'Organic Dried Mango',
                'description' => 'Naturally sweet dried mango slices with no added sugar',
                'price' => 28.99,
                'min_order_quantity' => 10,
                'stock_quantity' => 500,
                'sku' => 'DFR-MNG-001',
                'specifications' => [
                    'Origin' => 'Philippines',
                    'Type' => 'Organic',
                    'Package Size' => '5kg'
                ]
            ],
            [
                'category_id' => 3,
                'name' => 'Raw Cashew Nuts',
                'description' => 'Premium quality whole cashew nuts',
                'price' => 89.99,
                'min_order_quantity' => 15,
                'stock_quantity' => 300,
                'sku' => 'NUT-CSH-001',
                'specifications' => [
                    'Origin' => 'Vietnam',
                    'Grade' => 'W320',
                    'Package Size' => '10kg'
                ]
            ]
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'min_order_quantity' => $product['min_order_quantity'],
                'stock_quantity' => $product['stock_quantity'],
                'sku' => $product['sku'],
                'specifications' => $product['specifications'],
                'is_featured' => true,
                'is_active' => true
            ]);
        }
    }
}
