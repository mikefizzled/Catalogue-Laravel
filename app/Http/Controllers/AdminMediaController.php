<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Animal;
use App\Models\Location;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;

class AdminMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mediaItems = Media::orderBy('created_at', 'asc')->paginate(20);

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


        $thumbnail = $request->File('media');
        $exif = exif_read_data($thumbnail->getPathname());
 
        $metadata = FileHelper::collectMetadata($exif);


        $data['animal_id'] = $request->animal_id;

        $data['location_id'] = $request->location_id;
        //$data['media_url']   = $mediaPath;
        //$data['thumbnail_url'] = $thumbnailPath;
        $data['media_type']  = $request->media_type;
        $data['rating']      = $request->rating ?? null;
        $data['caption']     = $request->caption;
        $data['gender']      = $request->gender;
        $data['age']         = $request->age;
        
        $data['datetaken'] = FileHelper::formatDate($exif['DateTimeOriginal']);
        $data['metadata']    = $metadata;
        dd($data);
    
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
