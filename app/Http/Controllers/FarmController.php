<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use App\Models\LivestockType;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $farms = Farm::where('is_active', 1)->withoutTrashed()->get();
        $farms = Farm::withoutTrashed()->get();

        // return response()->json($farms);
        // return count($farms);
        return view('farms.index', compact('farms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livestock_types = LivestockType::withoutTrashed()->get();

        return view('farms.create', compact('livestock_types'));
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
    public function show(Farm $farm)
    {   
        return response()->json($farm);
        // return view('farms.show', compact('farm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Farm $farm)
    {
        return view('farms.edit', compact('farm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farm $farm)
    {
        $farm->delete();
        return response()->json(['success' => true]);
    }
}
