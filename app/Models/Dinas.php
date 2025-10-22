<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini di atas
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    use HasFactory;

    protected $table = 'dinas';
    protected $primaryKey = 'id_dinas';
    protected $fillable = [
        'nama_dinas',
        'nama_lengkap_dinas',
        'deskripsi',
        'sisa_kuota',
        'total_kuota',
    ];

    // ... di dalam class Dinas ...

    // Mendefinisikan bahwa satu Dinas memiliki banyak Divisi
    public function divisi()
    {
        return $this->hasMany(Divisi::class, 'id_dinas', 'id_dinas');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_dinas', 'id_dinas');
    }
}
