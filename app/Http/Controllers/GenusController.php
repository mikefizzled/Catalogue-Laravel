<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenusRequest;
use App\Models\Genus;
use App\Models\Family;
use Illuminate\Http\Request;

class GenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genera = Genus::orderBy('genus_name', 'asc')->paginate(20);

        return view('admin.taxonomy.index', ['taxa' => $genera, 'taxonType' => 'genera']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $families = Family::orderBy('family_name', 'asc')->get();
        return view('admin.genera.create', ['families' => $families]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenusRequest $request)
    {
        $data = $request->validated();

        $genus = Genus::create([
            'genus_name' => $data['genus_name'],
            'family_id' => $data['family_id'],
        ]);

        return redirect()->route('admin.genera.show', $genus)->with('success', 'Genus created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genus $genus)
    {
        $genus->load('family');
        $genus->load('animals');
        return view('admin.genera.show', ['genus' => $genus]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genus $genus)
    {
        $families = Family::orderedByName()->get(['id','family_name']);
        return view('admin.genera.edit', ['genus' => $genus, 'families' => $families]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenusRequest $request, Genus $genus)
    {
        $genus->update($request->validated());
        return redirect()->route('admin.genera.show', $genus)->with('success', 'Genus update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genus $genus)
    {
        //
    }
}
