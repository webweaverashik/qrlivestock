<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ServiceRecordController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth', 'isLoggedIn'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::post('prescriptions/{id}/approve', [PrescriptionController::class, 'approvePrescription']);
    Route::get('prescriptions/{id}/download', [PrescriptionController::class, 'downloadPrescription'])->name('prescriptions.download');

    // Custom routes for recrords
    Route::post('/records/{id}/storeFromShow', [ServiceRecordController::class, 'storeFromShow'])->name('records.storeFromShow');

    // Resource Routes for General Activites
    Route::resource('farms', FarmController::class);
    Route::resource('records', ServiceRecordController::class);
    Route::resource('prescriptions', PrescriptionController::class);

    // Route for users
    Route::post('users/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    Route::get('users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('users/profile', [UserController::class, 'profileUpdate'])->name('users.profile.update');
    Route::post('users/profile/password', [UserController::class, 'profilePasswordUpdate'])->name('users.profile.password.update');
    Route::post('users/password', [UserController::class, 'userPasswordReset'])->name('users.password.reset');
    Route::resource('users', UserController::class);

    // Route for settings
    Route::resource('settings', SettingController::class);
});

Route::get('view/{unique_id}', [FarmController::class, 'publicView'])->name('farms.publicView');

// Handle GET /logout for logged-out users (redirect to login)
Route::get('/logout', function () {
    return redirect()->route('login');
})->name('logout.get');
