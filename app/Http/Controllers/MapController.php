<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Media;
use App\Models\Animal;

class MapController extends Controller
{
    /**
     * Return JSON data for all locations that have media,
     * including an HTML snippet of animals at that location.
     *
     * @param Request $request
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
            $animals = Animal::whereIn('id', $animalIds)->get(['id', 'common_name'])->sortBy('common_name');

            // Generate an HTML list of animal links.
            $animalListHtml = '<ul class="max-w-md space-y-1 list-inside">';
            foreach ($animals as $animal) {
                // Create a link to the animal's detail page. Adjust route/path as needed.
                $link = route('catalogue.show', $animal->id);
                $animalListHtml .= "<li><a href='{$link}' class='text-blue-500 hover:underline' target='#'>{$animal->common_name}</a></li>";
            }
            $animalListHtml .= '</ul>';
            

            $data[] = [
                'location_id'    => $location->id,
                'location_name'  => $location->name,
                'image'          => $location->image, // You might want to use asset() if this is a public file.
                'area_caption'   => $location->area_caption,
                'latitude'       => $location->latitude,
                'longitude'      => $location->longitude,
                'animal_list_html' => $animalListHtml,
            ];
        }

        return response()->json($data);
    }
}
