<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini di atas
use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
        /**
     * V TAMBAHKAN FUNGSI INI V
     * Mendefinisikan relasi One-to-Many ke Pendaftaran.
     */
    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'id_dinas');
    }

    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dinas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_dinas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_dinas',
        'deskripsi',
        'total_kuota',
    ];
}