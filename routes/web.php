<?php

use App\Http\Controllers\MonitoringController;
use App\Models\Alert;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Monitoring routes
    Route::controller(MonitoringController::class)->group(function () {
        Route::get('/monitoring', 'index')->name('monitoring.index');
        Route::post('/monitoring/generate', 'store')->name('monitoring.generate');
        Route::get('/monitoring/servers/{server}', 'show')->name('monitoring.server');
    });

    // Alert routes
    Route::patch('/alerts/{alert}/resolve', function (Alert $alert) {
        $alert->update([
            'is_resolved' => true,
            'resolved_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Alert resolved successfully');
    })->name('alerts.resolve');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
