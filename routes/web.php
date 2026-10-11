<?php

use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SaranaController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $user = $request->user();

    if (! $user) {
        return view('auth.login');
    }

    abort_unless($user instanceof User, 403);

    return to_route($user->homeRouteName());
});

Route::middleware(['auth', 'role:admin,petugas_sarpras'])->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    Route::resource('/sarana', SaranaController::class)->except('show');
    Route::resource('/kategori', KategoriController::class)->except('show')->names('kategori');
    Route::resource('/ruangan', RuanganController::class)->except('show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/guru', GuruController::class)->except('show')->parameters(['guru' => 'staff']);
    Route::resource('/petugas', PetugasController::class)->except('show')->parameters(['petugas' => 'staff']);
});

Route::middleware(['auth', 'role:murid,admin,petugas_sarpras'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

Route::middleware(['auth', 'role:murid'])->group(function () {
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/riwayat', [LaporanController::class, 'history'])->name('laporan.history');
});

Route::middleware(['auth', 'role:admin,petugas_sarpras'])->group(function () {
    Route::patch('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])->name('laporan.status');
});

Route::middleware(['auth', 'role:admin,petugas_sarpras,guru'])->prefix('berita-acara')->name('berita-acara.')->group(function () {
    Route::get('/', [BeritaAcaraController::class, 'index'])->name('index');
    Route::get('/create', [BeritaAcaraController::class, 'create'])->name('create');
    Route::post('/', [BeritaAcaraController::class, 'store'])->name('store');
    Route::get('/{berita_acara}/print', [BeritaAcaraController::class, 'print'])->name('print');
    Route::get('/{berita_acara}', [BeritaAcaraController::class, 'show'])->name('show');
});

Route::middleware(['auth', 'role:admin,petugas_sarpras'])->prefix('berita-acara')->name('berita-acara.')->group(function () {
    Route::get('/{berita_acara}/edit', [BeritaAcaraController::class, 'edit'])->name('edit');
    Route::put('/{berita_acara}', [BeritaAcaraController::class, 'update'])->name('update');
    Route::patch('/{berita_acara}', [BeritaAcaraController::class, 'update']);
    Route::delete('/{berita_acara}', [BeritaAcaraController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil', [ProfileController::class, 'update']);
});

require __DIR__.'/auth.php';
