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
                'total_kuota' => $dinas[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $kominfotikId = DB::table('dinas')->where('nama_dinas', 'Diskominfotik')->value('id_dinas');

        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
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
        ]);

        $pendidikanId = DB::table('dinas')->where('nama_dinas', 'Dinas Pendidikan')->value('id_dinas');
        $puprId = DB::table('dinas')->where('nama_dinas', 'PUPR')->value('id_dinas');

        DB::table('divisi')->insert([
            ['id_dinas' => $kominfotikId, 'nama_divisi' => 'Pengembangan Aplikasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => $kominfotikId, 'nama_divisi' => 'Infrastruktur Jaringan', 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => $pendidikanId, 'nama_divisi' => 'Kurikulum', 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => $pendidikanId, 'nama_divisi' => 'Sarana dan Prasarana', 'created_at' => now(), 'updated_at' => now()],
            ['id_dinas' => $puprId, 'nama_divisi' => 'Bina Marga', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}