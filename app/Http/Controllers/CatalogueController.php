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
    
        // If a family filter is provided, filter by that
        if ($request->filled('family')) {
            $query->whereHas('genus.family', function ($q) use ($request) {
                $q->where('slug', $request->family);
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
        $families = Family::select('families.*')
            ->join('orders', 'families.order_id', '=', 'orders.id')
            ->with('order')
            ->orderBy('orders.order_name')
            ->orderBy('families.common_name')
            ->get();
    
        return view('birds.index', compact('orders', 'families', 'animals'));
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        $animal->thumbnail_url = FileHelper::collectAnimalThumbnail($animal->thumbnail_url);
        $animal->load(['conservationStatuses', 'resources']);

        // Collect media
        $images = Media::getVisualMediaForAnimal($animal->id);
        $audioClips = Media::getAudioForAnimal($animal->id);
        
        // Organise media s3 links and metadata
        $images = FileHelper::processMediaCollection($images);
        $audioClips = FileHelper::processMediaCollection($audioClips);
        $locations = Location::getForAnimal($animal->id);
        
        return view('birds.show', compact('animal', 'images', 'audioClips', 'locations'));
    }


    /**
     *
     * Filter by selected family or order
     */
    public function getFilteredBirds(Request $request)
    {
        $familySlug = $request->query('family');

        $query = Animal::query();

        if ($familySlug) {
            $query->whereHas('genus.family', function ($q) use ($familySlug) {
                $q->where('slug', $familySlug);
            });
        }

        $animals = $query->orderBy('common_name')->get(['id', 'common_name', 'slug']);

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
