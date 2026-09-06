<?php

namespace App\Http\Controllers;

use App\Models\ConservationList;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class TaxonomyController extends Controller
{
    public function conservation()
    {
        $conservationLists = ConservationList::get();

        return view('conservation', ['conservationLists' => $conservationLists]);
    }

    public function taxonomyJsonWithGenera()
    {
        $taxonomy = Order::with('families.genera.animals')->get();

        $jsonStructure = [
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => $taxonomy->map(function ($order) {
                return [
                    'name' => $order->order_name,
                    'children' => $order->families->map(function ($family) {
                        return [
                            'name' => $family->family_name,
                            'details' => $family->common_name,
                            'children' => $family->genera->map(function ($genus) {
                                return [
                                    'name' => $genus->genus_name,
                                    'children' => $genus->animals->map(function ($animal) {
                                        return [
                                            'name' => $animal->common_name,
                                            'url' => '/birds/'.$animal->slug,
                                            'image' => Storage::disk('s3')->url('thumbnails/'.$animal->thumbnail_url),
                                            'details' => $animal->scientific_name,
                                        ];
                                    })->toArray(),
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];

        return response()->json($jsonStructure);
    }

    public function taxonomyJsonWithoutGenera()
    {
        $taxonomy = Order::with('families.genera.animals')->get();

        $jsonStructure = [
            'name' => 'Aves',
            'details' => 'Birds',
            'children' => $taxonomy->map(function ($order) {
                return [
                    'name' => $order->order_name,
                    'children' => $order->families->map(function ($family) {
                        return [
                            'name' => $family->family_name,
                            'details' => $family->common_name,
                            'children' => $family->genera->flatMap(function ($genus) {
                                return $genus->animals->map(function ($animal) {
                                    return [
                                        'name' => $animal->common_name,
                                        'url' => '/birds/'.$animal->slug,
                                        'image' => Storage::disk('s3')->url('thumbnails/'.$animal->thumbnail_url),
                                        'details' => $animal->scientific_name,
                                    ];
                                });
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];

        return response()->json($jsonStructure);
    }
}
