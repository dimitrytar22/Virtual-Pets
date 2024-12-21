<?php

namespace App\Http\Services;


use App\Http\Requests\Admin\Fortune_Wheel\Prize\StoreRequest;
use App\Http\Requests\Admin\Fortune_Wheel\Prize\UpdateRequest;
use App\Models\FortunePrize;
use App\Models\PetCategory;

class FortunePrizeService
{
    public function store(StoreRequest $request): FortunePrize
    {
        $data = $request->validated();
        $prize = FortunePrize::create([
            'title' => $data['title'],
            'related_item' => $data['related_item'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'chance' => $data['chance'],
        ]);
        return $prize;
    }

    public function update(UpdateRequest $request, FortunePrize $prize): bool
    {
        return $prize->updateOrFail($request->validated());
    }

    public function destroy(FortunePrize $prize) : bool
    {
        return $prize->delete();
    }
}
