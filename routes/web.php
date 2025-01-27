<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenusController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AnimalController;

Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';

//Route::resource('orders', OrderController::class)->middleware('auth');



Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('orders', AdminOrderController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('genera', GenusController::class);
    Route::resource('animals',AnimalController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');
    //Route::resource('orders', OrderController::class);
});