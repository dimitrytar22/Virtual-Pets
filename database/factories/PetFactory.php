<?php

namespace Database\Factories;

use App\Models\PetHunger;
use App\Models\PetImage;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rarity_id' => PetRarity::all()->random()->id,
            'image_id' => PetImage::all()->random()->id,
            'name_id' => PetName::all()->random()->id,
            'experience' => $this->faker->numberBetween(0,10000),
            'strength' => $this->faker->numberBetween(1,1000),
            'hunger_index' => $this->faker->numberBetween(0,10),
            'user_id' => User::all()->random()->id,
        ];
    }
}
