<?php
namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Farm;
use App\Models\LivestockCount;
use App\Models\LivestockType;
use App\Models\ServiceCategory;
use App\Models\Union;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farms  = Farm::where('status', 'approved')->withoutTrashed()->orderby('updated_at', 'desc')->get();
        $unions = Union::all();

        // return count($farms);
        return view('farms.index', compact('farms', 'unions'));
    }

    /**
     * Pending farms approval page
     */
    public function pendingFarm()
    {
        $farms = Farm::with('livestockCounts.livestockType')->withoutTrashed()->where('status', 'pending')->orderby('id', 'desc')->get();

        return view('farms.pending', compact('farms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livestock_types = LivestockType::withoutTrashed()->get();
        $unions          = Union::all();

        return view('farms.create', compact('livestock_types', 'unions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

        // ✅ Validate request
        $request->validate(
            [
                'farm_name'          => 'required|string|max:255',
                'owner_name'         => 'required|string|max:255',
                'phone_number'       => 'required|string|max:11|unique:farms,phone_number',
                'farm_union_id'      => 'required|exists:unions,id',
                'address'            => 'nullable|string|max:500',
                'photo_url'          => 'nullable|image|mimes:jpg,jpeg,png|max:200', // Max 2MB
                'livestock_counts'   => 'array',
                'livestock_counts.*' => 'nullable|integer|min:1',
                'remarks'            => 'nullable|string',
            ],
            [
                'phone_number.max'    => 'মোবাইল নং ১১ ডিজিটের বেশি হওয়া যাবে না।',
                'phone_number.unique' => 'এই মোবাইল নং ইতিমধ্যে ব্যবহার করা হয়েছে।',
                'photo_url.max'       => 'ছবির সাইজ সর্বোচ্চ ২০০ কিলোবাইট হতে হবে।',

            ],
        );

        // Generate an 8-digit numeric ID (no preceding zero)
        do {
            $uniqueId = rand(100000, 999999);                        // Always 8 digits, first digit 1-9
        } while (Farm::where('unique_id', $uniqueId)->exists()); // Check uniqueness

        // ✅ Create the Farm record
        $farm = Farm::create([
            'farm_name'    => $request->farm_name,
            'owner_name'   => $request->owner_name,
            'phone_number' => $request->phone_number,
            'union_id'     => $request->farm_union_id,
            'address'      => $request->address,
            'unique_id'    => $uniqueId,
            'qr_code'      => null, // Will generate later
            'created_by'   => auth()->id(),
            'remarks'      => $request->remarks ?? null,
        ]);

        // ✅ Handle file upload with unique_id prefix (only if a file is provided)
        if (isset($request['photo_url'])) {
            $file      = $request['photo_url']; // ✅ Directly access the file
            $extension = $file->getClientOriginalExtension();
            $filename  = 'photo_' . $uniqueId . '.' . $extension;
            $photoPath = public_path('uploads/farms/'); // Full path

            // ✅ Check if folder exists, if not, create it with proper permissions
            if (! file_exists($photoPath)) {
                mkdir($photoPath, 0777, true); // 0777 allows full read/write access
            }

            // ✅ Move the file
            $file->move($photoPath, $filename);

            $imageURL = 'uploads/farms/' . $filename;

            // ✅ Update student photo in DB
            $farm->update(['photo_url' => $imageURL]);
        }

        // Insert livestock counts
        foreach ($request->livestock_counts as $livestock_type_id => $count) {
            if ($count > 0) {
                // Ensure it's a valid number
                LivestockCount::create([
                    'farm_id'           => $farm->id,
                    'livestock_type_id' => $livestock_type_id,
                    'total'             => $count,
                ]);
            }
        }

        return redirect()->route('farms.pending')->with('success', 'খামারটি সফলভাবে নিবন্ধন হয়েছে এবং অনুমোদনের অপেক্ষায় রয়েছে।');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $farm = Farm::with([
            'serviceRecords' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'livestockCounts',
        ])->findOrFail($id);

        $serviceCategories = ServiceCategory::withoutTrashed()->select('id', 'name')->get();

        $diseases = Disease::withoutTrashed()->select('id', 'name')->get();

        $livestockTypes = LivestockType::withoutTrashed()->select('id', 'name')->orderby('name', 'asc')->get();

        // return response()->json($farm);
        return view('farms.show', compact('farm', 'serviceCategories', 'diseases', 'livestockTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Farm $farm)
    {
        $livestock_types = LivestockType::withoutTrashed()->get();
        $unions          = Union::all();

        // Create an associative array: [livestock_type_id => total]
        $livestock_counts = LivestockCount::where('farm_id', $farm->id)->withoutTrashed()->pluck('total', 'livestock_type_id')->toArray();

        return view('farms.edit', compact('farm', 'livestock_types', 'livestock_counts', 'unions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // ✅ Validate request
        $request->validate(
            [
                'farm_name'          => 'required|string|max:255',
                'owner_name'         => 'required|string|max:255',
                'phone_number'       => 'required|string|max:11|unique:farms,phone_number,' . $id . ',id',
                'farm_union_id'      => 'required|exists:unions,id',
                'address'            => 'nullable|string|max:500',
                'photo_url'          => 'nullable|image|mimes:jpg,jpeg,png|max:200',
                'livestock_counts'   => 'array',
                'livestock_counts.*' => 'nullable|integer|min:1',
                'remarks'            => 'nullable|string',
            ],
            [
                'phone_number.max'    => 'মোবাইল নং ১১ ডিজিটের বেশি হওয়া যাবে না।',
                'phone_number.unique' => 'এই মোবাইল নং ইতিমধ্যে ব্যবহার করা হয়েছে।',
                'photo_url.max'       => 'ছবির সাইজ সর্বোচ্চ ২০০ কিলোবাইট হতে হবে।',
            ],
        );

        // ✅ Find the existing farm
        $farm = Farm::findOrFail($id);

        // ✅ Get all livestock types
        $livestock_types = LivestockType::withoutTrashed()->get();

        // ✅ Update basic info
        $farm->update([
            'farm_name'    => $request->farm_name,
            'owner_name'   => $request->owner_name,
            'phone_number' => $request->phone_number,
            'union_id'     => $request->farm_union_id,
            'address'      => $request->address,
        ]);

        if ($request->filled('remarks')) {
            $farm->remarks = $request->remarks;
            $farm->save(); // don't forget this!
        }

        // Handle Photo update
        if (isset($request['photo_url'])) {
            $file      = $request['photo_url'];
            $extension = $file->getClientOriginalExtension();
            $filename  = 'photo_' . $farm->unique_id . '.' . $extension;
            $photoPath = public_path('uploads/farms/');

            if (! file_exists($photoPath)) {
                mkdir($photoPath, 0777, true);
            }
            $file->move($photoPath, $filename);
            $farm->update(['photo_url' => 'uploads/farms/' . $filename]);
        }

        // ✅ Update/create/delete livestock counts
        foreach ($livestock_types as $type) {
            $typeId = $type->id;
            $count  = $request->livestock_counts[$typeId] ?? null;

            if ($count && $count > 0) {
                LivestockCount::updateOrCreate(
                    [
                        'farm_id'           => $farm->id,
                        'livestock_type_id' => $typeId,
                    ],
                    [
                        'total' => $count,
                    ],
                );
            } else {
                LivestockCount::where('farm_id', $farm->id)->where('livestock_type_id', $typeId)->delete();
            }
        }

        return redirect()->route('farms.index')->with('success', 'খামারের তথ্য সফলভাবে হালনাগাদ হয়েছে।');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farm $farm)
    {
        $farm->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Toggle active and inactive farms
     */
    public function toggleActive(Request $request)
    {
        $farm = Farm::find($request->farm_id);

        if (! $farm) {
            return response()->json(['success' => false, 'message' => 'খামারের তথ্য খুঁজে পাওয়া যায়নি।']);
        }

        $farm->is_active = $request->is_active;
        $farm->save();

        $message = $request->is_active ? 'খামার সফলভাবে সক্রিয় করা হয়েছে।' : 'খামার সফলভাবে নিষ্ক্রিয় করা হয়েছে।';

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Farm approve
     */
    public function approveFarm($id)
    {
        try {
            $farm = Farm::findOrFail($id);

            if ($farm->status === 'approved') {
                return redirect()->route('farms.pending')->with('info', 'এই খামারটি ইতোমধ্যে অনুমোদিত রয়েছে।');
            }

            $qrCodeContent = $farm->unique_id;
            $fileName      = 'qr_' . $qrCodeContent . '.svg'; // Use .svg extension
            $qrPath        = public_path('uploads/farm-qr-codes/');

            // Create folder if not exists
            if (! file_exists($qrPath)) {
                if (! mkdir($qrPath, 0777, true) && ! is_dir($qrPath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $qrPath));
                }
            }

            // Save QR code to file
            QrCode::format('svg')
                ->size(300)
                ->generate($qrCodeContent, $qrPath . $fileName);

            $farm->status      = 'approved';
            $farm->approved_at = now();
            $farm->approved_by = Auth::id();
            $farm->qr_code     = 'uploads/farm-qr-codes/' . $fileName;
            $farm->save();

            return redirect()->route('farms.index')->with('success', 'খামারটি সফলভাবে অনুমোদিত হয়েছে।');
        } catch (\Exception $e) {
            Log::error('Farm Approval Error: ' . $e->getMessage()); // Debug line
            return redirect()->route('farms.pending')->with('error', 'খামারটি অনুমোদন করা যায়নি।');
        }
    }

    // QR ID Card download
    public function downloadIdCard($id)
    {
        $farm = Farm::findOrFail($id);

        // Create a custom temp directory in your storage folder
        $tempDir = storage_path('app/mpdf');

        if (! file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $pdf = new Mpdf([
            'mode'             => 'utf-8',
            'format'           => 'A4',
            'tempDir'          => $tempDir,
            'default_font'     => 'solaimanlipi',
            'autoScriptToLang' => true,
            'autoLangToFont'   => true,
            'margin_header'    => 5,
            'margin_footer'    => 5,
        ]);

        $html = view('pdf.id-card', compact('farm'))->render();

        $pdf->WriteHTML($html);

        return $pdf->Output($farm->unique_id . '.pdf', 'D'); // I = Inline view, D = Download
    }

    // Farm load AJAX for service create form
    public function getFarmDetails($id)
    {
        $farm = Farm::findOrFail($id);

        return response()->json([
            'farm_name'    => $farm->farm_name,
            'unique_id'    => $farm->unique_id,
            'owner_name'   => $farm->owner_name,
            'phone_number' => en2bn($farm->phone_number),
            'address'      => $farm->address,
            'photo'        => asset($farm->photo_url ?? 'assets/img/dummy.png'),
        ]);
    }

    // QR code scanned farm search
    public function search(Request $request)
    {
        $request->validate([
            'farm_unique_id' => 'required',
        ]);

        $farm = Farm::withTrashed()->where('unique_id', $request->input('farm_unique_id'))->first();

        if (! $farm) {
            return response()->json([
                'error' => 'খামারটি খুঁজে পাওয়া যায়নি।',
                'type'  => 'warning',
            ]);
        }

        if ($farm->trashed()) {
            return response()->json([
                'error' => 'এই খামারটি মুছে ফেলা হয়েছে।',
                'type'  => 'error',
            ]);
        }

        return response()->json(['farm' => $farm]);
    }
}
