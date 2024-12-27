<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'ar' => ['name' => 'الفئة الأولى'],
                'en' => ['name' => 'Category One'],
            ],
            [
                'ar' => ['name' => 'الفئة الثانية'],
                'en' => ['name' => 'Category Two'],
            ],
            [
                'ar' => ['name' => 'الفئة الثالثة'],
                'en' => ['name' => 'Category Three'],
            ],
        ];

        foreach ($categories as $translations) {
            Category::create([
                'name' => $translations, // Assign translations directly
            ]);
        }
    }
}
