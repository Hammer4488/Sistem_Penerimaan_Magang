<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Penting untuk mengambil data user

class PelamarController extends Controller
{   
        public function showBerandaPelamarForm()
    {
        return view('Pelamar.Page.BerandaPelamar');
    }

        public function index()
    {
        // Ambil nama dari user yang sedang login saat ini
        $namaUser = Auth::user()->name;

        // Kirim data nama tersebut ke view saat merender halaman
        return view('Pelamar.Page.BerandaPelamar', ['nama' => $namaUser]);
    }
}
