<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
// Jika Anda membuat RegisterController, tambahkan juga:
// use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('Pelamar.Page.KuotaMagang');
});

// --- UBAH/TAMBAHKAN RUTE OTENTIKASI INI ---
// 
// Rute untuk menampilkan form login (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/daftar', [AuthController::class, 'showDaftarForm'])->name('daftar');

Route::get('/dashboard', [DashboardController::class, 'showDashboardForm'])->name('dashboard');
Route::get('/', [DashboardController::class, 'showKuotaMagangForm'])->name('KuotaMagang');
// Rute untuk memproses data dari form login (POST)
// Route::post('/login', [LoginController::class, 'login']);

// Rute untuk logout (POST direkomendasikan untuk keamanan)
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Placeholder untuk rute register agar tidak error
// Anda perlu membuat RegisterController dengan logika yang mirip
//  Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//  Route::post('/register', [RegisterController::class, 'register']);


// Rute untuk dashboard yang sudah ada (tidak perlu diubah)
// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware('auth')
//     ->name('dashboard');