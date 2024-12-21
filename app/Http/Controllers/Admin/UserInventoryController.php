<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Inventory\SearchRequest;
use App\Http\Requests\Admin\User\Inventory\StoreRequest;
use App\Http\Requests\Admin\User\Inventory\UpdateRequest;
use App\Http\Services\UserInventoryService;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserInventoryController extends Controller
{
    public function __construct(private UserInventoryService $service)
    {
    }

    public function index()
    {
        return view('admin.users.inventories.index', ['users' => User::all()]);
    }

    public function search(SearchRequest $request){
        $itemsUser = $this->service->search($request);
        return response()->json(['inventory' => $itemsUser]);
    }

    public function edit( ItemUser $itemUser){
        return view('admin.users.inventories.edit', ['itemUser' => $itemUser]);
    }
    public function update(UpdateRequest $request, ItemUser $itemUser){
        $previousPage = $this->service->update($request,$itemUser);
        return redirect()->route($previousPage);
    }

    public function  create()
    {
        return view("admin.users.inventories.create", ['users' => User::all(), 'items' => Item::all()]);
    }
    public function  store(StoreRequest $request)
    {
        $previousPage = $this->service->store($request);
        return redirect()->route($previousPage);
    }

    public function destroy(ItemUser $itemUser)
    {
        $this->service->destroy($itemUser);
        return redirect()->route('admin.users.inventories.index');
    }
}
