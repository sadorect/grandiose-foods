<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    private $categoryMap = [];

    public function __construct()
    {
        $categories = DB::table('categories')->select('id', 'name')->get();
        foreach ($categories as $category) {
            $this->categoryMap[Str::slug($category->name)] = $category->id;
        }
    }

    public function run()
    {
        // Flours and Starch Products
        $flourCategory = $this->categoryMap['flours-and-starch-products'];
        $flourProducts = [
            ['name' => 'Odourless Fufu', 'price' => 79.99],
            ['name' => 'Pupuru', 'price' => 85.99],
            ['name' => 'Oat Flour', 'price' => 95.99],
            ['name' => 'Beans Flour', 'price' => 65.99],
            ['name' => 'Pounded Yam Flour', 'price' => 89.99],
            ['name' => 'Maize Flour', 'price' => 55.99],
            ['name' => 'Soya Beans Flour', 'price' => 75.99],
            ['name' => 'Potato Flour', 'price' => 69.99],
            ['name' => 'Wheat Flour', 'price' => 59.99],
            ['name' => 'Cocoyam Flour', 'price' => 79.99],
            ['name' => 'Edible Starch', 'price' => 45.99],
            ['name' => 'Grinded Rice', 'price' => 65.99]
        ];

        foreach ($flourProducts as $product) {
            $this->createProduct([
                'category_id' => $flourCategory,
                'name' => $product['name'],
                'description' => 'Premium quality ' . $product['name'] . ' - Perfect for commercial and household use',
                'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                'base_price' => $product['price'],
                'measurement_type' => 'weight',
                'min_order_quantity' => 10,
                'stock_quantity' => rand(200, 500),
                'variants' => json_encode([
                    ['size' => 10, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(200, 500)]
                ]),
                'specifications' => json_encode([
                    'Quality' => 'Premium Grade',
                    'Processing' => 'Modern Milling',
                    'Packaging' => 'Moisture Resistant'
                ])
            ]);
        }

        // Rice and Grains
        $grainCategory = $this->categoryMap['rice-and-grains'];
        $grainProducts = [
            ['name' => 'Ofada Rice', 'price' => 150.00],
            ['name' => 'Nasco Corn Flakes', 'price' => 89.99],
            ['name' => 'Infinity Rice', 'price' => 120.00],
            ['name' => 'Kelloggs Cereals', 'price' => 95.99],
            ['name' => 'White Pap', 'price' => 45.99],
            ['name' => 'Yellow Pap', 'price' => 45.99]
        ];

        foreach ($grainProducts as $product) {
            $this->createProduct([
                'category_id' => $grainCategory,
                'name' => $product['name'],
                'description' => 'High-quality ' . $product['name'] . ' - Sourced from premium suppliers',
                'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                'base_price' => $product['price'],
                'measurement_type' => 'weight',
                'min_order_quantity' => 20,
                'stock_quantity' => rand(200, 400),
                'variants' => json_encode([
                    ['size' => 20, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(200, 400)]
                ]),
                'specifications' => json_encode([
                    'Origin' => 'Nigeria',
                    'Grade' => 'Premium A',
                    'Storage' => 'Keep in cool, dry place'
                ])
            ]);
        }

        // Fish and Seafood
        $fishCategory = $this->categoryMap['fish-and-seafood'];
        $fishProducts = [
            ['name' => 'Titus Fish', 'price' => 250.00],
            ['name' => 'Dried Catfish', 'price' => 280.00],
            ['name' => 'Okporoko Fish', 'price' => 220.00],
            ['name' => 'Dried Fish', 'price' => 190.00]
        ];

        foreach ($fishProducts as $product) {
            $this->createProduct([
                'category_id' => $fishCategory,
                'name' => $product['name'],
                'description' => 'Fresh ' . $product['name'] . ' - Properly processed and preserved',
                'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                'base_price' => $product['price'],
                'measurement_type' => 'weight',
                'min_order_quantity' => 5,
                'stock_quantity' => rand(100, 300),
                'variants' => json_encode([
                    ['size' => 5, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(100, 300)]
                ]),
                'specifications' => json_encode([
                    'Processing' => 'Sun-dried',
                    'Quality' => 'Premium',
                    'Storage' => 'Keep in cool, dry place'
                ])
            ]);
        }

        // Continue with remaining categories...
        // I'll provide the next part with Spices, Oils, Vegetables, etc. Would you like me to continue?
    
                // Spices and Condiments
                $spiceCategory = $this->categoryMap['spices-and-condiments'];
                $spiceProducts = [
                    ['name' => 'Pepper Soup Spice', 'price' => 120.00],
                    ['name' => 'Suya Spice', 'price' => 110.00],
                    ['name' => 'Locust Beans', 'price' => 180.00],
                    ['name' => 'Dried Pepper', 'price' => 90.00],
                    ['name' => 'Ayamase Spice', 'price' => 130.00],
                    ['name' => 'Ogbono', 'price' => 200.00],
                    ['name' => 'Banga Spice', 'price' => 150.00]
                ];
        
                foreach ($spiceProducts as $product) {
                    $this->createProduct([
                        'category_id' => $spiceCategory,
                        'name' => $product['name'],
                        'description' => 'Authentic ' . $product['name'] . ' - Fresh and aromatic',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 5,
                        'stock_quantity' => rand(150, 300),
                        'variants' => json_encode([
                            ['size' => 5, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(150, 300)]
                        ]),
                        'specifications' => json_encode([
                            'Processing' => 'Natural',
                            'Quality' => 'Premium Grade',
                            'Packaging' => 'Airtight'
                        ])
                    ]);
                }
        
                // Oils and Sauces
                $oilCategory = $this->categoryMap['oils-and-sauces'];
                $oilProducts = [
                    ['name' => 'Bleached Palm Oil', 'price' => 180.00],
                    ['name' => 'Red Palm Oil', 'price' => 160.00],
                    ['name' => 'Gino Tomato Paste', 'price' => 120.00],
                    ['name' => 'De Rica Tomato Paste', 'price' => 125.00],
                    ['name' => 'Sonia Tomato Paste', 'price' => 115.00]
                ];
        
                foreach ($oilProducts as $product) {
                    $this->createProduct([
                        'category_id' => $oilCategory,
                        'name' => $product['name'],
                        'description' => 'Pure ' . $product['name'] . ' - High quality and fresh',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'volume',
                        'min_order_quantity' => 10,
                        'stock_quantity' => rand(200, 400),
                        'variants' => json_encode([
                            ['size' => 10, 'unit' => 'L', 'price' => $product['price'], 'stock' => rand(200, 400)]
                        ]),
                        'specifications' => json_encode([
                            'Processing' => 'Refined',
                            'Quality' => 'Premium',
                            'Packaging' => 'Food Grade Container'
                        ])
                    ]);
                }
        
                // Vegetables and Leaves
                $vegCategory = $this->categoryMap['vegetables-and-leaves'];
                $vegProducts = [
                    ['name' => 'Dried Ugwu Leaves', 'price' => 85.00],
                    ['name' => 'Uziza Leaves', 'price' => 90.00],
                    ['name' => 'Uziza Seeds', 'price' => 95.00],
                    ['name' => 'Dried Bitter Leaf', 'price' => 75.00]
                ];
        
                foreach ($vegProducts as $product) {
                    $this->createProduct([
                        'category_id' => $vegCategory,
                        'name' => $product['name'],
                        'description' => 'Dried ' . $product['name'] . ' - Naturally preserved',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 5,
                        'stock_quantity' => rand(100, 250),
                        'variants' => json_encode([
                            ['size' => 5, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(100, 250)]
                        ]),
                        'specifications' => json_encode([
                            'Processing' => 'Sun-dried',
                            'Organic' => 'Yes',
                            'Storage' => 'Keep in cool, dry place'
                        ])
                    ]);
                }
        
                // Beverages and Drink Mixes
                $bevCategory = $this->categoryMap['beverages-and-drink-mixes'];
                $bevProducts = [
                    ['name' => 'Ovaltine', 'price' => 150.00],
                    ['name' => 'Checkers Custard', 'price' => 120.00],
                    ['name' => 'Chocomilo', 'price' => 140.00],
                    ['name' => 'Peak Milk Powder', 'price' => 160.00]
                ];
        
                foreach ($bevProducts as $product) {
                    $this->createProduct([
                        'category_id' => $bevCategory,
                        'name' => $product['name'],
                        'description' => 'Premium quality ' . $product['name'],
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 10,
                        'stock_quantity' => rand(200, 400),
                        'variants' => json_encode([
                            ['size' => 10, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(200, 400)]
                        ]),
                        'specifications' => json_encode([
                            'Brand' => 'Original',
                            'Quality' => 'Premium',
                            'Packaging' => 'Factory Sealed'
                        ])
                    ]);
                }
        
                // Snacks and Confectionery
                $snackCategory = $this->categoryMap['snacks-and-confectionery'];
                $snackProducts = [
                    ['name' => 'Shortbread Biscuits', 'price' => 85.00],
                    ['name' => 'Cream Crackers', 'price' => 75.00],
                    ['name' => 'Gala Sausage Roll', 'price' => 95.00],
                    ['name' => 'Kilishi', 'price' => 250.00],
                    ['name' => 'Kulikuli', 'price' => 120.00],
                    ['name' => 'Pancake Mix', 'price' => 110.00],
                    ['name' => 'Puffpuff Mix', 'price' => 100.00]
                ];
        
                foreach ($snackProducts as $product) {
                    $this->createProduct([
                        'category_id' => $snackCategory,
                        'name' => $product['name'],
                        'description' => 'Delicious ' . $product['name'] . ' - Perfect for retail',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 10,
                        'stock_quantity' => rand(150, 300),
                        'variants' => json_encode([
                            ['size' => 10, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(150, 300)]
                        ]),
                        'specifications' => json_encode([
                            'Quality' => 'Premium',
                            'Packaging' => 'Retail Ready',
                            'Shelf Life' => '6 months'
                        ])
                    ]);
                }
        
                // Sweets and Candy
                $candyCategory = $this->categoryMap['sweets-and-candy'];
                $candyProducts = [
                    ['name' => 'Tom Tom', 'price' => 65.00],
                    ['name' => 'Butter Mint', 'price' => 55.00],
                    ['name' => 'Baba Blue', 'price' => 45.00],
                    ['name' => 'Trebor', 'price' => 60.00],
                    ['name' => 'Baba Dudu', 'price' => 45.00],
                    ['name' => 'Goody Goody', 'price' => 50.00]
                ];
        
                foreach ($candyProducts as $product) {
                    $this->createProduct([
                        'category_id' => $candyCategory,
                        'name' => $product['name'],
                        'description' => 'Classic ' . $product['name'] . ' - Wholesale packs',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 5,
                        'stock_quantity' => rand(200, 500),
                        'variants' => json_encode([
                            ['size' => 5, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(200, 500)]
                        ]),
                        'specifications' => json_encode([
                            'Type' => 'Confectionery',
                            'Packaging' => 'Bulk Pack',
                            'Storage' => 'Cool and Dry'
                        ])
                    ]);
                }
        
                // Nuts and Seeds
                $nutCategory = $this->categoryMap['nuts-and-seeds'];
                $nutProducts = [
                    ['name' => 'Cashew Nuts', 'price' => 280.00],
                    ['name' => 'Peanuts', 'price' => 150.00]
                ];
        
                foreach ($nutProducts as $product) {
                    $this->createProduct([
                        'category_id' => $nutCategory,
                        'name' => $product['name'],
                        'description' => 'Premium ' . $product['name'] . ' - Carefully selected',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 10,
                        'stock_quantity' => rand(150, 300),
                        'variants' => json_encode([
                            ['size' => 10, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(150, 300)]
                        ]),
                        'specifications' => json_encode([
                            'Grade' => 'Premium',
                            'Processing' => 'Natural',
                            'Quality' => 'Export Grade'
                        ])
                    ]);
                }
        
                // Traditional and Herbal Products
                $herbCategory = $this->categoryMap['traditional-and-herbal-products'];
                $herbProducts = [
                    ['name' => 'Bitter Cola', 'price' => 180.00],
                    ['name' => 'Kolanut', 'price' => 200.00]
                ];
        
                foreach ($herbProducts as $product) {
                    $this->createProduct([
                        'category_id' => $herbCategory,
                        'name' => $product['name'],
                        'description' => 'Traditional ' . $product['name'] . ' - Naturally preserved',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'weight',
                        'min_order_quantity' => 5,
                        'stock_quantity' => rand(100, 200),
                        'variants' => json_encode([
                            ['size' => 5, 'unit' => 'kg', 'price' => $product['price'], 'stock' => rand(100, 200)]
                        ]),
                        'specifications' => json_encode([
                            'Origin' => 'Nigeria',
                            'Type' => 'Traditional',
                            'Processing' => 'Natural'
                        ])
                    ]);
                }
        
                // Non-food Essentials
                $essentialCategory = $this->categoryMap['non-food-essentials'];
                $essentialProducts = [
                    ['name' => 'Aboniki Balm', 'price' => 45.00],
                    ['name' => 'Robb Balm', 'price' => 40.00]
                ];
        
                foreach ($essentialProducts as $product) {
                    $this->createProduct([
                        'category_id' => $essentialCategory,
                        'name' => $product['name'],
                        'description' => 'Original ' . $product['name'] . ' - Wholesale pack',
                        'sku' => Str::upper(substr(Str::slug($product['name']), 0, 3)) . '-' . rand(100, 999),
                        'base_price' => $product['price'],
                        'measurement_type' => 'unit',
                        'min_order_quantity' => 24,
                        'stock_quantity' => rand(200, 400),
                        'variants' => json_encode([
                            ['size' => 24, 'unit' => 'pieces', 'price' => $product['price'], 'stock' => rand(200, 400)]
                        ]),
                        'specifications' => json_encode([
                            'Brand' => 'Original',
                            'Type' => 'Topical Balm',
                            'Packaging' => 'Retail Box'
                        ])
                    ]);
                }
        
    }

    private function createProduct($data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = true;
        Product::create($data);
    }
}
