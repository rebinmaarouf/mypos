<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ['pro one', 'pro two'];

        foreach ($products as $product) {
            Product::create([
                'category_id' => 1, // Ensure this category exists
                'ar' => [
                    'name' => $product,
                    'description' => $product . ' desc',
                ],
                'en' => [
                    'name' => $product,
                    'description' => $product . ' desc',
                ],
                'purchase_price' => 100,
                'sale_price' => 150,
                'stock' => 100,
            ]);
        }
    }
}
