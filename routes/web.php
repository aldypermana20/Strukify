<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Manual Receipts
    Route::resource('receipts', App\Http\Controllers\ReceiptController::class);
    
    // Reports & Export
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/receipts/export/pdf', [App\Http\Controllers\ExportController::class, 'exportPdf'])->name('receipts.export.pdf');
    
    // AI Scan routes
    Route::get('/scan', [App\Http\Controllers\ReceiptScanController::class, 'index'])->name('scan.index');
    // Implementasi Keamanan Fase 4: Rate Limiting 5 request per menit untuk mencegah spam
    Route::post('/scan', [App\Http\Controllers\ReceiptScanController::class, 'scan'])
        ->middleware('throttle:5,1')
        ->name('scan.process');
});

require __DIR__.'/auth.php';
