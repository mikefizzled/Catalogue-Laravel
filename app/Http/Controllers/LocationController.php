<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::orderBy('name', 'asc')->paginate(10);

        $locations->getCollection()->transform(function ($location) {
            $location->image = $location->image ? Storage::disk('s3')->url('locations/' . $location->image) : asset('images/location-placeholder.svg');
            return $location;
        });

        return view('admin.locations.index', ['locations' => $locations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allLocations = Location::all();
        return view('admin.locations.create', compact('allLocations'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'city'         => 'nullable|string|max:255',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'caption'      => 'nullable|string|max:500',
            'image'        => 'nullable|image|mimes:jpg,webp',
        ]);

        // Just ignoring the images for now
        $imagePath = null;
        
        $location = Location::create([
            'name'         => $validated['name'],
            'city'         => $validated['city'] ?? null,
            'latitude'     => $validated['latitude'],
            'longitude'    => $validated['longitude'],
            'area_caption' => $validated['caption'] ?? null,
            'image'        => $imagePath,
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Location added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return view('admin.locations.show', compact('location'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        $allLocations = Location::all();
        return view('admin.locations.edit', compact('location','allLocations'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        if ($location->media()->count()) {
            return redirect()
                ->route('admin.locations.index')
                ->with('error', 'Cannot delete a location that still has media associated.');
        }

        $location->delete(); 

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
