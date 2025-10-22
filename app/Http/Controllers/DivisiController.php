<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Dinas;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::with('dinas')->latest()->get();
        return view('admin.divisi.index', compact('divisis'));
    }

    public function create()
    {
        $dinasList = Dinas::all();
        return view('admin.divisi.create', compact('dinasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dinas' => 'required|exists:dinas,id_dinas',
            'nama_divisi' => 'required|string|max:255',
        ]);

        Divisi::create($request->all());

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Divisi $divisi)
    {
        $dinasList = Dinas::all();
        return view('admin.divisi.edit', compact('divisi', 'dinasList'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'id_dinas' => 'required|exists:dinas,id_dinas',
            'nama_divisi' => 'required|string|max:255',
        ]);

        $divisi->update($request->all());

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();
        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil dihapus.');
    }
}