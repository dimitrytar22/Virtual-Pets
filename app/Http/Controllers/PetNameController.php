<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Pet\PetName\StoreRequest;
use App\Http\Requests\Admin\Pet\PetName\UpdateRequest ;
use App\Http\Services\PetNameService;
use App\Models\PetCategory;
use App\Models\PetName;
use Illuminate\Http\Request;

class PetNameController extends Controller
{
    private PetNameService $service;

    public function __construct(PetNameService $service)
    {
        $this->service  = $service;
    }

    public function index(){
        return view('admin.pets.names.index', ['pet_names' => PetName::paginate(20)]);
    }

    public function create(){
        return view('admin.pets.names.create', ['categories' => PetCategory::all()]);
    }

    public function store(StoreRequest $request){
       $this->service->store($request);
        return redirect()->route('admin.pets.names.create');
    }

    public function edit(PetName $name){
        return view('admin.pets.names.edit', ['name' => $name, 'pet_categories' => PetCategory::all()]);
    }

    public function update(PetName $name, UpdateRequest $request){
        $this->service->update($name,$request);
        return redirect()->route('admin.pets.names.edit', ['name' => $name->id])->with('message', 'Success');
    }
}
