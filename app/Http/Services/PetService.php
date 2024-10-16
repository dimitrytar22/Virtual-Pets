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

class PetService{
    public function store(StoreRequest $updateRequest){
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

    public function update(UpdateRequest $updateRequest, Pet $pet){
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

    public function delete(Pet $pet){
        $pet->delete();
    }
}



?>