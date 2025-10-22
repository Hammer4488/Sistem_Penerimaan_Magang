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
        Schema::create('divisi', function (Blueprint $table) {
            $table->id('id_divisi')->autoIncrement(); // Primary key 'id'
            $table->foreignId('id_dinas')->constrained('dinas', 'id_dinas')->onDelete('cascade');
            $table->string('nama_divisi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisi');
    }
};
