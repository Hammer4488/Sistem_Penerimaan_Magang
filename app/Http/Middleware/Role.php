<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta route
        // Kita gunakan operator (!==) agar tipe data string terjaga
        if (Auth::user()->role !== $role) {
            // Jika role salah, tampilkan halaman 403 (Forbidden)
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }
        return $next($request);
    }
}
