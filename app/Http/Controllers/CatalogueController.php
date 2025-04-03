<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Order;
use App\Models\Animal;
use App\Models\Family;
use App\Models\Location;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        // Start with the Animal query
        $query = Animal::query();
    
        // If an order filter is provided, filter using the relationship (assuming Animal->genus->family->order exists)
        if ($request->filled('order')) {
            $query->whereHas('genus.family.order', function ($q) use ($request) {
                $q->where('id', $request->order);
            });
        }
    
        // If a family filter is provided, filter by that
        if ($request->filled('family')) {
            $query->whereHas('genus.family', function ($q) use ($request) {
                $q->where('id', $request->family);
            });
        }
    
        // Order the animals and paginate them
        $animals = $query->orderBy('common_name', 'asc')->paginate(30);
    
        // Transform thumbnails from S3 URL if needed
        $animals->getCollection()->transform(function ($animal) {
            $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
            return $animal;
        });
    
        // Also load orders and families for the filters
        $orders = Order::orderBy('order_name')->get();
        $families = Family::orderBy('family_name')->get();
    
        return view('catalogue.index', compact('orders', 'families', 'animals'));
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->thumbnail_url = FileHelper::collectAnimalThumbnail($animal->thumbnail_url);
        $animal->load('conservationStatuses');

        // Collect media
        $images = Media::getVisualMediaForAnimal($id);
        $audioClips = Media::getAudioForAnimal($id);

        // Organise media s3 links and metadata
        $images = FileHelper::processMediaCollection($images);
        $audioClips = FileHelper::processMediaCollection($audioClips);
        $locations = Location::getForAnimal($id);
        return view('catalogue.show', compact('animal', 'images', 'audioClips', 'locations'));
    }

    /**
     *
     * Filter by selected family or order
     */
    public function getFilteredBirds(Request $request)
    {
        $orderId = $request->query('order');
        $familyId = $request->query('family');

        $query = Animal::query();

        if ($orderId) {
            $query->whereHas('genus.family.order', function ($q) use ($orderId) {
                $q->where('id', $orderId);
            });
        }

        if ($familyId) {
            $query->whereHas('genus.family', function ($q) use ($familyId) {
                $q->where('id', $familyId);
            });
        }

        $animals = $query->orderBy('common_name')->get(['id', 'common_name']);

        return response()->json($animals);
    }

    public function getFamilies(Request $request)
    {
        $query = Family::orderBy('family_name');
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }
        $families = $query->get();
        return response()->json($families);
    }

}
