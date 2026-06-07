<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan & Minuman', 'color' => 'amber', 'icon' => '🍽️'],
            ['name' => 'Kebutuhan Rumah', 'color' => 'blue', 'icon' => '🏠'],
            ['name' => 'Elektronik', 'color' => 'cyan', 'icon' => '💻'],
            ['name' => 'Pakaian', 'color' => 'rose', 'icon' => '👕'],
            ['name' => 'Kesehatan', 'color' => 'emerald', 'icon' => '💊'],
            ['name' => 'Transportasi', 'color' => 'indigo', 'icon' => '🚗'],
            ['name' => 'Lainnya', 'color' => 'gray', 'icon' => '📦'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
