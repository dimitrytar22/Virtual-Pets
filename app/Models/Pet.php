<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    protected $guarded =[];


    public static function createRandomPet($chatId) : Pet
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

    public function name() : BelongsTo{
        return $this->belongsTo(PetName::class);
    }
    public function image() : BelongsTo{
        return $this->belongsTo(PetImage::class);
    }
    public function hunger() : BelongsTo{
        return $this->belongsTo(PetHunger::class);
    }
    public function rarity() : BelongsTo{
        return $this->belongsTo(PetRarity::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
