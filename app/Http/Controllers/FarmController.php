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
        $farms = Farm::withoutTrashed()->orderby('id', 'desc')->get();

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
    public function show(string $id)
    {
        $farm = Farm::with('serviceRecords')->findOrFail($id);

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
     * Toggle active and inactive farms
     */
    public function toggleActive(Request $request)
    {
        $farm = Farm::find($request->farm_id);

        if (!$farm) {
            return response()->json(['success' => false, 'message' => 'খামারের তথ্য খুঁজে পাওয়া যায়নি।']);
        }

        $farm->is_active = $request->is_active;
        $farm->save();

        return response()->json(['success' => true, 'message' => 'খামারের তথ্য আপডেট করা হয়েছে।']);
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
