<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan ini ada di bagian atas file
use Illuminate\Support\Facades\Hash; // Pastikan ini ada di bagian atas file
use Illuminate\Support\Facades\Session; // Import Session


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

    public function login(Request $request)
    {
        // 1. Validasi input form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba autentikasi user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Jika berhasil, arahkan ke halaman beranda pelamar
            // Ganti 'pelamar.beranda' dengan nama rute halaman dashboard Anda
            return redirect()->intended(route('berandapelamar'));
        }

        // 4. Jika gagal, kembali ke halaman login dengan pesan error
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

        // 2. Buat user baru di database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // 3. Login user yang baru dibuat secara otomatis
        Auth::login($user);

        // 4. Arahkan ke halaman beranda pelamar
        // Ganti 'pelamar.beranda' dengan nama rute halaman dashboard Anda
        return redirect()->route('beranda');
    }

        public function logout(Request $request)
    {
        Auth::logout(); // Hapus sesi autentikasi pengguna

        $request->session()->invalidate(); // Batalkan sesi yang ada
        $request->session()->regenerateToken(); // Buat ulang token CSRF untuk keamanan

        // Redirect pengguna ke halaman login setelah logout
        return redirect()->route('beranda'); // Ganti 'masuk' jika nama rute login Anda berbeda
    }
}
