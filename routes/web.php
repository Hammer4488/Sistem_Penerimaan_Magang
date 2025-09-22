<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
// Jika Anda membuat RegisterController, tambahkan juga:
// use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('Pelamar.Page.Beranda');
});

// --- UBAH/TAMBAHKAN RUTE OTENTIKASI INI ---
// 
// Rute untuk menampilkan form login (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/daftar', [AuthController::class, 'showDaftarForm'])->name('daftar');

Route::get('/beranda', [BerandaController::class, 'showBerandaForm'])->name('beranda');
Route::get('/kuotamagang', [BerandaController::class, 'showKuotaMagangForm'])->name('kuotamagang');
Route::get('/berandapendaftar', [BerandaController::class, 'showBerandaPendaftarForm'])->name('BerandaPendaftar');
