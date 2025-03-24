<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Support\Str;
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
        $farms = Farm::withoutTrashed()->orderby('updated_at', 'desc')->get();

        // return response()->json($farms);
        // return count($farms);
        return view('farms.index', compact('farms'));
    }

    /**
     * Pending farms approval page
     */
    public function pendingFarm()
    {
        $farms = Farm::withoutTrashed()->where('status', 'pending')->orderby('id', 'desc')->get();

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
        // ✅ Validate request
        $request->validate([
            'farm_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo_url' => 'nullable|image|mimes:jpg,jpeg,png|max:200', // Max 2MB
        ]);

        // ✅ Generate Unique ID
        $uniqueId = 'FARM_' . strtoupper(Str::random(6));

        // ✅ Handle file upload with unique_id prefix (only if a file is provided)
        if ($request->has('photo_url')) {
            $file = $request->file('photo_url');
            $extension = $file->getClientOriginalExtension();

            $filename = 'photo_' . $uniqueId . '.' . $extension;

            $photoPath = 'uploads/photos/';
            $file->move($photoPath, $filename);

            $imageURL = $photoPath . $filename;
        } else {
            $imageURL = null;
        }

        // ✅ Create the Farm record
        $farm = Farm::create([
            'farm_name' => $request->farm_name,
            'owner_name' => $request->owner_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'unique_id' => $uniqueId,
            'photo_url' => $imageURL, // Stored path
            'qr_code' => null, // Will generate later
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('farms.index')->with('success', 'খামারটি সফলভাবে নিবন্ধন হয়েছে এবং অনুমোদনের অপেক্ষায় রয়েছে।');
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
        $livestock_types = LivestockType::withoutTrashed()->get();

        return view('farms.edit', compact('farm', 'livestock_types'));
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
     * Farm approve
     */
    public function approveFarm($id)
    {
        try {
            $farm = Farm::findOrFail($id); // Find farm by ID
            $farm->status = 'approved'; // Update the farm status
            $farm->save(); // Save changes

            // Redirect with success message
            return redirect()->route('farms.index')->with('success', 'খামারটি সফলভাবে অনুমোদিত হয়েছে।');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->route('farms.pending')->with('error', 'খামারটি অনুমোদন করা যায়নি।');
        }
    }
}
