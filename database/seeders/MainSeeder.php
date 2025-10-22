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
        // --- MEMBUAT DATA PENGGUNA (USERS) ---
        DB::table('users')->insert([
            // Super Admin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'super admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Admin Dinas
            [
                'name' => 'Admin Diskominfotik',
                'email' => 'admindiskominfo@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin dinas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pelamar
            [
                'name' => 'AzkaGG',
                'email' => 'az@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'pelamar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // --- MEMBUAT DATA DINAS ---
        $dinasData = [
            ['Diskominfotik', 'Dinas Komunikasi, Informatika, dan Statistik', 'Dinas yang menangani bidang komunikasi, informatika, dan statistik daerah.', 5, 10],
            ['Dinas Pendidikan', 'Dinas Pendidikan Kota Banjarmasin', 'Dinas yang menangani bidang pendidikan dasar, menengah, dan nonformal.', 0, 10],
            ['PUPR', 'Dinas Pekerjaan Umum dan Penataan Ruang', 'Dinas yang menangani pembangunan infrastruktur dan tata ruang kota.', 5, 10],
            ['Lingkungan Hidup', 'Dinas Lingkungan Hidup Kota Banjarmasin', 'Dinas yang menangani pengelolaan lingkungan, sampah, dan pengendalian pencemaran.', 5, 10],
            ['Diskop UMKM', 'Dinas Koperasi dan UMKM', 'Dinas yang menangani pengembangan koperasi dan usaha mikro.', 5, 10],
            ['DP3A', 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak', 'Dinas yang menangani pemberdayaan perempuan, perlindungan anak, dan kesetaraan gender.', 5, 10],
            ['BPKD', 'Badan Pengelola Keuangan Daerah', 'Badan yang menangani pengelolaan anggaran, aset, dan keuangan daerah.', 5, 10],
            ['BKPSDM', 'Badan Kepegawaian dan Pengembangan SDM', 'Badan yang menangani kepegawaian dan pengembangan sumber daya aparatur.', 5, 10],
            ['Inspektorat', 'Inspektorat Kota Banjarmasin', 'Badan yang menangani pengawasan, audit, dan evaluasi penyelenggaraan pemerintah.', 5, 10],
            ['Sekretariat Daerah (Setda)', 'Sekretariat Daerah Kota Banjarmasin', 'Sekretariat yang membantu wali kota dalam penyusunan kebijakan.', 5, 10],
        ];

        foreach ($dinasData as $dinas) {
            DB::table('dinas')->insert([
                'nama_dinas' => $dinas[0],
                'nama_lengkap_dinas' => $dinas[1],
                'deskripsi' => $dinas[2],
                'sisa_kuota' => $dinas[3],
                'total_kuota' => $dinas[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --- MEMBUAT DATA DIVISI ---
        DB::table('divisi')->insert([
            // Divisi untuk Diskominfotik (id_dinas = 1)
            ['id_dinas' => 1, 'nama_divisi' => 'Pengembangan Aplikasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => 1, 'nama_divisi' => 'Infrastruktur Jaringan', 'created_at' => now(), 'updated_at' => now()],
            
            // Divisi untuk Dinas Pendidikan (id_dinas = 2)
            ['id_dinas' => 2, 'nama_divisi' => 'Kurikulum', 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => 2, 'nama_divisi' => 'Sarana dan Prasarana', 'created_at' => now(), 'updated_at' => now()],

            // Divisi untuk PUPR (id_dinas = 3)
            ['id_dinas' => 3, 'nama_divisi' => 'Bina Marga', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}