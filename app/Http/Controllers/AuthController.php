<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LoginActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('warning', 'আপনি লগিন অবস্থায়ই রয়েছেন।');
        }
        return view('auth.login')->with('warning', 'অনুগ্রহ করে লগিন করুন।');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists (including soft-deleted users)
        $user = User::withTrashed()->where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'ইউজারটি খুঁজে পাওয়া যায়নি।');
        }

        // Step 1: Check if the user is soft-deleted
        if ($user->trashed()) {
            return back()->with('error', 'আপনার একাউন্টটি ব্লক করা হয়েছে।');
        }

        // Step 2: Check if the user is active
        if ($user->is_active == 0) {
            return back()->with('error', 'আপনার একাউন্টটি সক্রিয় নয়। অনুগ্রহ করে এডমিনের সাথে যোগাযোগ করুন।');
        }

        // Step 3: Attempt login if both checks pass
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); // Get authenticated user

            // Log login activity
            LoginActivity::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'device' => $this->detectDevice($request->header('User-Agent')),
            ]);

            return redirect()->route('dashboard')->with('success', 'সফলভাবে লগিন সম্পন্ন হয়েছে।');
        }

        return back()->with('error', 'ইমেইল ও পাসওয়ার্ড সঠিক নয়।');
    }

    // Helper function to detect device type
    private function detectDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) {
            return 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'সফলভাবে লগআউট সম্পন্ন হয়েছে।');
    }
}
