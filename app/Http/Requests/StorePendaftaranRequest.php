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
            'nis_nim.*'              => 'required|string|max:20|distinct|unique:pendaftaran,nis_nim', 
            'alamat'                 => 'required|array|min:' . $jumlahAnggotaDiminta,
            'alamat.*'               => 'required|string',
            'no_hp_aktif'            => 'required|array|min:' . $jumlahAnggotaDiminta,
            'no_hp_aktif.*'          => 'required|string|max:20',
            'asal_sekolah_universitas' => 'required|array|min:' . $jumlahAnggotaDiminta,
            'asal_sekolah_universitas.*' => 'required|string|max:255',
            'jurusan_program_studi'  => 'required|array|min:' . $jumlahAnggotaDiminta,
            'jurusan_program_studi.*'  => 'required|string|max:255',
            'tanggal_mulai_magang'   => 'required|date',
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
