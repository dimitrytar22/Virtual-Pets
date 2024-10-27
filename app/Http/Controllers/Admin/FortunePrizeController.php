<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Fortune_Wheel\Prize\StoreRequest;
use App\Models\FortunePrize;
use App\Models\Item;
use Illuminate\Http\Request;

class FortunePrizeController extends Controller
{
    public function create(){
        return view('admin.fortune_wheel.prizes.create', ['items' => Item::all()]);
    }

    public function  store(StoreRequest $request)
    {
        $data = $request->validated();
        FortunePrize::create([
           'title' => $data['title'],
            'related_item' => $data['related_item'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'chance' => $data['chance'],
        ]);
        return redirect()->route('admin.fortune_wheel.prizes.create');
    }
}
