<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Dinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 

class DivisiController extends Controller
{
    public function index()
    {
        $id_dinas_admin = Auth::user()->id_dinas;

        $divisis = Divisi::where('id_dinas', $id_dinas_admin)
            ->withCount(['pendaftaran' => function ($query) {
                $query->where('status', 'diterima');
            }])
            ->latest()
            ->get();

        return view('Admin_Dinas.Page.KuotaDinas', compact('divisis'));
    }

    public function create()
    {
        $dinasList = Dinas::all();
        return view('admin.divisi.create', compact('dinasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'total_kuota' => 'required|integer|min:1',
        ]);

        $id_dinas_admin = Auth::user()->id_dinas;

        Divisi::create([
            'id_dinas' => $id_dinas_admin,
            'nama_divisi' => $request->nama_divisi,
            'total_kuota' => $request->total_kuota,
        ]);

        return redirect()->route('Admin_Dinas.page.KuotaDinas')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'total_kuota' => 'required|integer|min:1',
        ]);

        if ($divisi->id_dinas != Auth::user()->id_dinas) {
            return redirect()->route('Admin_Dinas.page.KuotaDinas')
                ->with('error', 'Anda tidak punya hak akses.');
        }

        $namaBerubah  = $divisi->nama_divisi != $request->nama_divisi;
        $kuotaBerubah = $divisi->total_kuota != $request->total_kuota;

        $divisi->update([
            'nama_divisi' => $request->nama_divisi,
            'total_kuota' => $request->total_kuota,
        ]);

        if ($namaBerubah && $kuotaBerubah) {
            $pesan = 'Divisi dan Kuota berhasil diperbarui.';
        } elseif ($namaBerubah) {
            $pesan = 'Nama Divisi berhasil diperbarui.';
        } elseif ($kuotaBerubah) {
            $pesan = 'Kuota berhasil diperbarui.';
        } else {
            $pesan = 'Data berhasil disimpan (Tidak ada perubahan).';
        }

        return redirect()->route('Admin_Dinas.page.KuotaDinas')
            ->with('success', $pesan);
    }

    public function destroy(Divisi $divisi)
    {
        if ($divisi->id_dinas != Auth::user()->id_dinas) {
            return redirect()->route('Admin_Dinas.page.KuotaDinas')
                ->with('error', 'Anda tidak punya hak akses.');
        }

        $divisi->delete();

        return redirect()->route('Admin_Dinas.page.KuotaDinas')
            ->with('deleted', 'Divisi berhasil dihapus.');
    }
}
