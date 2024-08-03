<?php

use App\Http\Controllers\Admin\PetController;
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

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::group(['prefix' => 'pets', 'as' => 'pets.'], function(){
        Route::get('/', [PetController::class, 'index'])->name('index');
    });
        
    Route::get('/', [AdminController::class, 'index'])->name('index');
});