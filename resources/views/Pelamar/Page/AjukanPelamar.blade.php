@extends('layouts.app')

@section('title', 'Ajukan Magang')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }

        .main-content {
            margin-left: 300px;
            padding: 0;
        }

        .content-body {
            padding: 30px;
        }

        /* == STYLE UNTUK KOTAK SELAMAT DATANG == */
        /* == STYLE UNTUK KOTAK SELAMAT DATANG == */
        .welcome-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #dee2e6;
            /* Menambahkan garis batas tipis */
            box-shadow: none;
            /* Menghapus efek bayangan */
        }

        /* == AKHIR STYLE KOTAK SELAMAT DATANG == */

        /* == STYLE UNTUK INFORMASI PENDAFTARAN MAGANG (ALERT) == */
        /* == STYLE UNTUK INFORMASI PENDAFTARAN MAGANG (ALERT) == */
        .info-magang-alert {
            background-color: #ffffff;
            /* <-- DIUBAH dari biru muda ke putih */
            border: 1px solid #e0e0e0;
            /* <-- DITAMBAHKAN border abu-abu standar */
            color: #2c3e50;
            /* <-- DIUBAH dari biru tua ke warna teks standar */
            padding: 25px;
            /* <-- DIUBAH agar padding konsisten */
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .info-magang-alert h5 {
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            /* <-- DITAMBAHKAN untuk alignment icon dan teks */
            align-items: center;
            /* <-- DITAMBAHKAN untuk alignment icon dan teks */
        }

        /* V DITAMBAHKAN BLOK BARU V */
        .info-magang-alert h5 i {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-right: 12px;
        }

        .info-magang-alert ul {
            list-style: none;
            padding-left: 1;
            margin-bottom: 0;
        }

        .info-magang-alert ul li {
            position: relative;
            padding-left: 20px;
            /* <-- DIUBAH untuk menyesuaikan bullet point baru */
            margin-bottom: 10px;
            /* <-- DIUBAH untuk memberi jarak lebih */
            color: #555;
            /* <-- DITAMBAHKAN warna teks lebih terang */
            font-size: 0.95rem;
            /* <-- DITAMBAHKAN agar tulisan sedikit lebih kecil */
        }

        .info-magang-alert ul li:last-child {
            margin-bottom: 0;
        }

        .info-magang-alert ul li::before {
            content: '';
            /* <-- DIUBAH dari kode Font Awesome */
            position: absolute;
            left: 0;
            top: 7px;
            /* <-- DIUBAH untuk posisi vertikal */

            /* V DITAMBAHKAN BLOK BARU UNTUK MENGGAMBAR LINGKARAN V */
            width: 8px;
            height: 8px;
            background-color: #2c3e50;
            border-radius: 50%;

            /* V DIHAPUS properti Font Awesome V */
            /* font-family: "Font Awesome 5 Free"; */
            /* font-weight: 900; */
            /* color: #3498db; */
        }

        /* == AKHIR STYLE INFORMASI PENDAFTARAN MAGANG == */


        /* == STYLE KARTU DINAS == */
        /* V TAMBAHKAN SEMUA BLOK DI BAWAH INI V */

        /* V TAMBAHKAN KELAS UTAMA INI V */
        .custom-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        /* Perbarui kelas yang sudah ada */
        .quota-card {
            border-radius: 0.75rem;
            transition: all 0.3s ease-in-out;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .quota-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        /* V TAMBAHKAN BLOK BARU INI V */
        .quota-card .btn {
            border-radius: 0.5rem;
            /* Menyamakan lengkungan sudut dengan stat-box */
            font-size: 1rem;
            padding: 0.75rem 0;
            /* Membuat tombol sedikit lebih tebal */
            transition: all 0.2s ease-in-out;
        }

        .quota-card .btn:hover {
            transform: scale(1.02);
            /* Sedikit efek membesar saat disentuh */
        }

        .stat-box {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            padding: 0.75rem;
            background-color: #f8f9fa;
        }

        .stat-box .number {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .stat-box .label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* V TAMBAHKAN BLOK BARU INI V */
        .stat-box .text-total {
            color: #0d6efd;
            /* Biru */
        }

        .stat-box .text-terisi {
            color: #dc3545;
            /* Merah */
        }

        .stat-box .text-sisa {
            color: #198754;
            /* Hijau */
        }



        /* == AKHIR STYLE KARTU DINAS == */
    </style>
@endpush

@section('content')
    <x-sidebar active="ajukanpelamar" /> {{-- Menggunakan 'ajukanmagang' sebagai penanda aktif --}}


    <div class="main-content">
        <main class="content-body">
            {{-- 
            <div class="flow-card welcome-card mb-4">
                <h4 class="mb-1">Selamat Datang, {{ $user->name }}!</h4>
                <p class="text-muted mb-0">Kelola pendaftaran magang anda di Pemerintah Kota Banjarmasin</p>
            </div> --}}
            <x-welcome />

            {{-- KOTAK INFORMASI PENDAFTARAN MAGANG --}}
            <div class="info-magang-alert mb-5">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Pendaftaran Magang</h5>
                <ul>
                    <li>Pilih dinas yang sesuai dengan minat dan jurusan anda</li>
                    <li>Pastikan kuota pada dinas yang anda pilih masih tersedia</li>
                    <li>Siapkan berkas pendaftaran seperti surat pengantar dan CV</li>
                </ul>
            </div>

            {{-- DINAS CARD CONTOH (Sama seperti di screenshot) --}}
            <div class="row">

                <div class="row">

                    @foreach ($dinasList as $dinas)
                        <div class="col-lg-6 mb-4">
                            <div class="card quota-card h-100">
                                <div class="card-body p-4 position-relative">

                                    {{-- Badge dinamis --}}
                                    @if ($dinas->total_kuota - $dinas->pendaftaran_count > 0)
                                        <span
                                            class="badge bg-success position-absolute top-0 end-0 mt-3 me-3">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger position-absolute top-0 end-0 mt-3 me-3">Kuota
                                            Terpenuhi</span>
                                    @endif

                                    <h5 class="fw-bold">{{ $dinas->nama_dinas }}</h5>
                                    <p class="text-muted small mb-1">{{ $dinas->nama_lengkap_dinas }}</p>
                                    <p class="card-text small">{{ $dinas->deskripsi }}</p>
                                </div>

                                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                    <div class="row text-center g-2 mb-3">
                                        {{-- Statistik Kuota --}}
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <div class="number text-primary">{{ $dinas->total_kuota }}</div>
                                                <div class="label">Total Kuota</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <div class="number text-danger">{{ $dinas->pendaftaran_count }}</div>
                                                <div class="label">Kuota Terisi</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <div class="number text-success">
                                                    {{ $dinas->total_kuota - $dinas->pendaftaran_count }}</div>
                                                <div class="label">Sisa Kuota</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Blok kode BARU dengan 3 kondisi --}}
                                    <div class="mt-4">
                                        @if (in_array($dinas->id_dinas, $pendaftaranPengguna))
                                            {{-- Kondisi 1: Jika ID dinas ada di dalam riwayat pendaftaran pengguna --}}
                                            <a href="#" class="btn btn-success w-100 fw-bold disabled"
                                                style="opacity: 0.8;">
                                                <i class="fas fa-check-circle me-2"></i> Sudah Diajukan
                                            </a>
                                        @elseif ($dinas->total_kuota - $dinas->pendaftaran_count <= 0)
                                            {{-- Kondisi 2: Jika kuota habis (dan belum pernah diajukan) --}}
                                            <a href="#" class="btn btn-secondary w-100 fw-bold disabled">
                                                Kuota Penuh
                                            </a>
                                        @else
                                            {{-- Kondisi 3: Jika kuota tersedia dan belum pernah diajukan --}}
                                            <a href="{{ route('pendaftaran.create', $dinas) }}"
                                                class="btn btn-primary w-100 fw-bold">
                                                Pilih Dinas Ini
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

        </main>
    </div>
@endsection
