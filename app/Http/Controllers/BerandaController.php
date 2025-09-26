<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Penting untuk mengambil data user

class BerandaController extends Controller
{
        public function ShowBerandaForm()
    {
        return view('Pelamar.Page.Beranda');
    }
    public function ShowKuotaMagangForm()
    {
        return view('Pelamar.Page.KuotaMagang');
    }

}
