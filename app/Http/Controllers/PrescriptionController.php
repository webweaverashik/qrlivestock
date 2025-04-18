<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = Prescription::where('status', 'pending')
            ->whereHas('serviceRecord', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->withoutTrashed()
            ->orderby('created_at', 'desc')
            ->get();

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // Validate request
        $request->validate([
            'service_record_id'        => 'required|integer|exists:service_records,id',
            'livestock_type_id'        => 'nullable|exists:livestock_types,id',
            'livestock_age'            => 'nullable|string|max:255',
            'livestock_weight'         => 'nullable|string|max:255',
            'disease_brief'            => 'required|string',
            'medication'               => 'required|string',
            'livestock_temp'           => 'nullable|string|max:255',
            'livestock_pulse'          => 'nullable|string|max:255',
            'livestock_rumen_motility' => 'nullable|string|max:255',
            'livestock_respiratory'    => 'nullable|string|max:255',
            'livestock_other'          => 'nullable|string|max:255',
            'additional_notes'         => 'nullable|string',
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
            'livestock_type_id'        => $request->livestock_type_id,
            'livestock_age'            => $request->livestock_age,
            'livestock_weight'         => $request->livestock_weight,
            'disease_brief'            => $request->disease_brief,
            'medication'               => $request->medication,
            'livestock_temp'           => $request->livestock_temp,
            'livestock_pulse'          => $request->livestock_pulse,
            'livestock_rumen_motility' => $request->livestock_rumen_motility,
            'livestock_respiratory'    => $request->livestock_respiratory,
            'livestock_other'          => $request->livestock_other,
            'additional_notes'         => $request->additional_notes,
            'created_by'               => Auth::id(),
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
            'id'               => $prescription->id,
            'disease_brief'    => $prescription->disease_brief,
            'medication'       => $prescription->medication,
            'additional_notes' => $prescription->additional_notes,
            'status'           => $prescription->status,
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
        $prescription = Prescription::findOrFail($id);

        if ($prescription->status == 'pending') {
            return redirect()->route('prescriptions.index')->with('warning', 'প্রেসক্রিপশনটি অনুমোদনের অপেক্ষায়।');
        }

        // Create a custom temp directory in your storage folder
        $tempDir = storage_path('app/mpdf');

        if (! file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $pdf = new Mpdf([
            'mode'             => 'utf-8',
            'format'           => 'A4-L',
            'tempDir'          => $tempDir,
            'default_font'     => 'solaimanlipi',
            'autoScriptToLang' => true,
            'autoLangToFont'   => true,
            'margin_top'       => 0,
            'margin_bottom'    => 0,
            'margin_left'      => 0,
            'margin_right'     => 0,
            'margin_header'    => 0,
            'margin_footer'    => 0,
        ]);

        $pdf->SetWatermarkImage(public_path('assets/img/icon.png'), 0.05, 'F'); // Adjust opacity (0.0 to 1.0)
        $pdf->showWatermarkImage = true;

        $pdf->SetAutoPageBreak(false); // নতুন পৃষ্ঠা তৈরি হবে না

        $html = view('pdf.prescription-pdf', compact('prescription'))->render();

        $pdf->WriteHTML($html);

        return $pdf->Output('prescription_'. $prescription->serviceRecord->farm->unique_id . '.pdf', 'D'); // I = Inline view, D = Download
    }

    // Prescription Approval
    public function approve(Prescription $prescription)
    {
        $prescription->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Prescription approved successfully.']);
    }

}
