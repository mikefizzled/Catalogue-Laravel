<?php

namespace App\Http\Controllers;

use App\Models\Genus;
use Illuminate\Http\Request;

class GenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genera = Genus::orderBy('genus_name', 'asc')->paginate(20);

        return view('taxonomy.index', ['taxa' => $genera, 'taxonType' => 'genera']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Genus $genus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genus $genus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genus $genus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genus $genus)
    {
        //
    }
}
