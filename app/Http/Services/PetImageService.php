<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\PetImage\StoreRequest;
use App\Models\PetImage;

class PetImageService{
    public function store(StoreRequest $request){
        $data = $request->validated();

        $image = $data['image'];
        $title = $data['title'];
        $category_id = $data['category_id'];

        $newImageName = $title . '.' . $image->getClientOriginalExtension();

        PetImage::create([
            'title' => $newImageName,
            'category_id' => $category_id
        ]);
        
        $image->move(public_path('images'), $newImageName);

    }
}



?>