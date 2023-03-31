<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(30000, 150000);
        $awesomePrice = $price - $price % 1000;

        return [
            'name' => fake()->words(rand(2, 5), true),
            'price' => $awesomePrice,
            'description' => fake()->sentence()
        ];
    }
}
