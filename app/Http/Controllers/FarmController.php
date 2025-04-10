<?php
namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\LivestockCount;
use App\Models\LivestockType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farms = Farm::where('status', 'approved')->withoutTrashed()->orderby('updated_at', 'desc')->get();

        // return response()->json($farms);
        // return count($farms);
        return view('farms.index', compact('farms'));
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

        return view('farms.create', compact('livestock_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

        // ✅ Validate request
        $request->validate([
            'farm_name'          => 'required|string|max:255',
            'owner_name'         => 'required|string|max:255',
            'phone_number'       => 'required|string|max:11',
            'address'            => 'nullable|string|max:500',
            'photo_url'          => 'nullable|image|mimes:jpg,jpeg,png|max:200', // Max 2MB
            'livestock_counts'   => 'array',
            'livestock_counts.*' => 'nullable|integer|min:1',
            'remarks'            => 'nullable|string',
        ], [
            'phone_number.max' => 'মোবাইল নং ১১ ডিজিটের বেশি হওয়া যাবে না।',
            'photo_url.max'    => 'ছবির সাইজ সর্বোচ্চ ২০০ কিলোবাইট হতে হবে।',
        ]);

        // ✅ Generate Unique ID
        $uniqueId = 'FARM_' . strtoupper(Str::random(6));

        // ✅ Create the Farm record
        $farm = Farm::create([
            'farm_name'    => $request->farm_name,
            'owner_name'   => $request->owner_name,
            'phone_number' => $request->phone_number,
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
        $farm = Farm::with('serviceRecords', 'livestockCounts')->findOrFail($id);

        // return response()->json($farm);
        return view('farms.show', compact('farm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Farm $farm)
    {
        $livestock_types = LivestockType::withoutTrashed()->get();

        // Create an associative array: [livestock_type_id => total]
        $livestock_counts = LivestockCount::where('farm_id', $farm->id)->withoutTrashed()->pluck('total', 'livestock_type_id')->toArray();

        return view('farms.edit', compact('farm', 'livestock_types', 'livestock_counts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // ✅ Validate request
        $request->validate([
            'farm_name'          => 'required|string|max:255',
            'owner_name'         => 'required|string|max:255',
            'phone_number'       => 'required|string|max:11',
            'address'            => 'nullable|string|max:500',
            'photo_url'          => 'nullable|image|mimes:jpg,jpeg,png|max:200',
            'livestock_counts'   => 'array',
            'livestock_counts.*' => 'nullable|integer|min:1',
            'remarks'            => 'nullable|string',
        ], [
            'phone_number.max' => 'মোবাইল নং ১১ ডিজিটের বেশি হওয়া যাবে না।',
            'photo_url.max'    => 'ছবির সাইজ সর্বোচ্চ ২০০ কিলোবাইট হতে হবে।',
        ]);

        // ✅ Find the existing farm
        $farm = Farm::findOrFail($id);

        // ✅ Get all livestock types
        $livestock_types = LivestockType::withoutTrashed()->get();

        // ✅ Update basic info
        $farm->update([
            'farm_name'    => $request->farm_name,
            'owner_name'   => $request->owner_name,
            'phone_number' => $request->phone_number,
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
                    ]
                );
            } else {
                LivestockCount::where('farm_id', $farm->id)
                    ->where('livestock_type_id', $typeId)
                    ->delete();
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

        return response()->json(['success' => true, 'message' => 'খামারের তথ্য আপডেট করা হয়েছে।']);
    }

    /**
     * Farm approve
     */
    public function approveFarm($id)
    {
        try {
            $farm = Farm::findOrFail($id); // Find farm by ID

            if ($farm->status === 'approved') {
                return redirect()->route('farms.pending')->with('info', 'এই খামারটি ইতোমধ্যে অনুমোদিত রয়েছে');
            }

            $farm->status      = 'approved'; // Update the farm status
            $farm->approved_at = now();
            $farm->approved_by = Auth::user()->id;
            $farm->save(); // Save changes

            // Redirect with success message
            return redirect()->route('farms.index')->with('success', 'খামারটি সফলভাবে অনুমোদিত হয়েছে।');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->route('farms.pending')->with('error', 'খামারটি অনুমোদন করা যায়নি।');
        }
    }
}
