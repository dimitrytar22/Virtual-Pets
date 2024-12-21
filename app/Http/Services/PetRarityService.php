<?php

namespace App\Http\Services;



use App\Models\PetRarity;
use Illuminate\Http\Request;

class PetRarityService
{
    public function update(Request $request, PetRarity $rarity){
        $data = $request->validate([
            'rarity_index' => 'required',
        ]);
        try {
            $rarity->update($data);
            return 200;
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
