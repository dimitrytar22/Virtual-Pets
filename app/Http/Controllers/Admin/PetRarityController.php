<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\PetRarityService;
use App\Models\PetRarity;
use Illuminate\Http\Request;

class PetRarityController extends Controller
{
    public function __construct(private PetRarityService $service)
    {
    }

    public function index(){
        return view('admin.pets.rarities.index', ['rarities' => PetRarity::all()]);
    }
    public function update(Request $request, PetRarity $rarity){
       return $this->service->update($request,$rarity);
    }
}
