<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $categories = ['cat one', 'cat two', 'cat three'];

        foreach ($categories as $category) {

            Category::create([
                'ar' => ['name' => $category],
                'en' => ['name' => $category],
            ]);
        } //end of foreach

    } //end of run

}
