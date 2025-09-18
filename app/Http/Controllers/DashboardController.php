<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function ShowDashboardForm()
    {
        return view('Pelamar.Page.Dashboard');
    }
    public function ShowKuotaMagangForm()
    {
        return view('Pelamar.Page.KuotaMagang');
    }
}
