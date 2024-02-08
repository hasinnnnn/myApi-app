<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'productName' => fake()->word(),
            'price' => fake()->randomNumber(5),
            'stock' => fake()->randomDigitNotNull(1),
            'description' => fake()->word(),
            'images' => fake()->imageUrl($width = 200, $height = 200),
            'status' => fake()->numberBetween(1,3),
        ];
    }
}
