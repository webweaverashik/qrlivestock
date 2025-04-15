<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $prescriptions = Prescription::where('status', 'pending')
            ->whereHas('serviceRecord', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->withoutTrashed()
            ->get();

        return view('prescriptions.index', compact('prescriptions'));
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
        // Validate request
        $request->validate([
            'disease_brief'     => 'required|string',
            'medication'        => 'required|string',
            'service_record_id' => 'required|integer|exists:service_records,id',
            'additional_notes'  => 'nullable|string',
        ]);

        // Clean text from HTML to ensure it's not just empty tags
        $diseaseBriefText = trim(strip_tags($request->disease_brief));
        $medicationText   = trim(strip_tags($request->medication));

        if (empty($diseaseBriefText)) {
            return back()->withErrors(['disease_brief' => 'রোগের বিবরণ প্রয়োজন।'])->withInput();
        }

        if (empty($medicationText)) {
            return back()->withErrors(['medication' => 'ঔষধের বিবরণ প্রয়োজন।'])->withInput();
        }

        // Create the prescription
        $prescription = Prescription::create([
            'disease_brief'    => $request->disease_brief,
            'medication'       => $request->medication,
            'additional_notes' => $request->additional_notes,
            'created_by'       => Auth::id(),
        ]);

        // Update the related ServiceRecord with the new prescription_id
        $serviceRecord                  = ServiceRecord::find($request->service_record_id);
        $serviceRecord->prescription_id = $prescription->id;
        $serviceRecord->save();

        return redirect()->back()->with('success', 'প্রেসক্রিপশন সফলভাবে সংরক্ষণ করা হয়েছে।');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prescription = Prescription::findOrFail($id);

        return response()->json([
            'disease_brief'    => $prescription->disease_brief,
            'medication'       => $prescription->medication,
            'additional_notes' => $prescription->additional_notes,
        ]);
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

    /**
     * Remove the specified resource from storage.
     */
    public function downloadPrescription(string $id)
    {
        return '<h1>File Downloaded</h1>';
    }

}
