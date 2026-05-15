<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Auth
Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Residents
    Route::resource('residents', ResidentController::class);
    
    // Households
    Route::resource('households', HouseholdController::class);
    
    // Blotters
    Route::resource('blotters', BlotterController::class);
    Route::post('blotters/{blotter}/status', [BlotterController::class, 'updateStatus'])->name('blotters.update-status');
    Route::post('blotters/{blotter}/summons', [BlotterController::class, 'addSummon'])->name('blotters.add-summon');
    
    // Documents
    Route::resource('documents', DocumentController::class)->parameters(['documents' => 'issuance']);
    Route::get('documents/{issuance}/print', [DocumentController::class, 'print'])->name('documents.print');
    
    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});

Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        return "Database migrated and seeded successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
