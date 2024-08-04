<?php
namespace App\Http\Services;

use App\Http\Requests\Pet\StoreRequest;
use App\Models\Pet;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\PetUser;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class PetService{
    public function update(StoreRequest $updateRequest){
        $data = $updateRequest->validated();
        $name = PetName::firstOrCreate([
            'title' => $data['name']
        ],
        [
            'title' => $data['name']
        ]);
        $rarity = PetRarity::find($data['rarity_id']);

        $pet = Pet::create([
            'rarity_id' => $rarity->id,
            'image_id' => '1',
            'name_id' => $name->id,
            'experience' => $data['experience'],
            'strength' => $data['strength']
        ]);
        $pet_user = PetUser::create([
            'user_id' => User::query()->where('chat_id', $data['chat_id'])->first()->id,
            'pet_id' => $pet->id
        ]);
        dd($pet);
    }
}



?>