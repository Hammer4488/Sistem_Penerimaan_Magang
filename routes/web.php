<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelamarController;
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
Route::post('/login', [AuthController::class, 'login'])->name('masuk');
Route::get('/daftar', [AuthController::class, 'showDaftarForm'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'register'])->name('pendaftaran');
// Rute untuk proses logout
// Penting: Gunakan method POST untuk logout demi keamanan (mencegah CSRF)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/beranda', [BerandaController::class, 'showBerandaForm'])->name('beranda');
Route::get('/kuotamagang', [BerandaController::class, 'showKuotaMagangForm'])->name('kuotamagang');

Route::get('/berandapelamar', [PelamarController::class, 'showBerandaPelamarForm'])->name('berandapelamar');
// Route::get('/berandapelamar', [PelamarController::class, 'index'])
//      ->middleware('auth')
//      ->name('berandapelamar');
     
Route::get('/ajukanpelamar', [PelamarController::class, 'showAjukanPelamarForm'])->name('ajukanpelamar');
// Route::get('/ajukanpelamar', [PelamarController::class, 'index'])
//      ->middleware('auth')
//      ->name('ajukanpelamar');