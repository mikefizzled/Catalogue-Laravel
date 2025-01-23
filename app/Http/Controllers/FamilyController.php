<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyRequest;
use App\Models\Family;
use App\Models\Order;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $families = Family::orderBy('family_name', 'asc')->paginate(20);

        return view('admin.taxonomy.index', ['taxa' => $families, 'taxonType' => 'families']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::get();
        return view('admin.families.create')->with('orders', $orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyRequest $request)
    {
        $data = $request->validated();
        $family = Family::create([
            'family_name' => $data['family_name'], 
            'common_name' => $data['common_name'], 
            'order_id' => $data['order_id'],
        ]);

        return redirect()->route('admin.families.show', $family)->with('success', 'Family created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        $family->load('genera');
        return view('admin.families.show', ['family' => $family]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        $orders = Order::select('id', 'order_name')->get();
        return view('admin.families.edit', ['family' => $family, 'orders' => $orders]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyRequest $request, Family $family)
    {
        $data = $request->validated();
        $family->update([
            'order_id' => $data['order_id'],
            'family_name' => $data['family_name'], 
            'common_name' => $data['common_name'], 
        ]);

        return redirect()->route('admin.families.show', $family)->with('success', 'Family updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        //
    }
}
