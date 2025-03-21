<?php

use App\Http\Controllers\Admin\FortuneWheelController;
use App\Http\Controllers\Admin\PetCategoryController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PetImageController;
use App\Http\Controllers\Admin\PetNameController;
use App\Http\Controllers\Admin\PetRarityController;
use App\Http\Controllers\Admin\PetUserController as UserPetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserInventoryController;
use App\Http\Controllers\Admin\UserRegistrationApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
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


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [MainController::class, 'index'])->name('main.index');
    Route::get('/admin', function (){
        return redirect()->route('main.index');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {


        Route::group(['prefix' => 'pets', 'as' => 'pets.'], function () {
            Route::get('/', [PetController::class, 'index'])->name('index');
            Route::get('/create', [PetController::class, 'create'])->name('create');
            Route::post('/store', [PetController::class, 'store'])->name('store');
            Route::get('/{pet}/edit', [PetController::class, 'edit'])->name('edit');
            Route::put('/{pet}', [PetController::class, 'update'])->name('update');
            Route::delete('/{pet}', [PetController::class, 'delete'])->name('delete');


            Route::group(['prefix' => 'images', 'as' => 'images.'], function () {
                Route::get('/', [PetImageController::class, 'index'])->name('index');
                Route::get('/create', [PetImageController::class, 'create'])->name('create');
                Route::post('/store', [PetImageController::class, 'store'])->name('store');
                Route::get('/{image}/edit', [PetImageController::class, 'edit'])->name('edit');
                Route::put('/{image}', [PetImageController::class, 'update'])->name('update');
                Route::delete('/{image}', [PetImageController::class, 'destroy'])->name('destroy');
            });


            Route::group(['prefix' => 'rarities', 'as' => 'rarities.'], function () {
                Route::get('/', [PetRarityController::class, 'index'])->name('index');
                Route::put('/{rarity}', [PetRarityController::class, 'update'])->name('update');
            });

            Route::group(['prefix' => 'names', 'as' => 'names.'], function () {
                Route::get('/', [PetNameController::class, 'index'])->name('index');
                Route::get('/create', [PetNameController::class, 'create'])->name('create');
                Route::post('/store', [PetNameController::class, 'store'])->name('store');
                Route::get('/{name}/edit', [PetNameController::class, 'edit'])->name('edit');
                Route::put('/{name}', [PetNameController::class, 'update'])->name('update');

            });

            Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
                Route::get('/', [PetCategoryController::class, 'index'])->name('index');
                Route::get('/create', [PetCategoryController::class, 'create'])->name('create');
                Route::post('/store', [PetCategoryController::class, 'store'])->name('store');
                Route::get('/{category}/edit', [PetCategoryController::class, 'edit'])->name('edit');
                Route::put('/{category}', [PetCategoryController::class, 'update'])->name('update');

            });
        });
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {

            Route::group(['prefix' => 'pets', 'as' => 'pets.'], function () {
                Route::get('/', [UserPetController::class, 'index'])->name('index');
                Route::get('/search', [UserPetController::class, 'search'])->name('search');
            });

            Route::group(['prefix' => 'inventories', 'as' => 'inventories.'], function () {
                Route::get('/', [\App\Http\Controllers\Admin\UserInventoryController::class, 'index'])->name('index');
                Route::get('/search', [\App\Http\Controllers\Admin\UserInventoryController::class, 'search'])->name('search');
                Route::get('/{itemUser}/edit', [UserInventoryController::class, 'edit'])->name('edit');
                Route::put('/{itemUser}', [UserInventoryController::class, 'update'])->name('update');
                Route::get('/create', [UserInventoryController::class, 'create'])->name('create');
                Route::post('/store', [UserInventoryController::class, 'store'])->name('store');
                Route::delete('/{itemUser}', [UserInventoryController::class, 'destroy'])->name('destroy');

            });

            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');

            Route::group(['prefix' => 'registration_applications', 'as' => 'registration_applications.'], function () {
                Route::get('/', [UserRegistrationApplicationController::class, 'index'])->name('index');
                Route::put('/{application}', [UserRegistrationApplicationController::class, 'update'])->name('update');
                Route::delete('/{application}', [UserRegistrationApplicationController::class, 'destroy'])->name('destroy');
            });

        });


        Route::group(['prefix' => 'fortune_wheel', 'as' => 'fortune_wheel.'], function () {
            Route::get('/', [FortuneWheelController::class, 'index'])->name('index');
            Route::group(['prefix' => 'prizes', 'as' => 'prizes.'], function () {
                Route::get('/create', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'create'])->name('create');
                Route::post('/store', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'store'])->name('store');
                Route::get('/{prize}/edit', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'edit'])->name('edit');
                Route::put('/{prize}', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'update'])->name('update');
                Route::delete('/{prize}', [\App\Http\Controllers\Admin\FortunePrizeController::class, 'destroy'])->name('delete');
            });


            Route::get('/', [\App\Http\Controllers\Admin\FortuneWheelController::class, 'index'])->name('index');

        });

    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('main.index');
    })->name('dashboard');
});
