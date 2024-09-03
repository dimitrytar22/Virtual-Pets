<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pet\PetImage\StoreRequest;
use App\Http\Services\PetImageService;
use App\Models\PetCategory;
use App\Models\PetImage;
use App\Models\PetImageCategory;
use Illuminate\Http\Request;

class PetImageController extends Controller
{
    private PetImageService $service;

    public function __construct(PetImageService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return view('admin.pets.images.index', ['pet_images' => PetImage::all()]);
    }
    public function create(){
        return view('admin.pets.images.create', ['pet_categories' => PetCategory::all()]);
    }

    public function store(StoreRequest $request){
        $this->service->store($request);
        return redirect()->route('admin.pets.images.create');
    }

    public function edit(PetImage $image){
        dd($image);
    }
    public function update(PetImage $image){
        dd($image);
    }
}
