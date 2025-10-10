<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Penting untuk mengambil data user

class PelamarController extends Controller
{
    public function showBerandaPelamarForm()
    {
        // Mengambil seluruh data user yang sedang login
        $user = Auth::user();

        // Mengirim data user ke view agar bisa digunakan, contoh: {{ $user->name }}
        return view('Pelamar.Page.BerandaPelamar', ['user' => $user]);
    }
    public function showAjukanPelamarForm()
    {
        $user = Auth::user();

        // Mengirim data user ke view agar namanya bisa langsung ditampilkan di form
        return view('Pelamar.Page.AjukanPelamar', ['user' => $user]);
    }
}
