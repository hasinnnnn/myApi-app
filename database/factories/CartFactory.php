<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'idUser' => fake()->randomDigitNotNull(),
        'idProduct'=> fake()->randomDigitNotNull(),
        'quantity'=> fake()->randomDigitNotNull(),
        'totalAmount'=> fake()->randomNumber(),
        'status'=> fake()->randomDigitNotNull(),
        ];
    }
}
