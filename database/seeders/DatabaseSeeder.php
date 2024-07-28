<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pet;
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
        Pet::factory(100)->create();
        PetUser::factory(100)->create();
    }
}
