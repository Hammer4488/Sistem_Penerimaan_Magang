<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\RiwayatPendaftaranController;
use App\Http\Controllers\DivisiController;
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
    Route::get('/dashboard', [PelamarController::class, 'beranda_index'])->name('berandapelamar');
    Route::get('/ajukanpelamar', [PelamarController::class, 'ajukan_index'])->name('ajukanpelamar');
    Route::get('/riwayatpelamar', [PelamarController::class, 'riwayat_index'])->name('riwayatpelamar');

    Route::get('/pendaftaran/{pendaftaran}', [PelamarController::class, 'show'])->name('pendaftaran.show');
    Route::get('/pendaftaran/create/{dinas}', [PelamarController::class, 'pendaftaran_create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PelamarController::class, 'store'])->name('pendaftaran.store');
    
    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    Route::get('/divisi/create', [DivisiController::class, 'create'])->name('divisi.create');
    Route::post('/divisi', [DivisiController::class, 'store'])->name('divisi.store');
    Route::get('/divisi/{divisi}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
    Route::put('/divisi/{divisi}', [DivisiController::class, 'update'])->name('divisi.update');  
    Route::delete('/divisi/{divisi}', [DivisiController::class, 'destroy'])->name('divisi.destroy');


// --- Rute Admin Dinas ---
        Route::get('/beranda.dinas', [DinasController::class, 'beranda_index'])->name('beranda.dinas');
        Route::get('/pendaftaran.dinas', [DinasController::class, 'beranda_index'])->name('pendaftaran.dinas');
        Route::get('/kuota.dinas', [DinasController::class, 'beranda_index'])->name('kuota.dinas');

});