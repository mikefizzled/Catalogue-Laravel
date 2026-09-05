<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Location;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
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

            $media->thumbnail_url = Storage::disk('s3')->url('media/'.$media->thumbnail_url);

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

        $metadata = json_decode($media->metadata, true) ?? [];

        return view('admin.media.show', compact('media', 'metadata', 'previous', 'next'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        $media->media_url = Storage::disk('s3')->url('media/'.$media->media_url);
        $metadata = json_decode($media->metadata);

        return view('admin.media.edit', ['media' => $media,
            'animals' => Animal::orderBy('common_name', 'asc')->get(),
            'locations' => Location::orderBy('name', 'asc')->get(),
            'genders' => Media::GENDERS,
            'ages' => Media::AGES,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        $keys = $request->input('meta_keys', []);
        $values = $request->input('meta_values', []);

        $metadata = [];

        foreach ($keys as $index => $key) {
            $trimmedKey = trim($key);

            if ($trimmedKey === '') {
                continue;
            }

            $metadata[$trimmedKey] = $values[$index] ?? '';
        }
        $metadataJson = json_encode($metadata);

        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'location_id' => 'nullable|exists:locations,id',
            'gender' => 'nullable|in:male,female,unknown',
            'age' => 'nullable|in:juvenile,adult,unknown',
            'caption' => 'nullable|string|max:1000',
            'hash' => 'nullable|string|max:255',
            'metadata' => 'nullable|json',
        ]);

        $media->update([
            'animal_id' => $request->input('animal_id'),
            'location_id' => $request->input('location_id'),
            'date_taken' => $media->date_taken,
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'caption' => $request->input('caption'),
            'hash' => $request->input('hash'),
            'metadata' => $metadataJson,
        ]);

        return redirect()
            ->route('admin.media.show', $media)
            ->with('success', 'Media updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        Storage::disk('s3')->delete('media/'.$media->thumbnail_url);
        Storage::disk('s3')->delete('media/'.$media->media_url);
        $media->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }
}
