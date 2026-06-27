<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenusRequest;
use App\Models\Family;
use App\Models\Genus;

class GenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genera = Genus::orderBy('genus_name', 'asc')->paginate(20);

        return view('admin.genera.index', ['taxa' => $genera]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genus = new Genus;

        $families = Family::orderBy('family_name')
            ->pluck('family_name', 'id')
            ->toArray();

        return view('admin.genera.create', compact('genus', 'families'));
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
        $families = Family::orderBy('family_name')
            ->pluck('family_name', 'id')
            ->toArray();

        return view('admin.genera.edit', compact('genus', 'families'));
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
        if ($genus->animals()->count()) {
            return redirect()
                ->route('admin.genera.index')
                ->with('error', 'Cannot delete a genus that still has birds.');
        }

        $genus->delete();

        return redirect()
            ->route('admin.genera.index')
            ->with('success', 'Genus deleted successfully.');
    }
}
