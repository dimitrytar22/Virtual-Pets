<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Fortune_Wheel\Prize\StoreRequest;
use App\Http\Requests\Admin\Fortune_Wheel\Prize\UpdateRequest;
use App\Http\Services\FortunePrizeService;
use App\Models\FortunePrize;
use App\Models\Item;
use Illuminate\Http\Request;

class FortunePrizeController extends Controller
{


    public function __construct(private FortunePrizeService $service)
    {

    }

    public function create(){
        return view('admin.fortune_wheel.prizes.create', ['items' => Item::all()]);
    }

    public function store(StoreRequest $request)
    {
       $this->service->store($request);
        return redirect()->route('admin.fortune_wheel.prizes.index');
    }

    public function edit(FortunePrize $prize)
    {
        return view('admin.fortune_wheel.prizes.edit', ['prize' => $prize, 'items' => Item::all()]);
    }
    public function  update(UpdateRequest $request, FortunePrize $prize)
    {
        $this->service->update($request,$prize);
        return redirect()->route('admin.fortune_wheel.index');
    }
    public function destroy(FortunePrize $prize)
    {
        $this->service->destroy($prize);
        return redirect()->route('admin.fortune_wheel.index');
    }
}
