<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\StoreRequest;
use App\Http\Requests\Admin\Pet\UpdateRequest;
use App\Models\Pet;
use App\Models\PetImage;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\PetUser;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class PetService
{
    public function store(StoreRequest $updateRequest)
    {
        $data = $updateRequest->validated();
        $user = User::query()->where('chat_id', $data['chat_id'])->first();
        $name = PetName::firstOrCreate([
            'title' => $data['name']
        ],
            [
                'title' => $data['name']
            ]);
        $randImage = PetImage::query()->where('category_id', $name->category->id)->get()->random(1)->first();
        $pet = Pet::create([
            'rarity_id' => $data['rarity_id'],
            'image_id' => $randImage->id,
            'name_id' => $name->id,
            'experience' => $data['experience'],
            'strength' => $data['strength'],
            'user_id' => $user->id
        ]);

    }

    public function update(UpdateRequest $updateRequest, Pet $pet)
    {
        $data = $updateRequest->validated();
        $name = PetName::firstOrCreate([
            'title' => $data['name']
        ],
            [
                'title' => $data['name']
            ]);
        $pet->update([
            'rarity_id' => $data['rarity_id'],

            'name_id' => $name->id,
            'experience' => $data['experience'],
            'strength' => $data['strength'],
            'user_id' => $data['user_id']
        ]);
        return $data['previous_page'];
    }

    public function delete(Pet $pet)
    {
        $pet->delete();
    }

    public function createRandomPet($chatId): Pet
    {

        $rarities = PetRarity::all();

        $weightedRarities = [];

        foreach ($rarities as $rarity) {
            $weight = 1 / $rarity->rarity_index;
            for ($i = 0; $i < $weight * 100; $i++) {
                $weightedRarities[] = $rarity->id;
            }
        }
        $selectedRarityId = $weightedRarities[array_rand($weightedRarities)];


        $user = User::query()->where('chat_id', $chatId)->first();
        $rarity_id = $selectedRarityId;
        $name_id = PetName::all()->random();
        $image_id = PetImage::where('category_id', $name_id->category->id)->get()->random()->id;

        $name_id = $name_id->id;

        $experience = fake()->numberBetween(0, 100);
        $strength = fake()->numberBetween(1, 10);
        $hunger_index = fake()->numberBetween(0, 10);

        return Pet::create([
            'rarity_id' => $rarity_id,
            'image_id' => $image_id,
            'name_id' => $name_id,
            'experience' => $experience,
            'strength' => $strength,
            'hunger_index' => $hunger_index,
            'user_id' => $user->id
        ]);
    }

}


?>
