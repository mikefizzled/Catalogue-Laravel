<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
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
            $location->image = $location->image ? Storage::disk('s3')->url('locations/'.$location->image) : asset('images/location-placeholder.svg');

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
    public function store(LocationRequest $request)
    {
        $validated = $request->validated();

        // Just ignoring the images for now
        $imagePath = null;

        Location::create([
            'name' => $validated['name'],
            'city' => $validated['city'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'area_caption' => $validated['area_caption'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('admin.locations.show', Location::latest()->first())
            ->with('success', 'Location added successfully!');
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

        return view('admin.locations.edit', compact('location', 'allLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request, Location $location)
    {
        $validated = $request->validated();

        $location->update([
            'name' => $validated['name'],
            'city' => $validated['city'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'area_caption' => $validated['area_caption'] ?? null,
        ]);

        return redirect()
            ->route('admin.locations.show', $location)
            ->with('success', 'Location updated successfully!');
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
