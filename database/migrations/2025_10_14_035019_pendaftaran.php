<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_dinas')->constrained('dinas', 'id_dinas');
            $table->string('nama_lengkap');
            $table->string('nim_nis', 20);
            $table->string('alamat');
            $table->string('no_hp_aktif');
            $table->string('asal_sekolah_universitas');
            $table->string('pilih_divisi');
            $table->string('jurusan_program_studi');
            $table->date('tanggal_mulai_magang');
            $table->date('tanggal_berakhir_magang');
            $table->enum('status', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
