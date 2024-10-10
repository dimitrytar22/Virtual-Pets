<?php
namespace App\Http\Services;

use App\Http\Requests\Admin\Pet\PetCategory\StoreRequest;
use App\Http\Requests\Admin\Pet\PetCategory\UpdateRequest;
use App\Models\PetCategory;

class PetCategoryService
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $title_array = $data['title'];
        $title_array = str_replace(' ','', $title_array);
        $title_array =  preg_split('/[;:]/', $title_array);
        foreach($title_array as $title){
            PetCategory::create([
                'title' => $title
            ]);
            
        }


    }

    public function update(UpdateRequest $request, PetCategory $category){
        $category->update($request->validated());
    }
}
