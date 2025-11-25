<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\RiwayatPendaftaranController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AkunController; // <--- 1. IMPORT INI DITAMBAHKAN
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========================================================================
// 1. RUTE PUBLIK (Tanpa Login)
// ========================================================================
Route::get('/', [BerandaController::class, 'ShowBerandaForm'])->name('beranda');
Route::get('/kuota-magang', [BerandaController::class, 'showKuotaMagangForm'])->name('kuotamagang');


// ========================================================================
// 2. RUTE OTENTIKASI (Login/Register)
// ========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/daftar', [AuthController::class, 'showDaftarForm'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'register']);
});

// Logout harus accessable oleh user yang login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ========================================================================
// 3. RUTE KHUSUS PELAMAR
// ========================================================================
// Middleware 'auth' = wajib login
// Middleware 'role:pelamar' = role harus 'pelamar'
Route::middleware(['auth', 'role:pelamar'])->group(function () {

    Route::get('/dashboard', [PelamarController::class, 'beranda_index'])->name('berandapelamar');
    Route::get('/ajukanpelamar', [PelamarController::class, 'ajukan_index'])->name('ajukanpelamar');
    Route::get('/riwayatpelamar', [PelamarController::class, 'riwayat_index'])->name('riwayatpelamar');

    Route::get('/pendaftaran/{pendaftaran}', [PelamarController::class, 'show'])->name('pendaftaran.show');
    Route::get('/pendaftaran/create/{dinas}', [PelamarController::class, 'pendaftaran_create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PelamarController::class, 'store'])->name('pendaftaran.store');

    Route::get('/dokumen/download/{dokumen}', [PelamarController::class, 'downloadSurat'])->name('dokumen.download');
});


// ========================================================================
// 4. RUTE KHUSUS ADMIN DINAS
// ========================================================================
// Role harus 'admin dinas'
Route::middleware(['auth', 'role:admin dinas'])->group(function () {

    // Dashboard & Pendaftar
    Route::get('/beranda.dinas', [DinasController::class, 'beranda'])->name('beranda.dinas');
    Route::get('/pendaftar.dinas', [DinasController::class, 'pendaftar'])->name('pendaftar.dinas');

    // Aksi (Setujui, Tolak, dll)
    Route::post('/pendaftaran.dinas/setujui', [DinasController::class, 'setujuiPendaftaran'])->name('admin.pendaftar.setujui');
    Route::post('/pendaftaran.dinas/tolak', [DinasController::class, 'tolakPendaftaran'])->name('admin.pendaftardinas.tolak');
    Route::post('/pendaftaran.dinas/approve-only', [DinasController::class, 'approveOnlyPendaftaran'])->name('admin.pendaftar.approveOnly');
    Route::post('/pendaftar/hapus-surat', [DinasController::class, 'hapusSuratBalasan'])->name('admin.pendaftar.hapusSurat');

    // Kelola Kuota & Divisi
    Route::get('/kuota.dinas', [DivisiController::class, 'index'])->name('Admin_Dinas.page.KuotaDinas');
    Route::post('/kelola-kuota', [DivisiController::class, 'store'])->name('admin.divisi.store');
    Route::put('/kelola-kuota/{divisi:id_divisi}', [DivisiController::class, 'update'])->name('admin.divisi.update');
    Route::delete('/kelola-kuota/{divisi:id_divisi}', [DivisiController::class, 'destroy'])->name('admin.divisi.destroy');
});


// ========================================================================
// 5. RUTE KHUSUS SUPER ADMIN
// ========================================================================
// Role harus 'super admin'
Route::middleware(['auth', 'role:super admin'])->group(function () {

    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    Route::get('/super-admin/kelola-dinas', [SuperAdminController::class, 'indexDinas'])->name('superadmin.dinas.index');
    Route::post('/super-admin/kelola-dinas', [SuperAdminController::class, 'storeDinas'])->name('superadmin.dinas.store');
    Route::put('/super-admin/kelola-dinas/{id}', [SuperAdminController::class, 'updateDinas'])->name('superadmin.dinas.update');
    Route::delete('/super-admin/kelola-dinas/{id}', [SuperAdminController::class, 'destroyDinas'])->name('superadmin.dinas.destroy');

    Route::get('/super-admin/kelola-akun', [AkunController::class, 'index'])->name('superadmin.users.index');
    Route::post('/super-admin/kelola-akun', [AkunController::class, 'store'])->name('superadmin.users.store');
    Route::put('/super-admin/kelola-akun/{id}', [AkunController::class, 'update'])->name('superadmin.users.update');
    Route::delete('/super-admin/kelola-akun/{id}', [AkunController::class, 'destroy'])->name('superadmin.users.destroy');
});
