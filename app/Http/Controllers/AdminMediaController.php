<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Location;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mediaItems = Media::orderBy('id', 'desc')->paginate(10);

        $mediaItems->getCollection()->transform(function ($media) {
            if ($media->media_type === 'audio') {
                $media->thumbnail_url = Media::defaultAudioThumbnail();
            } else {
                $media->thumbnail_url = Storage::disk('s3')->url('media/'.$media->thumbnail_url);
            }

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
            'animals' => Animal::orderBy('common_name', 'asc')->get(),
            'locations' => Location::orderBy('name', 'asc')->get(),
            'genders' => Media::GENDERS,
            'ages' => Media::AGES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $media = MediaService::storeMedia($request);

        return redirect()->route('admin.media.show', $media)->with('success', 'Bird created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {

        $previous = Media::where('id', '<', $media->id)->orderBy('id', 'desc')->first();
        $next = Media::where('id', '>', $media->id)->orderBy('id', 'asc')->first();

        $media->media_url = Storage::disk('s3')->url('media/'.$media->media_url);

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
