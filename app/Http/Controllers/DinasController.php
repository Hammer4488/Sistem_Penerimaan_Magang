<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DinasController extends Controller
{
    public function beranda_index()
    {

        $id_dinas = Auth::user()->id_dinas;

        // 2. Hitung jumlah pelamar 'diproses' HANYA untuk dinas ini
        $jumlahDiproses = Pendaftaran::where('id_dinas', $id_dinas)
            ->where('status', 'diproses')
            ->count();

        // 3. Hitung jumlah anak magang 'diterima' HANYA untuk dinas ini
        $jumlahDiterima = Pendaftaran::where('id_dinas', $id_dinas)
            ->where('status', 'diterima')
            ->count();

        // 4. Ambil data kuota dari tabel dinas
        $dinas = Dinas::find($id_dinas);

        // Asumsikan nama kolom kuota adalah 'total_kuota'
        $totalKuota = $dinas ? $dinas->total_kuota : 0;

        // 5. Hitung sisa kuota
        $sisaKuota = $totalKuota - $jumlahDiterima;

        // 6. Kirim semua data ke view
        return view('Admin_Dinas.page.BerandaDinas', [ 
            'active'         => 'berandadinas', 
            'jumlahDiproses' => $jumlahDiproses,
            'jumlahDiterima' => $jumlahDiterima,
            'sisaKuota'      => $sisaKuota,
            'totalKuota'     => $totalKuota,
            'namaDinas'      => $dinas ? $dinas->nama_dinas : 'Admin Dinas'
        ]);
    }
}
