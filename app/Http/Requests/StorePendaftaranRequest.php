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
        return [
            'id_dinas'        => 'required|exists:dinas,id_dinas',
            'id_divisi'       => 'required|exists:divisi,id_divisi',
            'nama_lengkap'    => 'required|string|max:255',
            'nis_nim'         => 'required|string|max:20|unique:pendaftaran,nis_nim',
            'alamat'          => 'required|string',
            'no_hp_aktif'     => 'required|string|max:20',
            'asal_sekolah_universitas'    => 'required|string|max:255',
            'jurusan_program_studi'         => 'required|string|max:255',
            'tanggal_mulai_magang'   => 'required|date',
            'tanggal_akhir_magang'   => 'required|date|after:tanggal_mulai',
        ];
    }

    /**
     * Tangani upaya validasi yang gagal.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // [LOGGING] Catat kegagalan validasi ke dalam log
        Log::warning('Upaya pendaftaran gagal validasi.', [
            'user_id'      => Auth::id() ?? 'Guest',
            'errors'       => $validator->errors()->messages(), // Error spesifik per field
            'input_data'   => $this->except(['_token', 'password', 'password_confirmation']) // Data yang diinput pengguna
        ]);

        // Jalankan perilaku default Laravel (redirect kembali dengan error)
        parent::failedValidation($validator);
    }
}