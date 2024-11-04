<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Fortune_Wheel\Prize\StoreRequest;
use App\Http\Requests\Admin\Fortune_Wheel\Prize\UpdateRequest;
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

    public function  edit(FortunePrize $prize)
    {
        return view('admin.fortune_wheel.prizes.edit', ['prize' => $prize, 'items' => Item::all()]);
    }
    public function  update(UpdateRequest $request, FortunePrize $prize)
    {
        $prize->update($request->validated());
        return redirect()->route('admin.fortune_wheel.index');
    }
    public function  destroy($prize)
    {
        $fortunePrize = FortunePrize::find(($prize));
        $fortunePrize->delete();
        return redirect()->route('admin.fortune_wheel.index');
    }
}
