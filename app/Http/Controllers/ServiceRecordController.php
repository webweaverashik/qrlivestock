<?php
namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Farm;
use App\Models\ServiceCategory;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('records.index', compact('serviceRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $farms = Farm::query()
            ->where('status', 'approved')
            ->where('is_active', true)
            ->withoutTrashed()
            ->select('id', 'farm_name', 'unique_id')
            ->orderBy('farm_name', 'asc')
            ->get();

        $serviceCategories = ServiceCategory::withoutTrashed()->select('id', 'name')->get();

        $diseases = Disease::withoutTrashed()->select('id', 'name')->get();

        return view('records.create', compact('farms', 'serviceCategories', 'diseases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farm_id'                 => 'required|exists:farms,id',
            'service_category_id'     => 'required|exists:service_categories,id',

            'species_number_flock'    => 'nullable|integer|min:1',
            'species_number_infected' => 'nullable|integer|min:1',
            'species_number_dead'     => 'nullable|integer|min:1',

            'species_type_species'    => 'nullable|string|max:255',
            'species_type_breed'      => 'nullable|string|max:255',
            'species_type_gender'     => 'nullable|in:male,female',
            'species_type_age'        => 'nullable|string|max:255',

            'history_of_disease'      => 'nullable|string',
            'symptoms_of_disease'     => 'nullable|string',
            'microscopic_result'      => 'nullable|string|max:255',
            'disease_id'              => 'nullable|exists:diseases,id',
        ], [
            'farm_id.required'             => 'ফার্ম নাম প্রয়োজনীয়',
            'service_category_id.required' => 'সেবা ধরণ প্রয়োজনীয়',
        ]);

        // Add created_by
        $validated['created_by'] = Auth::id();

        // Save the record
        $record = ServiceRecord::create($validated);

        return redirect()->route('records.index')->with('success', 'সেবা রেকর্ড সফলভাবে যুক্ত হয়েছে!');
    }

    /**
     * Store from show farm page
     */
    public function storeFromShow(Request $request, string $id)
    {
        // return $request;
        $validated = $request->validate([
            'service_category_id'     => 'required|exists:service_categories,id',

            'species_number_flock'    => 'nullable|integer|min:1',
            'species_number_infected' => 'nullable|integer|min:1',
            'species_number_dead'     => 'nullable|integer|min:1',

            'species_type_species'    => 'nullable|string|max:255',
            'species_type_breed'      => 'nullable|string|max:255',
            'species_type_gender'     => 'nullable|in:male,female',
            'species_type_age'        => 'nullable|string|max:255',

            'history_of_disease'      => 'nullable|string',
            'symptoms_of_disease'     => 'nullable|string',
            'microscopic_result'      => 'nullable|string|max:255',
            'disease_id'              => 'nullable|exists:diseases,id',
        ], [
            'farm_id.required'             => 'ফার্ম নাম প্রয়োজনীয়',
            'service_category_id.required' => 'সেবা ধরণ প্রয়োজনীয়',
        ]);

        // Add created_by
        $validated['created_by'] = Auth::id();
        $validated['farm_id']    = $id;

        // Save the record
        $record = ServiceRecord::create($validated);

        return redirect()->back()->with('success', 'সেবা রেকর্ড সফলভাবে যুক্ত হয়েছে!');
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
