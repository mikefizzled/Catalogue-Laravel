<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\EBirdTaxonomyController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\GenusController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('orders', AdminOrderController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('genera', GenusController::class);
    Route::resource('animals', AnimalController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('media', AdminMediaController::class)->parameters([
        'media' => 'media',
    ]);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('search-species', [AdminMediaController::class, 'searchSpecies']);
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

});
Route::get('/search-ebird', [EBirdTaxonomyController::class, 'search'])->middleware(['auth']);
Route::get('/conservation-status', [EBirdTaxonomyController::class, 'fetchBoccData'])->middleware(['auth']);

Route::get('/taxonomy-json-with-genera', [EBirdTaxonomyController::class, 'taxonomyJsonWithGenera']);
Route::get('/taxonomy-json-without-genera', [EBirdTaxonomyController::class, 'taxonomyJsonWithoutGenera']);

Route::get('/birds', [CatalogueController::class, 'index'])->name('birds.index');
Route::get('/birds/{animal:slug}', [CatalogueController::class, 'show'])->name('birds.show');

Route::get('/filtered-birds', [CatalogueController::class, 'getFilteredBirds']);

Route::get('/get_orders', [CatalogueController::class, 'getOrders']);
Route::get('/get_families', [CatalogueController::class, 'getFamilies']);
Route::get('/animals', [CatalogueController::class, 'getAnimals']);

Route::get('/taxonomy', function () {
    return view('taxonomy');
})->name('taxonomy');
Route::get('/map', function () {
    return view('map');
})->name('map');

Route::get('/map-data', [MapController::class, 'getCoordinatesAndAnimals'])->name('map.data');

Route::get('/conservation', [EBirdTaxonomyController::class, 'conservation'])->name('conservation');
Route::view('/changelog', 'changelog')->name('changelog');

Route::view('/about', 'about')->name('about');
