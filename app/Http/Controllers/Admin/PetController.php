<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pet\StoreRequest;
use App\Http\Services\PetService;
use App\Models\Pet;
use App\Models\PetName;
use App\Models\PetRarity;
use App\Models\User;
use Illuminate\Http\Request;

class PetController extends Controller
{
    private PetService $service;

    public function __construct(PetService $service)
    {
        $this->service = $service;
    }


    public function index(){
        return view('admin.pets.index',[
            'pets' => Pet::paginate(50),
                    ]);
    }
    
    public function create(){
            $users = User::all();
        return view('admin.pets.create', ['users' => $users, 'pet_rarities' => PetRarity::all(), 'pet_names' => PetName::all()]);
    }

    public function store(StoreRequest $request){
        $this->service->update($request);
    }   
}
