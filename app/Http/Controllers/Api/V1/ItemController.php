<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Item\UpdateRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return ItemResource::collection(Item::all());
    }
    public function store()
    {
        return 113;
    }
    public function show(Item $item)
    {
        return new ItemResource($item);
    }
    public function update(UpdateRequest $request ,Item $item)
    {
        $data = $request->validated();
        try {
            $item->updateOrFail($data);
            return response(new ItemResource($item),200);
        }catch (\Exception $e){
            return response("",400);
        }
    }
    public function  destroy()
    {

    }
}
