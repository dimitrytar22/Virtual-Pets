<?php

use App\Http\Controllers\Admin\PetCategoryController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PetImageController;
use App\Http\Controllers\Admin\User\PetController as UserPetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PetNameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::group(['prefix' => 'pets', 'as' => 'pets.'], function(){
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::get('/create', [PetController::class, 'create'])->name('create');
        Route::post('/store', [PetController::class, 'store'])->name('store');
        Route::get('/{pet}/edit', [PetController::class, 'edit'])->name('edit');
        Route::put('/{pet}', [PetController::class, 'update'])->name('update');

        Route::group(['prefix' => 'images', 'as' => 'images.'], function(){
            Route::get('/', [PetImageController::class, 'index'])->name('index');
            Route::get('/create', [PetImageController::class, 'create'])->name('create');
            Route::post('/store', [PetImageController::class, 'store'])->name('store');
            Route::get('/{image}/edit', [PetImageController::class, 'edit'])->name('edit');
            Route::put('/{image}', [PetImageController::class, 'update'])->name('update');

        });

        Route::group(['prefix' => 'names', 'as' => 'names.'], function(){
            Route::get('/', [PetNameController::class, 'index'])->name('index');
            Route::get('/create', [PetNameController::class, 'create'])->name('create');
            Route::post('/store', [PetNameController::class, 'store'])->name('store');
            Route::get('/{name}/edit', [PetNameController::class, 'edit'])->name('edit');
            Route::put('/{name}', [PetNameController::class, 'update'])->name('update');

        });

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function(){
            Route::get('/', [PetCategoryController::class, 'index'])->name('index');
            Route::get('/create', [PetCategoryController::class, 'create'])->name('create');
            Route::post('/store', [PetCategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [PetCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [PetCategoryController::class, 'update'])->name('update');

        });
    });
    Route::group(['prefix' => 'users', 'as' => 'users.'], function(){

        Route::group(['prefix' => 'pets', 'as' => 'pets.'], function(){
            Route::get('/', [UserPetController::class, 'index'])->name('index');
            Route::get('/search', [UserPetController::class, 'search'])->name('search');
        });

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
 
    });
        
    Route::get('/', [AdminController::class, 'index'])->name('index');
});