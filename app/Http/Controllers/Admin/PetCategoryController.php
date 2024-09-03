<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pet\PetCategory\StoreRequest;
use App\Http\Requests\Admin\Pet\PetCategory\UpdateRequest;
use App\Http\Services\PetCategoryService;
use App\Models\PetCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PetCategoryController extends Controller
{
    private PetCategoryService $service;

    public function __construct(PetCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return view('admin.pets.categories.index', ['categories' => PetCategory::all()]);
    }
    public function create(){
        return view('admin.pets.categories.create');
    }
    public function store(StoreRequest $request) : RedirectResponse{
        $this->service->store($request);
        return redirect()->route('admin.pets.categories.create');
    }
    public function edit(PetCategory $category){
        return view("admin.pets.categories.edit", ['category' => $category]);
    }
    public function update(UpdateRequest $request, PetCategory $category){
        $this->service->update($request,$category);
        return redirect()->route('admin.pets.categories.edit', $category->id)->with('message', 'Success');
    }
}
