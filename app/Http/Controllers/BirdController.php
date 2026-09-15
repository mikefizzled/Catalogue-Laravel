<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Family;
use App\Models\Location;
use App\Models\Order;
use Illuminate\Http\Request;

class BirdController extends Controller
{
    public function index(Request $request)
    {
        // Start with the Animal query
        $query = Animal::query();

        // If a family filter is provided, filter by that
        if ($request->filled('family')) {
            $query->whereHas('genus.family', function ($q) use ($request) {
                $q->where('slug', $request->family);
            });
        }

        // Order the animals and paginate them
        $animals = $query
            ->orderBy('common_name', 'asc')
            ->paginate(30);

        $orders = Order::with('families')
            ->orderBy('order_name')
            ->get();

        return view('birds.index', compact('orders', 'animals'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        $animal->load([
            'genus.family.order',
            'conservationStatuses.conservationList',
            'conservationStatuses.criteria.boccCriteria',
        ]);

        // Collect media
        $media = $animal->mediaOrderedByRating()->get();

        $locations = $animal->locations();

        return view('birds.show', compact('animal', 'media', 'locations'));
    }
}
