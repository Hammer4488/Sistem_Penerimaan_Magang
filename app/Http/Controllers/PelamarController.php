<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Penting untuk mengambil data user

class PelamarController extends Controller
{
    public function beranda_index()
    {
        // Mengambil seluruh data user yang sedang login
        $user = Auth::user();

        // Mengirim data user ke view agar bisa digunakan, contoh: {{ $user->name }}
        return view('Pelamar.Page.BerandaPelamar', ['user' => $user]);
    }
    public function ajukan_index()
    {
        $user = Auth::user();
        // Mengambil semua data dinas beserta JUMLAH pendaftarannya
        $dinasList = Dinas::withCount('pendaftarans')->get();

        return view('Pelamar.Page.AjukanPelamar', [
            'user' => $user,
            'dinasList' => $dinasList
        ]);
    }

    public function status_index()
    {
        $user = Auth::user();

        return view('Pelamar.Page.StatusPelamar', ['user' => $user]);
    }


    /**
     * Menampilkan form untuk membuat pendaftaran baru.
     */
    public function pendaftaran_create(Dinas $dinas)
    {
        return view('Pelamar.Page.FormPelamar', [
            'user' => Auth::user(),
            'dinas' => $dinas
        ]);
    }
}
