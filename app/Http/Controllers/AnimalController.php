<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use App\Models\Genus;
use App\Models\Media;
use App\Services\ConservationService;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animals = Animal::orderBy('common_name', 'asc')->paginate(20);

        $animals->getCollection()->transform(function ($animal) {
            $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/'.$animal->thumbnail_url);

            return $animal;
        });

        return view('admin.animals.index', ['animals' => $animals]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genera = Genus::orderBy('genus_name', 'asc')->get();
        $conservationLists = ConservationList::orderBy('short_name', 'asc')->get();

        return view('admin.animals.create')->with([
            'genera' => $genera,
            'conservationLists' => $conservationLists,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bird = new Animal;

        $bird->fill($request->only(['common_name', 'scientific_name', 'genus_id', 'ebird_species_code']));
        $bird->generateSlug();

        $thumbnail = $request->File('thumbnail');

        $bird->thumbnail_url = MediaService::storeThumbnail($thumbnail, $bird->slug);
        $bird->save();

        // for capturing the criteria
        $bocc5StatusId = null;
        $bocc5aStatusId = null;

        // Adding each of the 6 report statuses to the link table
        foreach ($request->statuses as $conservationListId => $status) {
            $conservationStatus = ConservationStatus::create([
                'animal_id' => $bird->id,
                'conservation_list_id' => $conservationListId,
                'status' => $status,
            ]);

            // Save status ID to match with criteria
            if ($conservationListId == 5) {
                $bocc5StatusId = $conservationStatus->id;
            } elseif ($conservationListId == 6) {
                $bocc5aStatusId = $conservationStatus->id;
            }
        }

        // Use the service to attach BoCC criteria
        ConservationService::attachBoccCriteria($bocc5StatusId, $request->bocc_5_criteria);
        ConservationService::attachBoccCriteria($bocc5aStatusId, $request->bocc_5a_criteria);

        return redirect()->route('admin.animals.show', $bird)->with('success', 'Bird created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/'.$animal->thumbnail_url);

        $animal->load('conservationStatuses.criteria.boccCriteria');

        // Fetch all media related to the animal
        $mediaItems = Media::where('animal_id', $animal->id)->get();

        // Transform media URLs to include full S3 paths
        $mediaItems->transform(function ($media) {
            if ($media->media_type === 'audio') {
                $media->thumbnail_url = Media::defaultAudioThumbnail();
            } else {
                $media->thumbnail_url = Storage::disk('s3')->url('media/'.$media->thumbnail_url);
            }

            return $media;
        });

        return view('admin.animals.show', compact('animal', 'mediaItems'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        $genera = Genus::orderBy('genus_name', 'asc')
            ->pluck('genus_name', 'id')
            ->toArray();

        $conservationLists = ConservationList::orderBy('short_name', 'asc')->get();

        $existingStatuses = $animal
            ->conservationStatuses
            ->pluck('status', 'conservation_list_id')
            ->toArray();
        $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/'.$animal->thumbnail_url);
        $animal->load('conservationStatuses.criteria.boccCriteria');

        return view('admin.animals.edit')->with([
            'animal' => $animal,
            'genera' => $genera,
            'conservationLists' => $conservationLists,
            'existingStatuses' => $existingStatuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $bird)
    {
        $validated = $request->validate([
            'common_name' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'genus_id' => 'required|exists:genera,id',
            'ebird_species_code' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,webp|max:5120',
            'statuses' => 'required|array',
            'statuses.*' => 'required|string',
            'bocc_5_criteria' => 'nullable|string',
            'bocc_5a_criteria' => 'nullable|string',
        ]);

        // Update core bird fields
        $bird->update([
            'common_name' => $validated['common_name'],
            'scientific_name' => $validated['scientific_name'],
            'genus_id' => $validated['genus_id'],
            'ebird_species_code' => $validated['ebird_species_code'] ?? $bird->ebird_species_code,
        ]);

        // Handle thumbnail replacement
        if ($request->hasFile('thumbnail')) {
            $bird->thumbnail_url = MediaService::storeThumbnail(
                $request->file('thumbnail'),
                $request->slug,
            );
            $bird->update();
        }

        /* Update statuses & criteria exactly as in store()
        $bocc5Id  = null;
        $bocc5aId = null;

        foreach ($validated['statuses'] as $listId => $status) {
            $cs = ConservationStatus::updateOrCreate(
                ['animal_id' => $bird->id, 'conservation_list_id' => $listId],
                ['status'    => $status]
            );
            if ($listId == 5)  $bocc5Id  = $cs->id;
            if ($listId == 6)  $bocc5aId = $cs->id;
        }

        ConservationService::attachBoccCriteria($bocc5Id,  $validated['bocc_5_criteria']  ?? '');
        ConservationService::attachBoccCriteria($bocc5aId, $validated['bocc_5a_criteria'] ?? '');
        */
        return redirect()
            ->route('admin.animals.show', $bird)
            ->with('success', 'Bird updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        DB::transaction(function () use ($animal) {
            if ($animal->thumbnail_url) {
                MediaService::deleteFromS3('thumbnails', $animal->thumbnail_url);
            }

            foreach ($animal->conservationStatuses as $status) {
                ConservationService::deleteConservationStatus($status);
            }

            // Need to create a function for deleting all associated media
            /*foreach ($bird->media as $media) {
                MediaService::deleteMedia($media);
            }*/

            $animal->delete();
        });

        return redirect()->route('admin.animals.index')->with('success', 'Animal deleted successfully!');
    }
}
