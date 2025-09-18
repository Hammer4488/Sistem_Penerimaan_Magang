<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('Pelamar.Auth.Login');
    }
    public function ShowDaftarForm()
    {
        return view('Pelamar.Auth.Daftar');
    }
}
