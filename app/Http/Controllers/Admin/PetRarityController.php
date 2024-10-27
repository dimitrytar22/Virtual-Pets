<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PetRarity;
use Illuminate\Http\Request;

class PetRarityController extends Controller
{
    public function index(){
        return view('admin.pets.rarities.index', ['rarities' => PetRarity::all()]);
    }
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
