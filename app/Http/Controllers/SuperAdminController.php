<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Dokumen;
use App\Models\Divisi;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // 1. Hitung TOTAL SEMUA USER (Termasuk Super Admin, Admin Dinas, Pelamar)
        $jumlahUser = User::count();

        $jumlahDinas = Dinas::count();
        $jumlahMagangAktif = Pendaftaran::where('status', 'diterima')->count();

        return view('Super_Admin.Page.BerandaSuper', [
            'active'            => 'dashboard_super',
            'jumlahUser'        => $jumlahUser,
            'jumlahDinas'       => $jumlahDinas,
            'jumlahMagangAktif' => $jumlahMagangAktif
        ]);
    }

    // 1. READ: Menampilkan halaman kelola dinas
    public function indexDinas()
    {

        $dinas = Dinas::latest()->get();

        return view('Super_Admin.Page.DinasSuper', [
            'active' => 'keloladinas', 
            'semua_dinas' => $dinas
        ]);
    }

    // 2. CREATE: Menyimpan data dinas baru
    public function storeDinas(Request $request)
    {
        $request->validate([
            'nama_dinas' => 'required|string|max:30|unique:dinas,nama_dinas',
            'nama_lengkap_dinas' => 'required|string|max:50', 
            'deskripsi' => 'required|string|max:100',
        ], [
            'nama_dinas.required' => 'Nama dinas wajib diisi.',
            'nama_dinas.unique' => 'Nama dinas sudah terdaftar.',
            'nama_lengkap_dinas.required' => 'Nama lengkap dinas wajib diisi.',
            'deskripsi.required' => 'Deskripsi dinas wajib diisi.',
        ]);

        Dinas::create([
            'nama_dinas' => $request->nama_dinas,
            'nama_lengkap_dinas' => $request->nama_lengkap_dinas, 
            'deskripsi' => $request->deskripsi, 
            
        ]);

        return redirect()->back()->with('success', 'Dinas berhasil ditambahkan.');
    }

    public function updateDinas(Request $request, $id)
    {
        $request->validate([
            'nama_dinas' => 'required|string|max:30|unique:dinas,nama_dinas,'.$id.',id_dinas',
            'nama_lengkap_dinas' => 'required|string|max:50', // Validasi baru
            'deskripsi' => 'required|string|max:100', 
        ]);

        $dinas = Dinas::findOrFail($id);
        $dinas->update([
            'nama_dinas' => $request->nama_dinas,
            'nama_lengkap_dinas' => $request->nama_lengkap_dinas, 
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Data dinas berhasil diperbarui.');
    }

    public function destroyDinas($id)
    {
        $dinas = Dinas::findOrFail($id);

        $dinas->delete();

        return redirect()->back()->with('success', 'Dinas berhasil dihapus.');
    }
}
