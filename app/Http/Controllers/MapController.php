<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Location;
use App\Models\Media;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Return JSON data for all locations that have media,
     * including an HTML snippet of animals at that location.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoordinatesAndAnimals(Request $request)
    {
        // Get all locations that have at least one media record.
        $locations = Location::whereHas('media')->get();

        $data = [];

        foreach ($locations as $location) {
            // Get distinct animal IDs for media at this location.
            $animalIds = Media::where('location_id', $location->id)
                ->distinct()
                ->pluck('animal_id');

            // Retrieve the animals (only id and common_name are needed).
            $animals = Animal::whereIn('id', $animalIds)
                ->orderBy('common_name')
                ->get(['common_name', 'slug']);

            // Add the URLs to the collections of birds
            $animals = $animals->map(function ($s) {
                $s->url = route('birds.show', $s);

                return $s;
            });

            $data[] = [
                'location_id' => $location->id,
                'location_name' => $location->name,
                'image' => $location->image,
                'area_caption' => $location->area_caption,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'animals' => $animals,
            ];
        }

        return response()->json($data);
    }
}
