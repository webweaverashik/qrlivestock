<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;
use App\Models\LivestockType;
use App\Models\ServiceCategory;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if non-admin user
        if (auth()->user()->role != 'admin') {
            return back()->with('warning', 'এডমিন পেজে আপনার অনুমতি নেই।');
        }
        
        $service_categories = ServiceCategory::withoutTrashed()->orderby('name', 'asc')->get();

        $livestock_types = LivestockType::withoutTrashed()->orderby('name', 'asc')->get();

        $diseases = Disease::withoutTrashed()->select('id', 'name')->get();

        return view('settings.index', compact('service_categories', 'livestock_types', 'diseases'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
