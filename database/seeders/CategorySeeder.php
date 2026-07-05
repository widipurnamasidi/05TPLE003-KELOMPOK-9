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
        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming',
            'color' => 'bg-blue-500',
        ]);

        Category::create([
            'name' => 'Network Engineer',
            'slug' => 'network-engineer',
            'color' => 'bg-green-500',
        ]);

        Category::create([
            'name' => 'Machine Learning',
            'slug' => 'machine-learning',
            'color' => 'bg-purple-500',
        ]);
    }
}
