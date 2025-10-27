<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id('id_dokumen')->autoIncrement();
            $table->foreignId('id_pendaftaran')
                ->constrained('pendaftaran', 'id_pendaftaran')
                ->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('path_file');
            $table->string('nama_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
