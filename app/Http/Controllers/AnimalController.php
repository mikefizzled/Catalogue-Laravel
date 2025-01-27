<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use App\Models\Animal;
use Illuminate\Http\Request;
use App\Models\ConservationList;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animals = Animal::orderBy('common_name', 'asc')->paginate(20);

        $animals->getCollection()->transform(function ($animal) {
            $animal->thumbnail_url = Storage::disk('s3')->url('thumbnails/' . $animal->thumbnail_url);
            return $animal;
        });

        return view('admin.animals.index', ['animals' => $animals]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genera = Genus::orderBy('genus_name', 'asc')->get();
        $conservationLists = ConservationList::orderBy('short_name', 'asc')->get();
    
        return view('admin.animals.create')->with([
            'genera' => $genera,
            'conservationLists' => $conservationLists
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        //
    }
}
