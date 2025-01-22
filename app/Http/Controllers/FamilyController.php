<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Order;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $families = Family::orderBy('family_name', 'asc')->paginate(20);

        return view('taxonomy.index', ['taxa' => $families, 'taxonType' => 'families']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::get();
        return view('families.create')->with('orders', $orders);
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
    public function show(Family $family)
    {
        $family->load('genera');
        return view('families.show', ['family' => $family]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        $orders = Order::select('id', 'order_name')->get();
        return view('families.edit', ['family' => $family, 'orders' => $orders]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Family $family)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        //
    }
}
