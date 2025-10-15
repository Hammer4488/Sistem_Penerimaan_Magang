<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\StatusPendaftaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rute Publik (Bisa diakses tanpa login) ---
Route::get('/', [BerandaController::class, 'ShowBerandaForm'])->name('beranda');
Route::get('/kuota-magang', [BerandaController::class, 'showKuotaMagangForm'])->name('kuotamagang');


// --- Rute Otentikasi ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/daftar', [AuthController::class, 'showDaftarForm'])->name('daftar')->middleware('guest');
Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Rute Pelamar (Wajib Login) ---
Route::middleware('auth')->group(function () {
    
    // Rute untuk halaman Beranda Pelamar
    Route::get('/dashboard', [PelamarController::class, 'beranda_index'])->name('berandapelamar');

    Route::get('/ajukanpelamar', [PelamarController::class, 'ajukan_index'])->name('ajukanpelamar');

    // Rute untuk halaman Status Pendaftaran
    Route::get('/statuspelamar', [PelamarController::class, 'status_index'])->name('statuspelamar');

    // Rute untuk proses pengajuan magang (CRUD Pendaftaran)
    Route::get('/pendaftaran/create', [PelamarController::class, 'pendaftaran_create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PelamarController::class, 'store'])->name('pendaftaran.store');

});