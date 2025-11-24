<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // --- 1. MEMBUAT DATA DINAS ---
        // 'total_kuota' (indeks 4) dari array lama akan kita gunakan nanti di divisi
        $dinasData = [
            ['Diskominfotik', 'Dinas Komunikasi, Informatika, dan Statistik', 'Dinas yang menangani bidang komunikasi, informatika, dan statistik daerah.', 5, 10],
            ['Dinas Pendidikan', 'Dinas Pendidikan Kota Banjarmasin', 'Dinas yang menangani bidang pendidikan dasar, menengah, dan nonformal.', 0, 10],
            ['PUPR', 'Dinas Pekerjaan Umum dan Penataan Ruang', 'Dinas yang menangani pembangunan infrastruktur dan tata ruang kota.', 5, 10],
            // ... (data dinas lainnya bisa ditambahkan di sini)
        ];

        foreach ($dinasData as $dinas) {
            DB::table('dinas')->insert([
                'nama_dinas' => $dinas[0],
                'nama_lengkap_dinas' => $dinas[1],
                'deskripsi' => $dinas[2],
                // 'total_kuota' DIHAPUS DARI SINI
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --- 2. AMBIL ID DINAS (SETELAH DIBUAT) ---
        $kominfotikId = DB::table('dinas')->where('nama_dinas', 'Diskominfotik')->value('id_dinas');
        $pendidikanId = DB::table('dinas')->where('nama_dinas', 'Dinas Pendidikan')->value('id_dinas');
        $puprId = DB::table('dinas')->where('nama_dinas', 'PUPR')->value('id_dinas');

        // --- 3. MEMBUAT DATA USERS ---
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'su@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'super admin',
                'id_dinas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Diskominfotik',
                'email' => 'adis@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin dinas',
                'id_dinas' => $kominfotikId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AzkaGG',
                'email' => 'az@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'pelamar',
                'id_dinas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Zidang',
                'email' => 'zi@gmail.com',
                'password' => Hash::make('abc'),
                'role' => 'pelamar',
                'id_dinas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // --- 4. MEMBUAT DATA DIVISI (DENGAN KUOTA) ---
        // Kuota dari array $dinasData (indeks 4) didistribusikan di sini
        DB::table('divisi')->insert([
            // Diskominfotik (Total 10)
            ['id_dinas' => $kominfotikId, 'nama_divisi' => 'Pengembangan Aplikasi', 'total_kuota' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => $kominfotikId, 'nama_divisi' => 'Infrastruktur Jaringan', 'total_kuota' => 5, 'created_at' => now(), 'updated_at' => now()],
            
            // Dinas Pendidikan (Total 10)
            ['id_dinas' => $pendidikanId, 'nama_divisi' => 'Kurikulum', 'total_kuota' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => $pendidikanId, 'nama_divisi' => 'Sarana dan Prasarana', 'total_kuota' => 5, 'created_at' => now(), 'updated_at' => now()],

            // PUPR (Total 10)
            ['id_dinas' => $puprId, 'nama_divisi' => 'Bina Marga', 'total_kuota' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}