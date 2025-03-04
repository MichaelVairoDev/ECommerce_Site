<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Action RPG',
            'Strategy Games',
            'Sports Simulation',
            'Racing Games',
            'Fighting Games',
            'Horror Games',
            'Adventure Games',
            'Puzzle Games',
            'Shooter Games',
            'Platform Games'
        ];

        $name = $this->faker->unique()->randomElement($categories);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
        ];
    }
}
