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
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
            'price' => $this->faker->numberBetween(1, 99999),
            'description' => $this->faker->text(),
            'category' => $this->faker->slug(10),
            'image_url' => $this->faker->url(),
        ];
    }
}
