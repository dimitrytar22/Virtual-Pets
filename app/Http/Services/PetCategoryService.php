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
        $title = $data['title'];

        PetCategory::create([
            'title' => $title
        ]);

    }

    public function update(UpdateRequest $request, PetCategory $category){
        $category->update($request->validated());
    }
}
