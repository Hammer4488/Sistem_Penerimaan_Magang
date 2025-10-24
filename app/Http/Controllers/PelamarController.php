<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use App\Http\Requests\StorePendaftaranRequest;
use Illuminate\Support\Facades\Validator; // 1. Import Validator
use Illuminate\Support\Facades\Auth; // <-- Penting untuk mengambil data user
use Illuminate\Http\RedirectResponse;

class PelamarController extends Controller
{
    public function beranda_index()
    {
        // Mengambil seluruh data user yang sedang login
        $user = Auth::user();

        // Mengirim data user ke view agar bisa digunakan, contoh: {{ $user->name }}
        return view('Pelamar.Page.BerandaPelamar', ['user' => $user]);
    }
    public function ajukan_index()
    {
        $user = Auth::user();
        $dinasList = Dinas::withCount(['pendaftaran' => function ($query) {
            $query->where('status', 'diterima');
        }])->get();

        $pendaftaranPengguna = Pendaftaran::where('id_user', $user->id)
            ->where('status', '!=', 'ditolak')
            ->pluck('id_dinas')
            ->toArray();

        return view('Pelamar.Page.AjukanPelamar', [
            'user' => $user,
            'dinasList' => $dinasList,
            'pendaftaranPengguna' => $pendaftaranPengguna // [BARU] Kirim data ini ke view
        ]);
    }

    public function status_index()
    {
        $user = Auth::user();

        // 1. Ambil data riwayat pendaftaran
        $riwayatPendaftaran = Pendaftaran::where('id_user', $user->id)
            ->with('dinas')
            ->oldest()
            ->get();

        // 2. Kirim SEMUA data yang dibutuhkan ke view dalam SATU kali return
        return view('Pelamar.Page.StatusPelamar', [
            'user'               => $user,
            'riwayatPendaftaran' => $riwayatPendaftaran // Variabel ini sekarang ikut terkirim
        ]);
    }

    public function show(Pendaftaran $pendaftaran)
    {
        // Kebijakan keamanan: pastikan pendaftaran ini milik pengguna yang sedang login
        if ($pendaftaran->id_user !== Auth::id()) { // <-- DIUBAH
            abort(403, 'AKSES DITOLAK');
        }

        return view('Pelamar.Page.FormPelamar', [
            'user'        => Auth::user(), // <-- DIUBAH
            'dinas'       => $pendaftaran->dinas,
            'divisiList'  => $pendaftaran->dinas->divisi,
            'pendaftaran' => $pendaftaran, // Kirim data pendaftaran yang sudah ada
            'mode'        => 'show' // Kirim variabel 'mode' untuk menandai ini halaman detail
        ]);
    }




    /**
     * Menampilkan form untuk membuat pendaftaran baru.
     */
    // app/Http-Controllers/PelamarController.php

    public function pendaftaran_create(Dinas $dinas)
    {
        // Mengambil semua divisi yang dimiliki oleh dinas yang dipilih
        $divisiList = $dinas->divisi;

        return view('Pelamar.Page.FormPelamar', [
            'user'       => Auth::user(),
            'dinas'      => $dinas,
            'divisiList' => $divisiList // <-- KIRIM DATA DIVISI KE VIEW
        ]);
    }

    public function store(StorePendaftaranRequest $request)
    {
        try {
            // Langsung ambil data yang sudah dijamin valid
            $validatedData = $request->validated();

            // Simpan data ke database
            // [PERBAIKAN] Menggabungkan id_user dengan data tervalidasi
            Pendaftaran::create(array_merge(
                ['id_user' => Auth::id()],
                $validatedData
            ));

            return redirect()->route('statuspelamar')->with('success', 'Pendaftaran Anda berhasil diajukan!');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pendaftaran ke database.', [
                'error_message' => $e->getMessage(),
                'user_id'       => Auth::id(),
                'input_data'    => $request->validated()
            ]);

            $errorMessage = 'Terjadi kesalahan pada sistem saat menyimpan data. Silakan coba beberapa saat lagi.';
            return back()->withInput()->with('error', $errorMessage);
        }
    }
}
