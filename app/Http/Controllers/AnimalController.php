<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use App\Models\Animal;
use App\Helpers\FileHelper;
use App\Http\Requests\AnimalUpdateRequest;
use App\Models\ConservationList;
use App\Models\ConservationStatus;
use App\Http\Requests\AnimalCreateRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animals = Animal::orderBy('common_name', 'asc')->paginate(20);

        $animals->getCollection()->transform(function ($animal) {
            $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
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
            'conservationLists' => $conservationLists
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnimalCreateRequest $request)
    {
        $bird = new Animal();
        $bird->common_name = $request->common_name;
        $bird->scientific_name = $request->scientific_name;
        $bird->genus_id = $request->genus_id;
        
        $thumbnail = $request->File('thumbnail');

        $extension = $thumbnail->getClientOriginalExtension();
        $bird->generateSlug();
        $bird->thumbnail_url = FileHelper::generateFileName($bird->slug, '-thumbnail', $extension);
        
        $thumbnail->storeAs('thumbnails', $bird->thumbnail_url, 's3');

        $bird->save();

        // Adding each of the 6 report statuses to link table
        foreach ($request->statuses as $conservationListId => $status) {
           ConservationStatus::create([
               'animal_id' => $bird->id,
               'conservation_list_id' => $conservationListId,
               'status' => $status,
            ]);
        }
        return redirect()->route('admin.animals.show', $bird)->with('success', 'Bird created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
        $animal->load('conservationStatuses');
        return view('admin.animals.show', ['animal' => $animal]);

    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        $genera = Genus::orderBy('genus_name', 'asc')->get();
    
        $conservationLists = ConservationList::orderBy('short_name', 'asc')->get();
    
        $animal->load('conservationStatuses');
    
        return view('admin.animals.edit')->with([
            'animal'             => $animal,
            'genera'             => $genera,
            'conservationLists'  => $conservationLists,
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(AnimalUpdateRequest $request, Animal $animal)
    {
        // Get all validated data.
        $data = $request->validated();
        unset($data['statuses']);

        // Only if new thumbnail is provided
        if ($request->hasFile('thumbnail')) {
            // Remove old thumbnail from s3
            Storage::disk('s3')->delete('thumbnails/'.$animal->thumbnail_url);
            
            // Process new to conform to naming convention
            $thumbnail = $request->file('thumbnail');
            $animal->generateSlug();
            $extension = $thumbnail->getClientOriginalExtension();
            // Add the new filename to Animal data
            $data['thumbnail_url'] = FileHelper::generateFileName($extension, $animal->slug, '-thumbnail');

            // Upload into thumbnails in s3 storage
            $thumbnail->storeAs('thumbnails', $data['thumbnail_url'], 's3');
        }

        // Update pre-existing bird via eloquent
        $animal->update($data);

        foreach ($request->statuses as $conservationListId => $status) {
            ConservationStatus::where('animal_id', $animal->id)
                ->where('conservation_list_id', $conservationListId)
                ->update(['status' => $status]);
        }
    
        return redirect()->route('admin.animals.show', $animal)
                         ->with('success', 'Bird updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        //
    }
}
