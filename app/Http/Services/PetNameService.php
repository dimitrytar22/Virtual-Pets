<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\PetName\StoreRequest;
use App\Http\Requests\Admin\Pet\PetName\UpdateRequest;
use App\Models\PetImage;
use App\Models\PetName;

class PetNameService{
    public function store(StoreRequest $request){
        $data = $request->validated();


        $title_array =  preg_split('/[;:]/', $data['title']);
        foreach ($title_array as $title) {
            $title = trim($title);
            PetName::firstOrCreate([
                'title' => $title,
                'category_id' =>  $data['category_id']
            ],[
                'title' => $title,
                'category_id' => $data['category_id']
            ]);
        }
    }
    public function update(PetName $name, UpdateRequest $request){
        $name->update($request->validated());
    }
}



?>