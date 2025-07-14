<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TarifController;
use App\Http\Middleware\AdminMiddleware;   // Import AdminMiddleware
use App\Http\Middleware\PetugasMiddleware; // Import PetugasMiddleware
use Illuminate\Support\Facades\Route;



// Route untuk login tunggal (user/pelanggan)
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Grup Route untuk Admin
Route::middleware(['auth:web', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Rute-rute untuk Manajemen  (Admin bisa CRUD)
    Route::resource('tarifs', TarifController::class);
    Route::resource('pelanggans', PelangganController::class);
});

// Grup Route untuk Petugas
Route::middleware(['auth:web', PetugasMiddleware::class])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    // Rute-rute untuk Manajemen Tarif (Petugas hanya bisa Read: index, show)
    // Note: 'show' di sini akan redirect ke index karena tidak ada view show terpisah.
    Route::resource('tarifs', TarifController::class)->only(['index', 'show']);
    Route::resource('pelanggans', PelangganController::class)->only(['index', 'show']); // <-- Tambahkan ini
});

// Grup Route untuk Pelanggan
Route::middleware(['auth:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pelanggan.dashboard');
    })->name('dashboard');
});

// Halaman utama akan langsung redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});