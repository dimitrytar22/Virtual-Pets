<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\PetImage\StoreRequest;
use App\Http\Requests\Admin\Pet\PetImage\UpdateRequest;
use App\Models\PetCategory;
use App\Models\PetImage;

class PetImageService{
    public function store(StoreRequest $request){
        $data = $request->validated();
        $file = $request->file('image');
        $fileName = $request->file('image')->getClientOriginalName();
        $file->move(public_path('images'), $fileName);

        PetImage::create([
            'title' => $fileName,
            'category_id' => $data['category_id']
        ]);

    }

    public function update(UpdateRequest $request, PetImage $image){
        $data = $request->validated();
        $file = $request->file('image');
        $fileName = $request->file('image')->getClientOriginalName();
        $file->move(public_path('images'), $fileName);

        $image->update([
            'title' => $fileName,
            'category_id' => $data['category_id']
        ]);
    }
}



?>
