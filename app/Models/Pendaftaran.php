<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran'; // <-- TAMBAHKAN BARIS INI
    protected $primaryKey = 'id_pendaftaran';
    protected $casts = [
        'tanggal_mulai_magang' => 'date',
        'tanggal_akhir_magang' => 'date',
    ];

    protected $fillable = [
        'id_user',
        'id_dinas',
        'id_divisi',
        'id_grup',
        'nama_lengkap',
        'nis_nim',
        'alamat',
        'no_hp_aktif',
        'asal_sekolah_universitas',
        'jurusan_program_studi',
        'tanggal_mulai_magang',
        'tanggal_akhir_magang',
        'status',
        'keterangan_status',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas');
    }
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id_divisi');
    }
    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'id_pendaftaran');
    }

    public function suratBalasan()
{
    return $this->hasOne(Dokumen::class, 'id_pendaftaran')
                ->where('jenis_dokumen', 'surat_balasan');
}
    
    public function anggotaGrup()
    {
        return $this->hasMany(Pendaftaran::class, 'id_grup', 'id_grup');
    }
}
