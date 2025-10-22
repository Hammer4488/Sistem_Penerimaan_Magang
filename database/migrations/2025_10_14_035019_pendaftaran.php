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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran')->autoIncrement();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_dinas')->constrained('dinas', 'id_dinas');
            $table->foreignId('id_divisi')->constrained('divisi', 'id_divisi');
            $table->string('nama_lengkap');
            $table->string('nis_nim', 20);
            $table->string('alamat');
            $table->string('no_hp_aktif');
            $table->string('asal_sekolah_universitas');
            $table->string('jurusan_program_studi');
            $table->date('tanggal_mulai_magang');
            $table->date('tanggal_akhir_magang');
            $table->enum('status', ['diproses', 'diterima', 'ditolak', 'selesai'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
