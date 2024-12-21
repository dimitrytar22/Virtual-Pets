<?php

namespace App\Http\Services;


use App\Http\Requests\Admin\User\Inventory\SearchRequest;
use App\Http\Requests\Admin\User\Inventory\StoreRequest;
use App\Http\Requests\Admin\User\Inventory\UpdateRequest;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\PetRarity;
use App\Models\User;
use Illuminate\Http\Request;

class UserInventoryService
{
    public function search(SearchRequest $request)
    {
        $userId = $request->query('user_id');
        $user = User::find($userId);
        return $itemsUser = ItemUser::where('user_id', $userId)->with('item')->with('user')->get();
    }

    public function update(UpdateRequest $request, ItemUser $itemUser)
    {
        $data = $request->validated();
        $itemUser->update([
            'amount' => $data['amount'],
        ]);
        return $data['previous_page'];
    }

    public function  store(StoreRequest $request)
    {
        $data = $request->validated();
        $item = Item::find($data['item_id']);
        $user = User::find($data['user_id']);

        ItemUser::addItem(  $user,$item, $data['amount']);
        return $data['previous_page'];
    }

    public function destroy(ItemUser $itemUser) : bool
    {
        return $itemUser->delete();
    }

}
