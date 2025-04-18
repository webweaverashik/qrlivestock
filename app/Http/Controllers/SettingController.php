<?php
namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\LivestockType;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

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
        $request->validate([
            'setting_name' => 'required|string|max:255',
            'setting_type' => 'required|in:1,2,3',
        ]);

        switch ($request->setting_type) {
            case 1:
                LivestockType::create([
                    'name' => $request->setting_name,
                ]);
                $message = 'প্রাণির ধরণ সফলভাবে যুক্ত হয়েছে।';
                break;

            case 2:
                ServiceCategory::create([
                    'name' => $request->setting_name,
                ]);
                $message = 'সেবার ধরণ সফলভাবে যুক্ত হয়েছে।';
                break;

            case 3:
                Disease::create([
                    'name' => $request->setting_name,
                ]);
                $message = 'রোগের ধরণ সফলভাবে যুক্ত হয়েছে।';
                break;

            default:
                return back()->withErrors(['setting_type' => 'অবৈধ ধরণ।']);
        }

        return redirect()->back()->with('success', $message);
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
        // Validate the request
        $request->validate([
            'setting_type' => 'required|in:1,2,3',
            'setting_name' => 'required|string|max:255',
        ]);

        // Determine model based on setting_type
        switch ($request->setting_type) {
            case 1:
                $model = LivestockType::findOrFail($id);
                $message = 'প্রাণির ধরণ সফলভাবে আপডেট করা হয়েছে।';
                break;
            case 2:
                $model = ServiceCategory::findOrFail($id);
                $message = 'সেবার ধরণ সফলভাবে আপডেট করা হয়েছে।';
                break;
            case 3:
                $model = Disease::findOrFail($id);
                $message = 'রোগের ধরণ সফলভাবে আপডেট করা হয়েছে।';
                break;
            default:
            return back()->withErrors(['setting_type' => 'অবৈধ ধরণ।']);
        }

        // Update the setting name
        $model->name = $request->setting_name;
        $model->save();

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
