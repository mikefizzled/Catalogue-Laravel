<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Animal;
use App\Models\Location;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class AdminMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mediaItems = Media::orderBy('id', 'desc')->paginate(10);

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
        
        // Get data for new filenames
        $animalSlug = Animal::getSlug($request->animal_id);
        $newTotal = Media::nextMediaNumber($request->animal_id);
        $extension = strtolower($file->getClientOriginalExtension());

        // Generate filenames for both original and thumbnail
        $filename = FileHelper::generateFileName($animalSlug, "-image-{$newTotal}", $extension);
        $thumbnailName = FileHelper::generateFileName($animalSlug, "-thumb-{$newTotal}", $extension);

        $tempPath = $file->storeAs('temp', $filename, 'public');

        $test = Storage::disk('public')->path($tempPath);
        
    
        // Collect metadata from file
        $exif = exif_read_data($test);
        $metadata = FileHelper::collectMetadata($exif);
        $dateTaken = FileHelper::formatDate($exif['DateTimeOriginal'] ?? null);

        $manager = new ImageManager(new ImagickDriver());

        $output = FileHelper::compressAndRemoveMeta($test, $extension);


        $hash = hash_file('sha256', Storage::disk('public')->path($tempPath));
        $image = $manager->read(file_get_contents($test))->resize(400, 225);
        
        $imageBinary = $image->encode(new JpegEncoder());



        Storage::disk('s3')->put('media\\'.$thumbnailName, (string) $imageBinary, 'public');
        Storage::disk('s3')->put('media\\' . $filename, file_get_contents($test));
        $compSize =  filesize(Storage::disk('public')->path($tempPath));
        clearstatcache();
        $metadata['filesize'] = FileHelper::formatFilesize($compSize);
        $media = Media::create([
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
            'metadata' => json_encode($metadata),
            'hash' => $hash
         ]);
        
        Storage::disk('public')->delete(['\\temp\\'.$filename, '\\temp\\'.$thumbnailName]);
       
        return redirect()->route('admin.media.show', $media)->with('success', 'Bird created successfully!');
        }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {

        $previous = Media::where('id', '<', $media->id)->orderBy('id', 'desc')->first();
        $next = Media::where('id', '>', $media->id)->orderBy('id', 'asc')->first();
        $media->media_url = Storage::disk('s3')->url('media/' . $media->media_url);
        $metadata = json_decode($media->metadata);

        return view('admin.media.show', compact('media', 'metadata', 'previous', 'next'));
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
        //2025-02-13 02:34:02
        //2024-06-20 16:03:05
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}
