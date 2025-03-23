<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmController;

Route::get('/', function() {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth', 'isLoggedIn'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.admin');
    })->name('dashboard');

    // Only allow POST method for actual logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Handle GET /logout: Redirect back if logged in
    Route::get('/logout', function () {
        return redirect()->back();
    })->name('logout.get');


    // Route for farms
    Route::get('farms/pending', [FarmController::class, 'pendingFarm'])->name('farms.pending');
    Route::post('farms/toggle-active', [FarmController::class, 'toggleActive'])->name('farms.toggleActive');
    Route::post('/farms/{id}/approve', [FarmController::class, 'approveFarm'])->name('farms.approve');
    
    Route::resource('farms', FarmController::class);


    
});

// Handle GET /logout for logged-out users (redirect to login)
Route::get('/logout', function () {
    return redirect()->route('login');
})->name('logout.get');




// Testing mail server
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Laravel 12!', function ($message) {
        $message->to('ashik.ane.doict@gmail.com')
                ->subject('Laravel 12 Gmail SMTP Test');
    });

    return 'Test email sent successfully!';
});
