<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Animal;
use App\Models\Location;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Encoders\JpegEncoder;


class AdminMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mediaItems = Media::orderBy('created_at', 'asc')->paginate(20);

        $mediaItems->getCollection()->transform(function ($media) {
            $media->thumbnail_url = Storage::disk('s3')->url('media/' . $media->thumbnail_url);
            return $media;
        });


        return view('admin.media.index', ['mediaItems' => $mediaItems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.media.create', [
            'locations' => Location::orderBy('name', 'asc')->get(),
            'genders' => Media::GENDERS,
            'ages' => Media::AGES,
        ]);
    }
    public function searchSpecies(Request $request)
    {
        $query = $request->input('query');
        $results = Animal::where('common_name', 'LIKE', "%{$query}%")->take(3)->get();
        return response()->json($results);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->File('media');
        
        // Collect metadata from file
        $exif = exif_read_data($file->getPathname());
        $metadata = FileHelper::collectMetadata($exif);
        $dateTaken = FileHelper::formatDate($exif['DateTimeOriginal'] ?? null);

        // Get animal and media details
        $animalSlug = Animal::getSlug($request->animal_id);
        $previousMediaTotal = Media::countMedia($request->animal_id);

        // Generate filenames for both original and thumbnail
        $extension = $file->getClientOriginalExtension();
        $filename = FileHelper::generateFileName($extension, $animalSlug, "-media-{$previousMediaTotal}");
        $thumbnailName = FileHelper::generateFileName($extension, $animalSlug, "-thumb-{$previousMediaTotal}");
        
        $file->storeAs('media', $filename, 's3');
        
        $manager = new ImageManager(new ImagickDriver());
        $image = $manager->read($file)->resize(256, 144);
        $imageBinary = $image->encode(new JpegEncoder());

        Storage::disk('s3')->put("media/{$thumbnailName}", (string) $imageBinary, 'public');

        Media::create([
            'animal_id' => $request->animal_id,
            'location_id' => $request->location_id,
            'media_url' => $filename,
            'thumbnail_url' => $thumbnailName,
            'media_type' => 'image',
            'rating' => $request->rating ?? null,
            'date_taken' => $dateTaken,
            'caption' => $request->caption,
            'age' => $request->age,
            'gender' => $request->gender,
            'metadata' => $metadata
         ]);
        }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}
