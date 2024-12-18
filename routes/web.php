<?php

use App\Http\Controllers\Admin\FortuneWheelController;
use App\Http\Controllers\Admin\PetCategoryController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PetImageController;
use App\Http\Controllers\Admin\PetRarityController;
use App\Http\Controllers\Admin\User\InventoryController;
use App\Http\Controllers\Admin\User\PetController as UserPetController;
use App\Http\Controllers\Admin\User\RegistrationApplicationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PetNameController;
use App\Models\Pet;
use App\Models\PetCategory;
use App\Models\PetImage;
use App\Models\PetName;
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

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function(){
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::group(['prefix' => 'pets', 'as' => 'pets.'], function(){
        Route::get('/', [PetController::class, 'index'])->name('index');
        Route::get('/create', [PetController::class, 'create'])->name('create');
        Route::post('/store', [PetController::class, 'store'])->name('store');
        Route::get('/{pet}/edit', [PetController::class, 'edit'])->name('edit');
        Route::put('/{pet}', [PetController::class, 'update'])->name('update');
        Route::delete('/{pet}', [PetController::class, 'delete'])->name('delete');

        Route::group(['prefix' => 'images', 'as' => 'images.'], function(){
            Route::get('/', [PetImageController::class, 'index'])->name('index');
            Route::get('/create', [PetImageController::class, 'create'])->name('create');
            Route::post('/store', [PetImageController::class, 'store'])->name('store');
            Route::get('/{image}/edit', [PetImageController::class, 'edit'])->name('edit');
            Route::put('/{image}', [PetImageController::class, 'update'])->name('update');

        });


        Route::group(['prefix' => 'rarities', 'as' => 'rarities.'], function(){
            Route::get('/', [PetRarityController::class, 'index'])->name('index');
            Route::put('/{rarity}', [PetRarityController::class, 'update'])->name('update');
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

        Route::group(['prefix' => 'inventories', 'as' => 'inventories.'], function(){
            Route::get('/', [\App\Http\Controllers\Admin\User\InventoryController::class, 'index'])->name('index');
            Route::get('/search', [\App\Http\Controllers\Admin\User\InventoryController::class, 'search'])->name('search');
            Route::get('/{itemUser}/edit', [InventoryController::class, 'edit'])->name('edit');
            Route::put('/{itemUser}', [InventoryController::class, 'update'])->name('update');
            Route::get('/create', [InventoryController::class, 'create'])->name('create');
            Route::post('/store', [InventoryController::class, 'store'])->name('store');

        });

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');

        Route::group(['prefix' => 'registration_applications', 'as' => 'registration_applications.'], function(){
            Route::get('/', [RegistrationApplicationController::class, 'index'])->name('index');
            Route::put('/{application}', [RegistrationApplicationController::class, 'update'])->name('update');
            Route::delete('/{application}', [RegistrationApplicationController::class, 'destroy'])->name('destroy');
        });

    });


    Route::group(['prefix' => 'fortune_wheel', 'as' => 'fortune_wheel.'], function(){
        Route::get('/', [FortuneWheelController::class, 'index'])->name('index');
        Route::group(['prefix' => 'prizes', 'as' => 'prizes.'], function(){
            Route::get('/create', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'store'])->name('store');
            Route::get('/{prize}/edit', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'edit'])->name('edit');
            Route::put('/{prize}', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'update'])->name('update');
            Route::delete('/{prize}', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'destroy'])->name('delete');
        });



        Route::get('/', [\App\Http\Controllers\Admin\FortuneWheelController::class, 'index'])->name('index');

    });

    Route::get('/', [AdminController::class, 'index'])->name('index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
