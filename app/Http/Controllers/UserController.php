<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withoutTrashed()->orderby('id', 'desc')->get();

        return view('users.index', compact('users'));
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
        // return $request;

        // ✅ Validate request
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|max:50|unique:users,email',
            'user_role' => 'required|string|in:admin,staff',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:200', // Max 2MB
        ]);

        // ✅ Handle file upload with unique_id prefix (only if a file is provided)
        if ($request->has('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();

            $filename = 'photo_' . date('d-m-Y_H-i-s') . '.' . $extension;

            $photoPath = 'uploads/users/';
            $file->move($photoPath, $filename);

            $imageURL = $photoPath . $filename;
        } else {
            $imageURL = null;
        }

        // ✅ Create the Farm record
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'role' => $request->user_role,
            'password' => Hash::make('ulo1234'),
            'photo_url' => $imageURL, // Stored path
        ]);

        return redirect()->route('users.index')->with('success', 'ইউজারটি সফলভাবে যুক্ত করা হয়েছে।');
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
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'photo_url' => asset($user->photo_url), // Adjust path based on storage
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ✅ Find the user
        $user = User::findOrFail($id);

        // ✅ Validate request
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|max:50|unique:users,email,' . $id,
            'user_role' => 'required|string|in:admin,staff',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:200', // Max 2MB
        ]);

        // ✅ Handle file upload (if a new file is provided)
        if ($request->hasFile('avatar')) {
            $photoPath = public_path('uploads/users/'); // Define absolute path

            // ✅ Ensure the directory exists
            if (!file_exists($photoPath)) {
                mkdir($photoPath, 0775, true); // Create folder with proper permissions
            }

            // ✅ Delete the old photo if it exists
            if ($user->photo_url && file_exists(public_path($user->photo_url))) {
                unlink(public_path($user->photo_url));
            }

            // ✅ Upload new photo
            $file = $request->file('avatar');
            $filename = 'photo_' . now()->format('d-m-Y_H-i-s') . '.' . $file->getClientOriginalExtension();
            $file->move($photoPath, $filename);

            // ✅ Set new image URL
            $user->photo_url = 'uploads/users/' . $filename;
        }

        // ✅ Update user data
        $user->update([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'role' => $request->user_role,
        ]);

        return redirect()->route('users.index')->with('success', 'ইউজারটি সফলভাবে হালনাগাদ করা হয়েছে।');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Toggle active and inactive farms
     */
    public function toggleActive(Request $request)
    {
        $user = User::find($request->farm_id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Error. Please, contact support.']);
        }

        $user->is_active = $request->is_active;
        $user->save();

        return response()->json(['success' => true, 'message' => 'ইউজার আপডেট করা হয়েছে।']);
    }
}
