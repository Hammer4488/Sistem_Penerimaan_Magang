<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Session; 

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('Auth.Login');
    }

    public function ShowDaftarForm()
    {
        return view('Auth.Daftar');
    }

public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role) {
                case 'admin dinas':
                    return redirect()->intended(route('beranda.dinas')); 

                case 'super admin':
                    return redirect()->intended(route('superadmin.dashboard'));

                case 'pelamar':
                default:
                    return redirect()->intended(route('berandapelamar'));
            }
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', '      ', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        Auth::login($user);

        return redirect()->route('berandapelamar');
    }

        public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return redirect()->route('beranda'); 
    }
}
