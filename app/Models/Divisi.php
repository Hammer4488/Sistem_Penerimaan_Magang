<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $primaryKey = 'id_divisi';
    protected $table = 'divisi';
    protected $fillable = [
        'id_dinas',
        'nama_divisi',
        'total_kuota',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_divisi', 'id_divisi');
    }

    public function getSisaKuotaAttribute()
    {
        $terisi = $this->pendaftaran_count ?? 0;

        $sisa = $this->total_kuota - $terisi;
        
        return $sisa < 0 ? 0 : $sisa;
    }
}
