<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function showBerandaPendaftarForm()
    {
        return view('Pelamar.Page.BerandaPendaftar');
    }
}
