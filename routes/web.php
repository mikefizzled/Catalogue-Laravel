<?php

use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\GenusController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SpeciesLookupController;
use App\Http\Controllers\BirdController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConservationController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', OrderController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('genera', GenusController::class);
    Route::resource('animals', AnimalController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('media', MediaController::class)->parameters([
        'media' => 'media',
    ]);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('search-species', [MediaController::class, 'searchSpecies']);
});
Route::get('/search-ebird', [SpeciesLookupController::class, 'search'])->middleware(['auth']);
Route::get('/conservation-status', [SpeciesLookupController::class, 'fetchBoccData'])->middleware(['auth']);

Route::get('/birds', [BirdController::class, 'index'])->name('birds.index');
Route::get('/birds/{animal:slug}', [BirdController::class, 'show'])->name('birds.show');

Route::get('/get_orders', [BirdController::class, 'getOrders']);
Route::get('/get_families', [BirdController::class, 'getFamilies']);
Route::get('/animals', [BirdController::class, 'getAnimals']);

Route::get('/taxonomy', function () {
    return view('taxonomy');
})->name('taxonomy');
Route::get('/map', function () {
    return view('map');
})->name('map');

Route::get('/map-data', [MapController::class, 'getCoordinatesAndAnimals'])->name('map.data');

Route::get('/conservation', [ConservationController::class, 'conservation'])->name('conservation');

Route::view('/changelog', 'changelog')->name('changelog');

Route::view('/about', 'about')->name('about');
