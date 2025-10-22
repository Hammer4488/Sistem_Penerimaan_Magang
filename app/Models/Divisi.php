<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $fillable = ['id_dinas', 'nama_divisi'];
    protected $table = 'divisi';

    // Mendefinisikan bahwa satu Divisi dimiliki oleh satu Dinas
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'id_dinas', 'id_dinas');
    }   
}