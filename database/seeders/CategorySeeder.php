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
                'name' => 'Grains & Cereals',
                'description' => 'High-quality wholesale grains and cereals for your business needs'
            ],
            [
                'name' => 'Dried Fruits',
                'description' => 'Premium quality dried fruits sourced from the best farms'
            ],
            [
                'name' => 'Nuts & Seeds',
                'description' => 'Fresh and nutritious nuts and seeds in bulk quantities'
            ],
            [
                'name' => 'Legumes',
                'description' => 'Wide variety of wholesale legumes and pulses'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description']
            ]);
        }
    }
}
