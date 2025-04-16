<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ServiceRecordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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

    // Custom routes for farms
    Route::get('farms/pending', [FarmController::class, 'pendingFarm'])->name('farms.pending');
    Route::post('farms/toggle-active', [FarmController::class, 'toggleActive'])->name('farms.toggleActive');
    Route::post('farms/{id}/approve', [FarmController::class, 'approveFarm'])->name('farms.approve');
    Route::get('farms/{id}/id-card', [FarmController::class, 'downloadIdCard'])->name('farms.id-card');
    Route::get('get-farm-details/{id}', [FarmController::class, 'getFarmDetails']);
    Route::post('farms/search', [FarmController::class, 'search'])->name('farms.search');

    // Custom routes form prescription
    Route::get('/prescriptions/{id}/download', [PrescriptionController::class, 'downloadPrescription'])->name('prescriptions.download');
    Route::post('/prescriptions/{prescription}/approve', [PrescriptionController::class, 'approve']);

    // Custom routes for recrords
    Route::post('/records/{id}/storeFromShow', [ServiceRecordController::class, 'storeFromShow'])->name('records.storeFromShow');

    // Resource Routes for General Activites
    Route::resource('farms', FarmController::class);
    Route::resource('records', ServiceRecordController::class);
    Route::resource('prescriptions', PrescriptionController::class);

    // Route for users
    Route::post('users/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    Route::resource('users', UserController::class);
});

// Handle GET /logout for logged-out users (redirect to login)
Route::get('/logout', function () {
    return redirect()->route('login');
})->name('logout.get');
