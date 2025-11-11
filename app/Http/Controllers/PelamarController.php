<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePendaftaranRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PelamarController extends Controller
{
    public function beranda_index()
    {

        $user = Auth::user();
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

        $sudahMendaftar = Pendaftaran::where('id_user', $user->id)
            ->whereIn('status', ['diproses', 'diterima'])
            ->exists();

        return view('Pelamar.Page.AjukanPelamar', [
            'user' => $user,
            'dinasList' => $dinasList,
            'pendaftaranPengguna' => $pendaftaranPengguna,
            'sudahMendaftar' => $sudahMendaftar
        ]);
    }

    public function riwayat_index()
    {
        $user = Auth::user();

        $semuaPendaftaran = Pendaftaran::where('id_user', $user->id)
            ->with('dinas')
            ->oldest()
            ->get();

        $pendaftaranIndividu = $semuaPendaftaran->whereNull('id_grup');

        $pendaftaranGrup = $semuaPendaftaran->whereNotNull('id_grup')
            ->groupBy('id_grup')
            ->map(function ($grup) {

                return $grup->first();
            });
        $riwayatList = $pendaftaranIndividu->merge($pendaftaranGrup)
            ->sortBy('created_at');

        return view('Pelamar.Page.RiwayatPelamar', [
            'user'               => $user,
            'riwayatList' => $riwayatList
        ]);
    }

    public function show(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->id_user !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $pendaftaran->load('dinas.divisi', 'dokumen');

        $anggotaList = null; // Buat variabel baru
        if ($pendaftaran->id_grup) {
            $anggotaList = Pendaftaran::where('id_grup', $pendaftaran->id_grup)
                ->orderBy('nama_lengkap', 'asc')
                ->get();
        }

        return view('Pelamar.Page.FormPelamar', [
            'user'        => Auth::user(),
            'dinas'       => $pendaftaran->dinas,
            'divisiList'  => $pendaftaran->dinas->divisi,
            'pendaftaran' => $pendaftaran,
            'anggotaList' => $anggotaList,
            'mode'        => 'show'
        ]);
    }

    public function pendaftaran_create(Request $request, Dinas $dinas)
    {
        $divisiList = $dinas->divisi;

        $jumlahAnggota = $request->query('jumlah', 1);

        return view('Pelamar.Page.FormPelamar', [
            'user'       => Auth::user(),
            'dinas'      => $dinas,
            'divisiList' => $divisiList,
            'jumlahAnggota' => $jumlahAnggota
        ]);
    }

    public function store(StorePendaftaranRequest $request)
    {
        DB::beginTransaction();

        try {

            $validatedData = $request->validated();
            $jumlahAnggota = count($validatedData['nama_lengkap']);
            $pendaftaranUtamaId = null;
            $idGrup = null;

            if ($jumlahAnggota > 1) {
                $idGrup = (string) Str::uuid(); // Membuat ID unik untuk grup
            }

            for ($i = 0; $i < $jumlahAnggota; $i++) {

                $pendaftaran = Pendaftaran::create([

                    'id_user'                 => Auth::id(),
                    'id_dinas'                => $validatedData['id_dinas'],
                    'id_divisi'               => $validatedData['id_divisi'],
                    'id_grup'               => $idGrup,
                    'tanggal_mulai_magang'    => $validatedData['tanggal_mulai_magang'],
                    'tanggal_akhir_magang'  => $validatedData['tanggal_akhir_magang'],
                    'nama_lengkap'              => $validatedData['nama_lengkap'][$i],
                    'nis_nim'                 => $validatedData['nis_nim'][$i],
                    'alamat'                  => $validatedData['alamat'][$i],
                    'no_hp_aktif'             => $validatedData['no_hp_aktif'][$i],
                    'asal_sekolah_universitas'  => $validatedData['asal_sekolah_universitas'][$i],
                    'jurusan_program_studi'   => $validatedData['jurusan_program_studi'][$i],
                ]);
                if ($i == 0) {
                    $pendaftaranUtamaId = $pendaftaran->id_pendaftaran;
                }

                if (!$pendaftaran) {
                    throw new \Exception("Gagal membuat data pendaftaran untuk anggota ke-" . ($i + 1));
                }
            }

            if ($request->hasFile('surat_pengantar')) {
                $file = $request->file('surat_pengantar');
                $namaFileAsli = $file->getClientOriginalName();
                $pathFile = $file->store('dokumen_surat', 'public');

                Dokumen::create([
                    'id_pendaftaran' => $pendaftaranUtamaId,
                    'jenis_dokumen'  => 'surat_pengantar',
                    'path_file'      => $pathFile,
                    'nama_file' => $namaFileAsli,
                ]);
            }

            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $namaFileAsli = $file->getClientOriginalName();
                $pathFile = $file->store('dokumen_cv', 'public');

                Dokumen::create([
                    'id_pendaftaran' => $pendaftaranUtamaId,
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
