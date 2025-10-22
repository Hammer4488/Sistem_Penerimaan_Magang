<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\StatusPendaftaranController;
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
    
    // Rute untuk halaman Beranda Pelamar
    Route::get('/dashboard', [PelamarController::class, 'beranda_index'])->name('berandapelamar');

    Route::get('/ajukanpelamar', [PelamarController::class, 'ajukan_index'])->name('ajukanpelamar');

    // Rute untuk halaman Status Pendaftaran
    Route::get('/statuspelamar', [PelamarController::class, 'status_index'])->name('statuspelamar');

    // Rute untuk proses pengajuan magang (CRUD Pendaftaran)
    Route::get('/pendaftaran/create/{dinas}', [PelamarController::class, 'pendaftaran_create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PelamarController::class, 'store'])->name('pendaftaran.store');

    // Menampilkan daftar semua divisi (Read)
    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    // Menampilkan form untuk menambah divisi baru (Create)
    Route::get('/divisi/create', [DivisiController::class, 'create'])->name('divisi.create');
    // Menyimpan divisi baru ke database (Create)
    Route::post('/divisi', [DivisiController::class, 'store'])->name('divisi.store');
    // Menampilkan form untuk mengedit divisi (Update)
    Route::get('/divisi/{divisi}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
    // Memperbarui data divisi di database (Update)
    Route::put('/divisi/{divisi}', [DivisiController::class, 'update'])->name('divisi.update');  
    // Menghapus divisi dari database (Delete)
    Route::delete('/divisi/{divisi}', [DivisiController::class, 'destroy'])->name('divisi.destroy');
});