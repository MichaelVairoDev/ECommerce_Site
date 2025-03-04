<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    private static $gameNumber = 1;

    public function definition(): array
    {
        $games = [
            'The Legend of Zelda',
            'Final Fantasy',
            'Red Dead Redemption',
            'God of War',
            'The Last of Us',
            'Super Mario',
            'Mass Effect',
            'Grand Theft Auto',
            'Resident Evil',
            'Metal Gear Solid',
            'Dark Souls',
            'Monster Hunter',
            'Dragon Quest',
            'Persona',
            'Halo',
        ];

        $name = $this->faker->randomElement($games) . ' ' . self::$gameNumber++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 19.99, 69.99),
            'stock' => $this->faker->numberBetween(0, 100),
            'platform' => $this->faker->randomElement(['PC', 'PS5', 'PS4', 'Xbox Series X', 'Xbox One', 'Nintendo Switch']),
            'category_id' => Category::inRandomOrder()->first()->id,
            'publisher' => $this->faker->company(),
            'developer' => $this->faker->company(),
            'release_date' => $this->faker->dateTimeBetween('-2 years', '+6 months'),
            'rating' => $this->faker->randomElement(['E', 'E10+', 'T', 'M', 'AO', 'RP']),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
