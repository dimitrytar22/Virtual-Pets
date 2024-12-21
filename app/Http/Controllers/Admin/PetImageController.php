<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pet\PetImage\StoreRequest;
use App\Http\Requests\Admin\Pet\PetImage\UpdateRequest;
use App\Http\Services\PetImageService;
use App\Models\PetCategory;
use App\Models\PetImage;
use App\Models\PetImageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetImageController extends Controller
{
    private PetImageService $service;

    public function __construct(PetImageService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.pets.images.index', ['pet_images' => PetImage::paginate(20)]);
    }

    public function create()
    {
        return view('admin.pets.images.create', ['categories' => PetCategory::all()]);
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.pets.images.index');
    }

    public function edit(PetImage $image)
    {
        $categories = PetCategory::all()->sortBy('title');
        return view('admin.pets.images.edit', compact('image', 'categories'));
    }

    public function update(UpdateRequest $request, PetImage $image)
    {
        $this->service->update($request, $image);
        return redirect()->route('admin.pets.images.index');
    }

    public function destroy(PetImage $image)
    {
       $this->service->destroy($image);
        return redirect()->route('admin.pets.images.index');
    }

}
