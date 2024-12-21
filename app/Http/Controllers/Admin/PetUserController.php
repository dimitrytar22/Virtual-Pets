<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Pet\SearchRequest;
use App\Http\Services\PetUserService;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class PetUserController extends Controller
{
    public function __construct(private PetUserService $service)
    {
    }

    public function index(){
        return view('admin.users.pets.index',['users' => User::all()]);
    }

    public function search(SearchRequest $request){
        $pets = $this->service->search($request);
        return response()->json(['pets' => $pets]);
    }
}
