<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Dokumen; // [BARU] Import model Dokumen
use App\Models\Pendaftaran; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePendaftaranRequest;
use Illuminate\Support\Facades\Validator; // 1. Import Validator
use Illuminate\Support\Facades\Auth; // <-- Penting untuk mengambil data user
use Illuminate\Support\Facades\Storage; // [BARU] Import Storage
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

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

    public function riwayat_index()
    {
        $user = Auth::user();

        // 1. Ambil data riwayat pendaftaran
        $riwayatPendaftaran = Pendaftaran::where('id_user', $user->id)
            ->with('dinas')
            ->oldest()
            ->get();

        // 2. Kirim SEMUA data yang dibutuhkan ke view dalam SATU kali return
        return view('Pelamar.Page.RiwayatPelamar', [
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

        $pendaftaran->load('dinas.divisi', 'dokumen');



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

    public function pendaftaran_create(Request $request,Dinas $dinas)
    {
        // Mengambil semua divisi yang dimiliki oleh dinas yang dipilih
        $divisiList = $dinas->divisi;

        $jumlahAnggota = $request->query('jumlah', 1);

        return view('Pelamar.Page.FormPelamar', [
            'user'       => Auth::user(),
            'dinas'      => $dinas,
            'divisiList' => $divisiList, // <-- KIRIM DATA DIVISI KE VIEW
            'jumlahAnggota' => $jumlahAnggota // Kirim jumlah anggota ke view
        ]);
    }

    public function store(StorePendaftaranRequest $request)
    {
DB::beginTransaction();
        
        try {
            // Ambil semua data yang sudah divalidasi
            $validatedData = $request->validated();

            // Hitung ada berapa anggota yang didaftarkan (berdasarkan jumlah 'nama_lengkap')
            $jumlahAnggota = count($validatedData['nama_lengkap']);
            $pendaftaranUtamaId = null; // Untuk menyimpan ID pendaftaran ketua (anggota pertama)

            // --- Mulai Looping ---
            // Lakukan perulangan sebanyak jumlah anggota
            for ($i = 0; $i < $jumlahAnggota; $i++) {
                
                // Buat record pendaftaran BARU untuk setiap anggota
                $pendaftaran = Pendaftaran::create([
                    // Data ini sama untuk semua anggota dalam kelompok
                    'id_user'                 => Auth::id(), 
                    'id_dinas'                => $validatedData['id_dinas'],
                    'id_divisi'               => $validatedData['id_divisi'], 
                    'tanggal_mulai_magang'    => $validatedData['tanggal_mulai_magang'],
                    'tanggal_akhir_magang'  => $validatedData['tanggal_akhir_magang'],
                    
                    // Data ini spesifik per anggota, diambil dari array menggunakan index [$i]
                    'nama_lengkap'              => $validatedData['nama_lengkap'][$i],
                    'nis_nim'                 => $validatedData['nis_nim'][$i],
                    'alamat'                  => $validatedData['alamat'][$i], 
                    'no_hp_aktif'             => $validatedData['no_hp_aktif'][$i], 
                    'asal_sekolah_universitas'  => $validatedData['asal_sekolah_universitas'][$i],
                    'jurusan_program_studi'   => $validatedData['jurusan_program_studi'][$i],
                ]);

                // Simpan ID pendaftaran anggota pertama (ketua)
                // Dokumen akan dikaitkan dengan ID ini
                if ($i == 0) {
                    $pendaftaranUtamaId = $pendaftaran->id_pendaftaran;
                }

                // Periksa jika pendaftaran gagal dibuat
                if (!$pendaftaran) {
                    throw new \Exception("Gagal membuat data pendaftaran untuk anggota ke-" . ($i+1));
                }
            }
            if ($request->hasFile('surat_pengantar')) {
                $file = $request->file('surat_pengantar');
                $namaFileAsli = $file->getClientOriginalName();
                // Simpan file ke 'storage/app/public/dokumen_surat' dengan nama unik
                $pathFile = $file->store('dokumen_surat', 'public');

                Dokumen::create([
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran, // Gunakan ID dari pendaftaran yg baru dibuat
                    'jenis_dokumen'  => 'surat_pengantar',
                    'path_file'      => $pathFile,
                    'nama_file' => $namaFileAsli,
                ]);
            }

            // 3. Proses upload dan simpan CV
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $namaFileAsli = $file->getClientOriginalName();
                // Simpan file ke 'storage/app/public/dokumen_cv' dengan nama unik
                $pathFile = $file->store('dokumen_cv', 'public');

                Dokumen::create([
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran, // Gunakan ID dari pendaftaran yg baru dibuat
                    'jenis_dokumen'  => 'cv',
                    'path_file'      => $pathFile,
                    'nama_file' => $namaFileAsli,
                ]);
            }
            DB::commit();

            return redirect()->route('riwayatpelamar')->with('success', 'Pendaftaran Anda berhasil diajukan!');




        } catch (\Exception $e) {
            DB::rollBack();
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
