<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(){
        return view('admin.users.pets.index',['users' => User::all()]);
    }

    public function search(Request $request){
        $userId = $request->query('user_id');
        $pets = Pet::query()->where('user_id', $userId)->with('name')->with('name.category')->with('rarity')->with('image')->get();

        return response()->json(['pets' => $pets]);
    }
}
