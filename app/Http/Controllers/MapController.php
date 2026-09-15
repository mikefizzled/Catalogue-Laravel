<?php

namespace App\Http\Controllers;

use App\Models\Location;

class MapController extends Controller
{
    /**
     * Return JSON data for all locations that have media,
     * including an HTML snippet of animals at that location.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoordinatesAndAnimals()
    {
        // Get all locations that have at least one media record.
        $locations = Location::whereHas('media.animal')->get();

        $data = [];

        foreach ($locations as $location) {
            $animals = $location->media
                ->pluck('animal')
                ->filter()
                ->unique('id')
                ->sortBy('common_name')
                ->values()
                ->map(function ($animal) {
                    $animal->url = route('birds.show', $animal);

                    return $animal;
                });

            $data[] = [
                'location_id' => $location->id,
                'location_name' => $location->name,
                'area_caption' => $location->area_caption,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'animals' => $animals,
            ];
        }

        return response()->json($data);
    }
}
