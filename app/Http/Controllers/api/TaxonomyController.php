<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaxonomyController extends Controller
{
    // Return either order -> family -> genus -> animals
    // or order -> family -> animals, depending on include_genera.
   
    public function taxonomy(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'include_genera' => ['sometimes', 'in:true,false'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid query parameter.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $includeGenera = $request->query('include_genera') === 'true';

        $taxonomy = Order::with('families.genera.animals')->get();

        $jsonStructure = [
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => $taxonomy->map(function ($order) use ($includeGenera) {
                return [
                    'name' => $order->order_name,

                    'children' => $order->families->map(function ($family) use ($includeGenera) {
                        return [
                            'name' => $family->family_name,
                            'details' => $family->common_name,

                           // Include genus nodes, or flatten their animals directly into the family
                            'children' => $includeGenera
                                ? $family->genera->map(function ($genus) {
                                    return [
                                        'name' => $genus->genus_name,
                                        'children' => $genus->animals->map(function ($animal) {
                                            return $this->animalToArray($animal);
                                        })->toArray(),
                                    ];
                                })->toArray()

                                : $family->genera->flatMap(function ($genus) {
                                    return $genus->animals->map(function ($animal) {
                                        return $this->animalToArray($animal);
                                    });
                                })->toArray(),
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];

        return response()->json([
            'data' => $jsonStructure,
            'meta' => [
                'include_genera' => $includeGenera,
            ],
        ]);
    }

    private function animalToArray(Animal $animal): array
    {
        return [
            'name' => $animal->common_name,
            'url' => '/birds/'.$animal->slug,
            'image' => Storage::disk('s3')->url('thumbnails/'.$animal->thumbnail_url),
            'details' => $animal->scientific_name,
        ];
    }
}
