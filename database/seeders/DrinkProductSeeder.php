<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DrinkProductSeeder extends Seeder
{
    public function run(): void
    {
      $drinksCategory = Category::where('slug', 'beverages-and-drink-mixes')->first();
        $drinks = [
            ['name' => 'Palmwine', 'slug' => 'palmwine', 'category_id' => $drinksCategory->id],
            ['name' => 'Coca Cola', 'slug' => 'coca-cola', 'category_id' => $drinksCategory->id],
            ['name' => 'Fanta', 'slug' => 'fanta', 'category_id' => $drinksCategory->id],
            ['name' => 'Sprite', 'slug' => 'sprite', 'category_id' => $drinksCategory->id],
            ['name' => 'Mirinda', 'slug' => 'mirinda', 'category_id' => $drinksCategory->id],
            ['name' => 'Lacasera', 'slug' => 'lacasera', 'category_id' => $drinksCategory->id],
            ['name' => 'Chivita', 'slug' => 'chivita', 'category_id' => $drinksCategory->id],
            ['name' => 'Chi Exotic', 'slug' => 'chi-exotic', 'category_id' => $drinksCategory->id],
            ['name' => 'Chivita Active', 'slug' => 'chivita-active', 'category_id' => $drinksCategory->id],
            ['name' => 'Hollandia Milk', 'slug' => 'hollandia-milk', 'category_id' => $drinksCategory->id],
            ['name' => 'Hollandia Yoghurt', 'slug' => 'hollandia-yoghurt', 'category_id' => $drinksCategory->id],
            ['name' => 'Viju Milk', 'slug' => 'viju-milk', 'category_id' => $drinksCategory->id],
            ['name' => '5 Alive', 'slug' => '5-alive', 'category_id' => $drinksCategory->id],
            ['name' => 'Sealed Zobo Drink', 'slug' => 'sealed-zobo-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Vita Milk', 'slug' => 'vita-milk', 'category_id' => $drinksCategory->id],
            ['name' => 'Soya Milk', 'slug' => 'soya-milk', 'category_id' => $drinksCategory->id],
            ['name' => 'Lucozade Boost', 'slug' => 'lucozade-boost', 'category_id' => $drinksCategory->id],
            ['name' => 'Lucozade Energy', 'slug' => 'lucozade-energy', 'category_id' => $drinksCategory->id],
            ['name' => 'Ribena', 'slug' => 'ribena', 'category_id' => $drinksCategory->id],
            ['name' => 'Nutri Milk', 'slug' => 'nutri-milk', 'category_id' => $drinksCategory->id],
            ['name' => 'Bigi Drinks', 'slug' => 'bigi-drinks', 'category_id' => $drinksCategory->id],
            ['name' => 'Fresh Yo', 'slug' => 'fresh-yo', 'category_id' => $drinksCategory->id],
            ['name' => 'Happy Hour', 'slug' => 'happy-hour', 'category_id' => $drinksCategory->id],
            ['name' => 'Caprisun Fruit Drink', 'slug' => 'caprisun-fruit-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Pop Cola', 'slug' => 'pop-cola', 'category_id' => $drinksCategory->id],
            ['name' => 'Lipton Ice Tea', 'slug' => 'lipton-ice-tea', 'category_id' => $drinksCategory->id],
            ['name' => 'Lipton Ice Bag', 'slug' => 'lipton-ice-bag', 'category_id' => $drinksCategory->id],
            ['name' => 'Fayrouz', 'slug' => 'fayrouz', 'category_id' => $drinksCategory->id],
            ['name' => 'Fearless Energy Drink', 'slug' => 'fearless-energy-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Predator Energy Drink', 'slug' => 'predator-energy-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Supa Komando Energy Drink', 'slug' => 'supa-komando-energy-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Desperado Energy Drink', 'slug' => 'desperado-energy-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Kunnu Drink', 'slug' => 'kunnu-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Soursop Drink', 'slug' => 'soursop-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Guava Drink', 'slug' => 'guava-drink', 'category_id' => $drinksCategory->id],
            ['name' => 'Jekanmo', 'slug' => 'jekanmo', 'category_id' => $drinksCategory->id],
            ['name' => 'Ginger Ale', 'slug' => 'ginger-ale', 'category_id' => $drinksCategory->id],
            ['name' => 'SANS', 'slug' => 'sans', 'category_id' => $drinksCategory->id],
            ['name' => 'Glucose', 'slug' => 'glucose', 'category_id' => $drinksCategory->id],
            ['name' => 'Smoov Chapman', 'slug' => 'smoov-chapman', 'category_id' => $drinksCategory->id],
            ['name' => '7 Up', 'slug' => '7-up', 'category_id' => $drinksCategory->id],
            ['name' => 'Pepsi', 'slug' => 'pepsi', 'category_id' => $drinksCategory->id],
            ['name' => 'Teem', 'slug' => 'teem', 'category_id' => $drinksCategory->id],
            ['name' => 'Dudu Drinks', 'slug' => 'dudu-drinks', 'category_id' => $drinksCategory->id],
            ['name' => 'Bold Drink', 'slug' => 'bold-drink', 'category_id' => $drinksCategory->id],
        ];

        $faker = \Faker\Factory::create('en_US');

        foreach ($drinks as $drink) {
          Product::create([
              'name' => $drink['name'],
              'slug' => $drink['slug'],
              'category_id' => $drink['category_id'],
              'description' => fake()->realText(),
              'base_price' => fake()->numberBetween(100, 5000),
              'stock_quantity' => fake()->numberBetween(10, 100),
              'is_active' => true,
              'is_featured' => false,
              'sku' => 'DRK-' . fake()->unique()->numberBetween(1000, 9999),
              'specifications' => json_encode([
                  'brand' => fake()->company(),
                  'packaging' => fake()->randomElement(['Bottle', 'Can', 'Tetra Pack', 'PET Bottle']),
                  'volume' => fake()->randomElement(['330ml', '500ml', '1L', '1.5L'])
              ]),
              'variants' => json_encode([
                  [
                      'size' => 330,
                      'unit' => 'ml',
                      'price' => fake()->numberBetween(100, 500),
                      'stock' => fake()->numberBetween(50, 200)
                  ],
                  [
                      'size' => 500,
                      'unit' => 'ml',
                      'price' => fake()->numberBetween(200, 800),
                      'stock' => fake()->numberBetween(50, 200)
                  ],
                  [
                      'size' => 1000,
                      'unit' => 'ml',
                      'price' => fake()->numberBetween(500, 1500),
                      'stock' => fake()->numberBetween(50, 200)
                  ]
              ])
          ]);
      }
      
      
    }
}
