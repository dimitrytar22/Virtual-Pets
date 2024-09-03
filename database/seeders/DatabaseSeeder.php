<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pet;
use App\Models\PetCategory;
use App\Models\PetHunger;
use App\Models\PetImage;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\PetUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::unprepared("INSERT INTO `pet_categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
('1', 'Шимпанзе', '2024-08-07 13:26:16', '2024-08-07 13:26:16'),
('2', 'Хаски', '2024-08-07 13:26:21', '2024-08-07 13:26:21'),
('3', 'Мопс', '2024-08-07 13:26:25', '2024-08-07 13:26:25'),
('4', 'Дворняжка', '2024-08-07 13:26:43', '2024-08-07 13:26:43');");
        PetImage::factory(20)->create();
        PetName::factory(20)->create();
        // PetRarity::factory(7)->create();
        // PetCategory::factory(10)->create();

        // // Making pet hunger rows
        // PetHunger::factory()->count(10)->sequence(
        //     ['title' => 'Смертельный голод', 'hunger_index' => '1'],
        //     ['title' => 'Неприемлемый голод', 'hunger_index' => '2'],
        //     ['title' => 'Полностью истощен', 'hunger_index' => '3'],
        //     ['title' => 'Почти истощен', 'hunger_index' => '4'],
        //     ['title' => 'Очень хочется есть', 'hunger_index' => '5'],
        //     ['title' => 'Сильно голоден', 'hunger_index' => '6'],
        //     ['title' => 'Хочется поесть', 'hunger_index' => '7'],
        //     ['title' => 'Немного голоден', 'hunger_index' => '8'],
        //     ['title' => 'Легкий аппетит', 'hunger_index' => '9'],
        //     ['title' => 'Насытился', 'hunger_index' => '10'],
        // )->create();
        // End of making pet hunger rows

        //Making pet rarity rows
        PetRarity::factory()->count(6)->sequence(
            [
                'title' => 'Обычный', 'rarity_index' => 1
            ],[
                'title' => 'Необычный', 'rarity_index' => 2
            ],[
                'title' => 'Редкий', 'rarity_index' => 3
            ],[
                'title' => 'Очень редкий', 'rarity_index' => 4
            ],[
                'title' => 'Эпический', 'rarity_index' => 5
            ],[
                'title' => 'Легендарный', 'rarity_index' => 6
            ],
        )->create();
        // end of Making pet rarity rows
        
        // Pet::factory(10)->create();
        //PetUser::factory(100)->create();
    }
}
