<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardGuruController;
use App\Http\Controllers\DashboardPetugasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('/laporan', LaporanController::class)->middleware(['auth', 'role:murid']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/dashboardAdmin', DashboardAdminController::class);
});

Route::middleware(['auth', 'role:petugas_sarpras'])->group(function () {
    Route::resource('/dashboardPetugas', DashboardPetugasController::class);
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::resource('/dashboardGuru', DashboardGuruController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
