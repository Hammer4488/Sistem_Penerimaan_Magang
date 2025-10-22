<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran'; // <-- TAMBAHKAN BARIS INI
    protected $primaryKey = 'id_pendaftaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_dinas',
        'id_divisi',
        'nama_lengkap',
        'nis_nim',
        'alamat',
        'no_hp_aktif',
        'asal_sekolah_universitas',
        'jurusan_program_studi',
        'tanggal_mulai_magang',
        'tanggal_akhir_magang',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Mendapatkan dinas yang dituju oleh pendaftaran.
     */
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas');
    }
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }
}
