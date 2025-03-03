<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    public function index()
    {
        $animals = Animal::orderBy('common_name', 'asc')->paginate(12);

        $animals->getCollection()->transform(function ($animal) {
            $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
            return $animal;
        });

        return view('catalogue.index', ['animals' => $animals]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
        $animal->load('conservationStatuses');

        $mediaItems = Media::where('animal_id', $id)
        ->orderBy('rating', 'desc')
        ->get();

        // Ensure media URLs are correct for S3 storage
        foreach ($mediaItems as $media) {
            $media->media_url = Storage::disk('s3')->url('media/' . $media->media_url);
            $media->metadata = json_decode($media->metadata);
        }


        return view('catalogue.show', ['animal' => $animal, 'mediaItems' => $mediaItems]);
    }
}
