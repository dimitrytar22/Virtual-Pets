<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Inventory\StoreRequest;
use App\Http\Requests\Admin\User\Inventory\UpdateRequest;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function  index()
    {
        return view('admin.users.inventories.index', ['users' => User::all()]);
    }

    public function search(Request $request){
        $userId = $request->query('user_id');
        $user = User::find($userId);
        $itemsUser = ItemUser::where('user_id',$userId)->with('item')->with('user')->get();

        return response()->json(['inventory' => $itemsUser]);
    }

    public function edit( ItemUser $itemUser){
        return view('admin.users.inventories.edit', ['itemUser' => $itemUser]);
    }
    public function update(UpdateRequest $request, ItemUser $itemUser){
        $data = $request->validated();
        $itemUser->update([
            'amount' => $data['amount'],
            ]);
        return redirect()->route($data['previous_page']);
    }

    public function  create()
    {
        return view("admin.users.inventories.create", ['users' => User::all(), 'items' => Item::all()]);
    }
    public function  store(StoreRequest $request)
    {
        $data = $request->validated();
        $item = Item::find($data['item_id']);
        $user = User::find($data['user_id']);

        ItemUser::addItem(  $user,$item, $data['amount']);
        return redirect()->route($data['previous_page']);
    }
}
