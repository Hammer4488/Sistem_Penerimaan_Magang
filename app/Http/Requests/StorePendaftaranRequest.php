<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
// Tambahkan dua 'use' statement ini
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;

class StorePendaftaranRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request ini.
     */
    public function rules(): array
    {
        $jumlahAnggotaDiminta = $this->input('jumlah_anggota', 1);

        return [
            'id_dinas'               => 'required|exists:dinas,id_dinas',
            'id_divisi'              => 'required|exists:divisi,id_divisi',
            'nama_lengkap'           => 'required|array|min:' . $jumlahAnggotaDiminta,
            'nama_lengkap.*'         => 'required|string|max:255',                 
            'nis_nim'                => 'required|array|min:' . $jumlahAnggotaDiminta,
            'nis_nim.*'              => 'required|string|max:20', 
            'alamat'                 => 'required|array|min:' . $jumlahAnggotaDiminta,
            'alamat.*'               => 'required|string',
            'no_hp_aktif'            => 'required|array|min:' . $jumlahAnggotaDiminta,
            'no_hp_aktif.*'          => 'required|string|max:20',
            'asal_sekolah_universitas' => 'required|array|min:' . $jumlahAnggotaDiminta,
            'asal_sekolah_universitas.*' => 'required|string|max:255',
            'jurusan_program_studi'  => 'required|array|min:' . $jumlahAnggotaDiminta,
            'jurusan_program_studi.*'  => 'required|string|max:255',
            'tanggal_mulai_magang'   => 'required|date|after_or_equal:today',
            'tanggal_akhir_magang' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai_magang' 
            ],
            'keterangan_status' => 'nullable|string',
            'surat_pengantar' => 'required|file|mimes:pdf,jpg,png|max:2048', 
            'cv'              => 'required|file|mimes:pdf,jpg,png|max:2048', 
        ];
    }

    public function messages(): array
    {
        return [
            // --- Error Data Umum ---
            'id_dinas.required'       => 'Silakan pilih dinas tujuan.',
            'id_dinas.exists'         => 'Dinas yang dipilih tidak valid.',
            'id_divisi.required'      => 'Silakan pilih divisi tujuan.',
            'id_divisi.exists'        => 'Divisi yang dipilih tidak valid.',

            // --- Error Tanggal ---
            'tanggal_mulai_magang.required' => 'Tanggal mulai magang wajib diisi.',
            'tanggal_mulai_magang.date'     => 'Format tanggal mulai tidak valid.',
            'tanggal_akhir_magang.required' => 'Tanggal akhir magang wajib diisi.',
            'tanggal_akhir_magang.date'     => 'Format tanggal akhir tidak valid.',
            'tanggal_akhir_magang.after_or_equal' => 'Tanggal akhir tidak boleh diatur sebelum tanggal mulai.',
            'tanggal_mulai_magang.after_or_equal' => 'Tanggal mulai magang tidak boleh kurang dari hari ini.',
            'tanggal_akhir_magang.after' => 'Tanggal akhir magang harus setelah tanggal mulai.',

            // --- Error Array (Min) ---
            'nama_lengkap.min'  => 'Jumlah nama lengkap tidak sesuai dengan jumlah anggota.',
            'nis_nim.min'       => 'Jumlah NIS/NIM tidak sesuai dengan jumlah anggota.',
            'alamat.min'        => 'Jumlah alamat tidak sesuai dengan jumlah anggota.',
            'no_hp_aktif.min'   => 'Jumlah No. HP tidak sesuai dengan jumlah anggota.',
            'asal_sekolah_universitas.min' => 'Jumlah asal sekolah tidak sesuai dengan jumlah anggota.',
            'jurusan_program_studi.min'  => 'Jumlah jurusan tidak sesuai dengan jumlah anggota.',

            // --- Error Per Anggota (.*) ---
            'nama_lengkap.*.required' => 'Nama lengkap (setiap anggota) wajib diisi.',
            'nama_lengkap.*.max'      => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            
            'nis_nim.*.required'  => 'NIS/NIM (setiap anggota) wajib diisi.',
            'nis_nim.*.max'       => 'NIS/NIM tidak boleh lebih dari 20 karakter.',
            'nis_nim.*.distinct'  => 'NIS/NIM tidak boleh sama/duplikat dalam satu pengajuan.',
            'nis_nim.*.unique'    => 'NIS/NIM ini sudah terdaftar di sistem.',
            
            'alamat.*.required'   => 'Alamat (setiap anggota) wajib diisi.',
            
            'no_hp_aktif.*.required' => 'No. HP (setiap anggota) wajib diisi.',
            'no_hp_aktif.*.max'      => 'No. HP tidak boleh lebih dari 20 karakter.',
            
            'asal_sekolah_universitas.*.required' => 'Asal sekolah/universitas (setiap anggota) wajib diisi.',
            
            'jurusan_program_studi.*.required'  => 'Jurusan/Program Studi (setiap anggota) wajib diisi.',

            // --- Error File Upload ---
            'surat_pengantar.required' => 'File surat pengantar wajib diunggah.',
            'surat_pengantar.file'     => 'Surat pengantar harus berupa file.',
            'surat_pengantar.mimes'    => 'Format surat pengantar harus PDF, JPG, atau PNG.',
            'surat_pengantar.max'      => 'Ukuran surat pengantar tidak boleh lebih dari 2 MB.',
            
            'cv.required' => 'File CV wajib diunggah.',
            'cv.file'     => 'CV harus berupa file.',
            'cv.mimes'    => 'Format CV harus PDF, JPG, atau PNG.',
            'cv.max'      => 'Ukuran CV tidak boleh lebih dari 2 MB.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
      
        Log::warning('Upaya pendaftaran gagal validasi.', [
            'user_id'      => Auth::id() ?? 'Guest',
            'errors'       => $validator->errors()->messages(), 
            'input_data'   => $this->except(['_token', 'password', 'password_confirmation']) 
        ]);

       
        parent::failedValidation($validator);
    }
}
