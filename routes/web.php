<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenusController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('orders', AdminOrderController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('genera', GenusController::class);
    Route::resource('animals',AnimalController::class);
    Route::resource('locations',LocationController::class);
    Route::resource('media', AdminMediaController::class)->parameters([
        'media' => 'media',
    ]);
    



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('search-species', [AdminMediaController::class, 'searchSpecies']);
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

  
    //Route::resource('orders', OrderController::class);
});