<?php

namespace App\Http\Services;


use App\Http\Requests\Admin\User\Pet\SearchRequest;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetUserService
{
    public function search(SearchRequest $request)
    {
        $userId = $request->validated()['user_id'];
        return $pets = Pet::query()->where('user_id', $userId)->with('name')->with('name.category')->with('rarity')->with('image')->get();
    }
}
