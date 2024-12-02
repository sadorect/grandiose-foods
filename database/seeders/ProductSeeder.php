<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Grains & Cereals
        $this->createProduct([
            'category_id' => 1,
            'name' => 'Premium Basmati Rice',
            'description' => 'Long-grain aromatic basmati rice, aged for 2 years. Perfect for restaurants and food service.',
            'sku' => 'GRN-BSM-001',
            'base_price' => 89.99,
            'measurement_type' => 'weight',
            'min_order_quantity' => 25,
            'stock_quantity' => 500,
            'variants' => json_encode([
                ['size' => 25, 'unit' => 'kg', 'price' => 89.99, 'stock' => 500]
            ]),
            'specifications' => json_encode([
                'Origin' => 'India',
                'Grain Length' => '7.5mm',
                'Aging' => '24 months',
                'Grade' => 'Premium A'
            ])
        ]);

        $this->createProduct([
            'category_id' => 1,
            'name' => 'Organic Quinoa',
            'description' => 'Premium organic white quinoa. High in protein and essential amino acids.',
            'sku' => 'GRN-QNA-002',
            'base_price' => 120.00,
            'measurement_type' => 'weight',
            'min_order_quantity' => 20,
            'stock_quantity' => 300,
            'variants' => json_encode([
                ['size' => 20, 'unit' => 'kg', 'price' => 120.00, 'stock' => 300]
            ]),
            'specifications' => json_encode([
                'Origin' => 'Peru',
                'Type' => 'White Quinoa',
                'Organic' => 'Yes',
                'Grade' => 'A'
            ])
        ]);

        // Nuts & Seeds
        $this->createProduct([
            'category_id' => 2,
            'name' => 'Raw Cashews',
            'description' => 'Premium whole raw cashews. Perfect for snacking and food processing.',
            'sku' => 'NUT-CSH-001',
            'base_price' => 250.00,
            'measurement_type' => 'weight',
            'min_order_quantity' => 10,
            'stock_quantity' => 200,
            'variants' => json_encode([
                ['size' => 10, 'unit' => 'kg', 'price' => 250.00, 'stock' => 200]
            ]),
            'specifications' => json_encode([
                'Origin' => 'Vietnam',
                'Grade' => 'W320',
                'Process' => 'Raw',
                'Size' => 'Large'
            ])
        ]);

        // Dried Fruits
        $this->createProduct([
            'category_id' => 3,
            'name' => 'Turkish Apricots',
            'description' => 'Premium dried Turkish apricots. Naturally sweet and preservative-free.',
            'sku' => 'DRF-APR-001',
            'base_price' => 145.00,
            'measurement_type' => 'weight',
            'min_order_quantity' => 15,
            'stock_quantity' => 250,
            'variants' => json_encode([
                ['size' => 15, 'unit' => 'kg', 'price' => 145.00, 'stock' => 250]
            ]),
            'specifications' => json_encode([
                'Origin' => 'Turkey',
                'Type' => 'Natural',
                'Sulfur' => 'No',
                'Size' => 'Large'
            ])
        ]);

        // Spices & Seasonings
        $this->createProduct([
            'category_id' => 4,
            'name' => 'Black Peppercorns',
            'description' => 'Premium Tellicherry black peppercorns. Bold aroma and complex flavor.',
            'sku' => 'SPC-BPP-001',
            'base_price' => 180.00,
            'measurement_type' => 'weight',
            'min_order_quantity' => 10,
            'stock_quantity' => 300,
            'variants' => json_encode([
                ['size' => 10, 'unit' => 'kg', 'price' => 180.00, 'stock' => 300]
            ]),
            'specifications' => json_encode([
                'Origin' => 'India',
                'Grade' => 'TGSEB',
                'Size' => '4.75mm',
                'Type' => 'Tellicherry'
            ])
        ]);
    }

    private function createProduct($data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = true;
        Product::create($data);
    }
}
