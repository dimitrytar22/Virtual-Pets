<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\PetName\StoreRequest;
use App\Http\Requests\Admin\Pet\PetName\UpdateRequest;
use App\Models\PetImage;
use App\Models\PetName;

class PetNameService{
    public function store(StoreRequest $request){
        $data = $request->validated();
        PetName::firstOrCreate([
            'title' => $data['title']
        ],[$data]);
    }
    public function update(PetName $name, UpdateRequest $request){
        $name->update($request->validated());
    }
}



?>