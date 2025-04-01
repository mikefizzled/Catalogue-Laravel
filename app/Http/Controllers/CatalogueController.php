<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Animal;
use App\Helpers\FileHelper;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    public function index()
    {
        $animals = Animal::orderBy('common_name', 'asc')->paginate(30);

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
        $animal->thumbnail_url = FileHelper::collectAnimalThumbnail($animal->thumbnail_url);
        $animal->load('conservationStatuses');

        // Collect media
        $images = Media::getVisualMediaForAnimal($id);
        $audioClips = Media::getAudioForAnimal($id);

        // Organise media s3 links and metadata
        $images = FileHelper::processMediaCollection($images);
        $audioClips = FileHelper::processMediaCollection($audioClips);
        $locations = Location::getForAnimal($id);
        return view('catalogue.show', compact('animal', 'images', 'audioClips', 'locations'));
    }
}
