<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\PetImage\StoreRequest;
use App\Models\PetCategory;
use App\Models\PetImage;

class PetImageService{
    public function store(StoreRequest $request){
        $data = $request->validated();

        $image = $data['image'];
        $title = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $category_title = strtok($title, '_');
        $category_id = PetCategory::query()->where('title', $category_title)->first()->id;
        $newImageName = $title . '.' . $image->getClientOriginalExtension();

        PetImage::create([
            'title' => $newImageName,
            'category_id' => $category_id
        ]);
        
        $image->move(public_path('images'), $newImageName);

    }
}



?>