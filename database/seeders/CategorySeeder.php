<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Flours and Starch Products',
                'description' => 'Premium quality flours and starch products for your baking needs'
            ],
            [
                'name' => 'Rice and Grains',
                'description' => 'High-quality wholesale rice and grains for your business'
            ],
            [
                'name' => 'Fish and Seafood',
                'description' => 'Fresh and frozen fish and seafood products in bulk'
            ],
            [
                'name' => 'Spices and Condiments',
                'description' => 'Aromatic spices and flavorful condiments for all cuisines'
            ],
                    [
                        'name' => 'Oils and Sauces',
                        'description' => 'Premium quality cooking oils and sauces for all your culinary needs'
                    ],
                    [
                        'name' => 'Vegetables and Leaves',
                        'description' => 'Fresh and dried vegetables, herbs and leaves for wholesale'
                    ],
                    [
                        'name' => 'Beverages and Drink Mixes',
                        'description' => 'Wide selection of beverages, drink mixes and concentrates'
                    ],
                    [
                        'name' => 'Snacks and Confectionery',
                        'description' => 'Delicious wholesale snacks and confectionery items'
                    ],
                    [
                        'name' => 'Sweets and Candy',
                        'description' => 'Variety of wholesale sweets, candies and treats'
                    ],
                    [
                        'name' => 'Nuts and Seeds',
                        'description' => 'Premium quality nuts and seeds in bulk quantities'
                    ],
                    [
                        'name' => 'Traditional and Herbal Products',
                        'description' => 'Traditional remedies and herbal products for wellness'
                    ],
                    [
                        'name' => 'Non-food Essentials',
                        'description' => 'Essential non-food items for your business needs'
                    ],
                    [
                        'name' => 'Miscellaneous',
                        'description' => 'Various other wholesale products and supplies'
                    ]        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description']
            ]);
        }
    }
}
