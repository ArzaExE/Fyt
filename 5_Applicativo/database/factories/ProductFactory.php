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
        $shoeNames = [
            'Air Jordan 1', 'Nike Air Max', 'Adidas Ultra Boost', 'Puma Suede', 'Converse Chuck Taylor',
            'Vans Old Skool', 'New Balance 990', 'Reebok Classic', 'Fila Disruptor', 'Asics Gel Lyte'
        ];

        return [
            'name' => fake()->randomElement($shoeNames),
            'description' => fake()->realText(),
            'color' => fake()->colorName(),
            'release_date' => fake()->date(),
            'price' => fake()->randomFloat()
        ];
    }
}
