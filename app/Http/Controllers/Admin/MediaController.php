<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
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

        return redirect()->route('admin.media.show', $media)->with('success', 'Media #'.$media->id.' added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        $previous = Media::where('id', '<', $media->id)->orderBy('id', 'desc')->first();
        $next = Media::where('id', '>', $media->id)->orderBy('id', 'asc')->first();

        return view('admin.media.show', compact('media', 'previous', 'next'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        $media->media_url = Storage::disk('s3')->url('media/'.$media->media_url);
        $metadata = $media->metadata;

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
    public function update(MediaRequest $request, Media $media)
    {
        $validated = $request->validated();

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

        $media->update([
            'animal_id' => $validated['animal_id'],
            'location_id' => $validated['location_id'],
            'gender' => $validated['gender'] ?? null,
            'age' => $validated['age'] ?? null,
            'caption' => $validated['caption'] ?? null,
            'hash' => $validated['hash'] ?? null,
            'metadata' => json_encode($metadata),
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
