<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Dinas;

class BerandaController extends Controller
{
    public function ShowBerandaForm()
    {
        return view('Pelamar.Page.Beranda');
    }
    public function ShowKuotaMagangForm()
    {
        $dinasList = Dinas::withCount(['pendaftaran' => function ($query) {
            $query->where('status', 'diterima');
        }])
            ->withSum('divisi', 'total_kuota') 
            ->get();
        return view('Pelamar.Page.KuotaMagang', ['dinasList' => $dinasList]);
    }
}

