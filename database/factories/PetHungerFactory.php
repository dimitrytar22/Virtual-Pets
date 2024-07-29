<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetHunger>
 */
class PetHungerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(10),
            'hunger_index' => $this->faker->unique()->numberBetween(1,10) // 1/10 - не сытый  10/10 сытый
        ];
    }
}
