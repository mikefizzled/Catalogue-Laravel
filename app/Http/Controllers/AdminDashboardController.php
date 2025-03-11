<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use App\Models\Media;
use App\Models\Order;
use App\Models\Animal;
use App\Models\Family;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'mediaCount' => Media::count(),
            'animalCount' => Animal::count(),
            'orderCount' => Order::count(),
            'familyCount' => Family::count(),
            'genusCount' => Genus::count(),
            'locationCount' => Location::count(),
            
            'recentMedia' => Media::Where('media_type', 'image')->orderBy('created_at', 'desc')->take(3)->get()->transform(function ($media) {
                $media->thumbnail_url = Storage::disk('s3')->url('media/' . $media->thumbnail_url);
                return $media;
            }),
            
            'recentAnimals' => Animal::latest()->take(6)->get()->transform(function ($animal) {
                $animal->thumbnail_url =  Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
                return $animal;
            }),
        ]);
    }
}
