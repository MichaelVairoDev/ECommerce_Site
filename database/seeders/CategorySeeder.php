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
                'name' => 'Action Games',
                'description' => 'Action games focus on physical challenges, including hand-eye coordination and reaction-time.',
            ],
            [
                'name' => 'Adventure Games',
                'description' => 'Adventure games feature exploration, puzzle-solving, and interactive storylines.',
            ],
            [
                'name' => 'RPG Games',
                'description' => 'Role-playing games focus on character development and immersive storytelling.',
            ],
            [
                'name' => 'Sports Games',
                'description' => 'Sports games simulate traditional physical sports or variations.',
            ],
            [
                'name' => 'Strategy Games',
                'description' => 'Strategy games emphasize skillful thinking and planning to achieve victory.',
            ],
            [
                'name' => 'Simulation Games',
                'description' => 'Simulation games are designed to closely simulate real-world activities.',
            ],
            [
                'name' => 'Fighting Games',
                'description' => 'Fighting games emphasize one-on-one combat between characters.',
            ],
            [
                'name' => 'Racing Games',
                'description' => 'Racing games involve competing against opponents to reach a goal.',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );
        }
    }
}
