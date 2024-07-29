<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pet;
use App\Models\PetHunger;
use App\Models\PetImage;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\PetUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // PetImage::factory(20)->create();
        // PetName::factory(20)->create();
        // PetRarity::factory(7)->create();

        // Making pet hunger rows
        PetHunger::factory()->count(10)->sequence(
            ['title' => 'Смертельный голод', 'hunger_index' => '1'],
            ['title' => 'Неприемлемый голод', 'hunger_index' => '2'],
            ['title' => 'Полностью истощен', 'hunger_index' => '3'],
            ['title' => 'Почти истощен', 'hunger_index' => '4'],
            ['title' => 'Очень хочется есть', 'hunger_index' => '5'],
            ['title' => 'Сильно голоден', 'hunger_index' => '6'],
            ['title' => 'Хочется поесть', 'hunger_index' => '7'],
            ['title' => 'Немного голоден', 'hunger_index' => '8'],
            ['title' => 'Легкий аппетит', 'hunger_index' => '9'],
            ['title' => 'Насытился', 'hunger_index' => '10'],
        )->create();
        // End of making pet hunger rows
        
        // Pet::factory(100)->create();
        // PetUser::factory(100)->create();
    }
}
