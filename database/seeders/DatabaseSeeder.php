<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $electronics = Category::firstOrCreate(['name' => 'Electronics']);

        $products = [
            ['name' => 'Laptop', 'price' => 650.00],
            ['name' => 'Mouse', 'price' => 15.00],
            ['name' => 'Keyboard', 'price' => 25.00],
            ['name' => 'Monitor', 'price' => 120.00],
        ];

        foreach ($products as $item) {
            Product::firstOrCreate(
                ['name' => $item['name']],
                ['category_id' => $electronics->id, 'price' => $item['price']]
            );
        }
    }
}