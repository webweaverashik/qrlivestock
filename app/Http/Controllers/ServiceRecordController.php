<?php
namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Farm;
use App\Models\ServiceCategory;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceRecords = ServiceRecord::whereHas('farm', function ($query) {
            $query->whereNull('deleted_at'); // Exclude soft-deleted farms
        })
            ->withoutTrashed()
            ->get();

        return view('records.index', compact('serviceRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $farms             = Farm::where('is_active', true)->withoutTrashed()->select('id', 'farm_name', 'unique_id')->orderby('farm_name', 'asc')->get();

        $serviceCategories = ServiceCategory::withoutTrashed()->select('id', 'name')->get();
        
        $diseases          = Disease::withoutTrashed()->select('id', 'name')->get();

        return view('records.create', compact('farms', 'serviceCategories', 'diseases'));
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
