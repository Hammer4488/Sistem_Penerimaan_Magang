<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // <--- TAMBAHKAN INI

class AkunController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query dasar dengan Eager Loading 'dinas' agar efisien
        $query = User::with('dinas');

        // 2. Logika Search (Nama atau Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. Logika Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 4. Ambil data dengan pagination (misal 10 per halaman)
        // withQueryString() penting agar parameter search/filter tidak hilang saat pindah halaman
        $users = $query->latest()->paginate(10)->withQueryString();

        // 5. Ambil daftar dinas untuk dropdown di Modal
        $list_dinas = Dinas::all();

        return view('Super_admin.Page.AkunSuper', compact('users', 'list_dinas'));
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
            'role'      => 'required|in:super admin,admin dinas,pelamar',
            // id_dinas wajib diisi HANYA JIKA role adalah 'admin dinas'
            'id_dinas'  => [
                'nullable',
                'exists:dinas,id_dinas', // sesuaikan nama primary key tabel dinas
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role === 'admin dinas' && empty($value)) {
                        $fail('Kolom Dinas wajib dipilih untuk role Admin Dinas.');
                    }
                },
            ],
        ]);

        // 2. Tentukan id_dinas (Pastikan NULL jika role bukan admin dinas)
        $id_dinas = ($request->role === 'admin dinas') ? $request->id_dinas : null;

        // 3. Simpan Data
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'id_dinas'  => $id_dinas,
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Mengupdate data user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'name'      => 'required|string|max:255',
            // Unique email, tapi kecualikan ID user ini
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'      => 'required|in:super admin,admin dinas,pelamar',
            'id_dinas'  => [
                'nullable',
                'exists:dinas,id_dinas',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role === 'admin dinas' && empty($value)) {
                        $fail('Kolom Dinas wajib dipilih untuk role Admin Dinas.');
                    }
                },
            ],
            // Password boleh kosong (nullable) jika tidak ingin diganti
            'password'  => 'nullable',
        ]);

        // 2. Persiapan Data Update
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            // Jika role diubah jadi bukan admin dinas, paksa id_dinas jadi NULL
            'id_dinas'  => ($request->role === 'admin dinas') ? $request->id_dinas : null,
        ];

        // 3. Cek apakah password diisi? Jika ya, hash dan masukkan ke data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 4. Eksekusi Update
        $user->update($data);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Opsional: Cegah hapus diri sendiri (sedang login)
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
