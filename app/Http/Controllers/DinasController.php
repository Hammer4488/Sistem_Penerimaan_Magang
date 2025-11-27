<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DinasController extends Controller
{
    public function beranda()
    {

        $id_dinas = Auth::user()->id_dinas;

        $jumlahDiproses = Pendaftaran::where('id_dinas', $id_dinas)
            ->where('status', 'diproses')
            ->count();

        $jumlahDiterima = Pendaftaran::where('id_dinas', $id_dinas)
            ->where('status', 'diterima')
            ->count();

        $dinas = Dinas::find($id_dinas);
        $totalKuota = $dinas ? $dinas->divisi()->sum('total_kuota') : 0;
        $sisaKuota = $totalKuota - $jumlahDiterima;

        return view('Admin_Dinas.page.BerandaDinas', [
            'active'         => 'berandadinas',
            'jumlahDiproses' => $jumlahDiproses,
            'jumlahDiterima' => $jumlahDiterima,
            'sisaKuota'      => $sisaKuota,
            'totalKuota'     => $totalKuota,
            'namaDinas'      => $dinas ? $dinas->nama_dinas : 'Admin Dinas'
        ]);
    }

    public function pendaftar()
    {
        $id_dinas = Auth::user()->id_dinas;

        $statusFilter = request('status');

        $query = Pendaftaran::where('id_dinas', $id_dinas)
            ->with(['user', 'dokumen', 'anggotaGrup.dokumen', 'anggotaGrup.divisi', 'divisi'])
            ->orderBy('created_at', 'desc');

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $semuaPendaftaran = $query->get();

        $pendaftaranIndividu = $semuaPendaftaran->whereNull('id_grup');

        $pendaftaranGrup = $semuaPendaftaran->whereNotNull('id_grup')
            ->groupBy('id_grup')
            ->map(function ($grup) {
                return $grup->first();
            });

        $pendaftarList = $pendaftaranIndividu->merge($pendaftaranGrup)
            ->sortByDesc('created_at');

        return view('Admin_Dinas.page.PendaftarDinas', [
            'active'        => 'pendaftardinas',
            'pendaftarList' => $pendaftarList
        ]);
    }

    public function approveOnlyPendaftaran(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'pendaftar_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $id = $request->input('pendaftar_id');
            $dataUpdate = ['status' => 'diterima'];

            $updatedCount = Pendaftaran::where('id_grup', $id)
                ->where('status', 'diproses')
                ->update($dataUpdate);

            if ($updatedCount == 0) {
                Pendaftaran::where('id_pendaftaran', $id)
                    ->where('status', 'diproses')
                    ->update($dataUpdate);
            }

            DB::commit();
            return redirect()->route('pendaftar.dinas')->with('success', 'Pendaftaran telah disetujui. Anda sekarang dapat mengirimkan surat balasan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal approve-only pendaftaran: ' . $e->getMessage());
            return redirect()->route('pendaftar.dinas')->with('error', 'Terjadi kesalahan saat menyetujui pendaftaran.');
        }
    }

    public function setujuiPendaftaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pendaftar_id' => 'required',
            'file_surat'   => 'required|file|mimes:pdf|max:2048',
        ], [
            'file_surat.required' => 'Surat balasan wajib diunggah.',
            'file_surat.mimes'    => 'Surat balasan harus berformat PDF.',
            'file_surat.max'      => 'Ukuran surat balasan maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $id = $request->input('pendaftar_id');
            $file = $request->file('file_surat');
            $namaFileAsli = $file->getClientOriginalName();

            $pathFile = $file->store('surat_balasan', 'public');

            $pendaftaranUtama = Pendaftaran::where('id_grup', $id)->first();
            $pendaftaranUtamaId = null;

            if ($pendaftaranUtama) {
                $pendaftaranUtamaId = $pendaftaranUtama->id_pendaftaran;
            } else {
                $pendaftaranUtamaId = $id;
            }

            if ($pendaftaranUtamaId) {
                Dokumen::where('id_pendaftaran', $pendaftaranUtamaId)
                    ->where('jenis_dokumen', 'surat_balasan')
                    ->delete();

                Dokumen::create([
                    'id_pendaftaran' => $pendaftaranUtamaId,
                    'jenis_dokumen'  => 'surat_balasan',
                    'path_file'      => $pathFile,
                    'nama_file'      => $namaFileAsli,
                ]);
            } else {
                throw new \Exception('Data pendaftar tidak ditemukan.');
            }

            DB::commit();

            return redirect()->route('pendaftar.dinas')->with('success', 'Surat balasan berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($pathFile ?? '');
            Log::error('Gagal kirim surat balasan: ' . $e->getMessage());
            return redirect()->route('pendaftar.dinas')->with('error', 'Terjadi kesalahan saat memproses data. ' . $e->getMessage());
        }
    }

    public function detailGrup($id_grup)
    {
        $anggotaGrup = Pendaftaran::where('id_grup', $id_grup)->get();

        if ($anggotaGrup->isEmpty()) {
            return redirect()->route('pendaftar.dinas') // Sesuaikan dengan nama route daftar Anda
                ->with('error', 'Data grup tidak ditemukan.');
        }

        $detailGrup = $anggotaGrup->first();

        return view('Admin_Dinas.page.detail_grup', [
            'anggotaGrup' => $anggotaGrup,
            'detailGrup'  => $detailGrup,
            'id_grup'     => $id_grup
        ]);
    }


    public function tolakPendaftaran(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'pendaftar_id'     => 'required',
            'alasan_penolakan' => 'required|string',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $pendaftaran = Pendaftaran::findOrFail($request->pendaftar_id);

            $dataUpdate = [
                'status'           => 'ditolak',
                'keterangan_status' => $request->alasan_penolakan
            ];

            if ($pendaftaran->id_grup) {
                Pendaftaran::where('id_grup', $pendaftaran->id_grup)
                    ->update($dataUpdate);
            } else {
                $pendaftaran->update($dataUpdate);
            }

            DB::commit();

            return redirect()->route('pendaftar.dinas')->with('success', 'Pendaftaran telah ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal tolak pendaftaran: ' . $e->getMessage());
            return redirect()->route('pendaftar.dinas')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function hapusSuratBalasan(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftaran,id_pendaftaran',
        ]);

        DB::beginTransaction();
        try {
            $id = $request->pendaftar_id;

            $pendaftaranUtama = Pendaftaran::where('id_grup', $id)->first();
            $pendaftaranId = $pendaftaranUtama
                ? $pendaftaranUtama->id_pendaftaran
                : $id;

            $surat = Dokumen::where('id_pendaftaran', $pendaftaranId)
                ->where('jenis_dokumen', 'surat_balasan')
                ->first();

            if (!$surat) {
                return back()->with('error', 'Surat balasan tidak ditemukan.');
            }

            Storage::disk('public')->delete($surat->path_file);

            $surat->delete();

            DB::commit();
            return back()->with('success', 'Surat balasan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus surat balasan: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus surat balasan.');
        }
    }
}
