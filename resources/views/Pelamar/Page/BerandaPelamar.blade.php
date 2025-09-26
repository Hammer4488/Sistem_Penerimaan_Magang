@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100vh; /* Pastikan ini 100vh agar flexbox bekerja penuh */
            background-color: #2c3e50;
            padding: 20px;
            color: white;
            display: flex; /* Aktifkan Flexbox */
            flex-direction: column; /* Susun item secara vertikal */
            /* justify-content: space-between; -- Ini akan menempatkan item pertama di atas, item terakhir di bawah */
        }

        .sidebar .logo {
            display: block;
            margin: 0 auto;
            width: 100px;
            height: auto;
        }

        .sidebar-title {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.8rem;
            margin-top: 15px;
            margin-bottom: 15px;
            text-align: center; /* Tambahkan ini agar teks Beranda juga di tengah */
        }

        .sidebar-divider {
            border-top: 1px solid #4a627a;
            opacity: 1;
            margin-bottom: 20px;
        }

        .sidebar .nav-link {
            font-size: 1rem;
            color: #bdc3c7;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background-color: #34495e;
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: #3498db;
            color: #ffffff;
            font-weight: 600;
        }

        .main-content {
            margin-left: 300px; /* Sesuaikan dengan lebar sidebar */
            padding: 0;
        }

        .content-body {
            padding: 30px;
        }

        .welcome-card {
            border-top: 4px solid #3498db;
            padding: 25px;
        }

        .flow-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
        }

        .flow-card-header {
            padding: 15px 25px;
            border-bottom: 1px solid #e0e0e0;
        }

        .flow-item {
            display: flex;
            align-items: center;
            padding: 25px;
            border-bottom: 1px solid #e9ecef;
        }

        .flow-item:last-child {
            border-bottom: none;
        }

        .flow-number {
            width: 40px;
            height: 40px;
            background-color: #2c3e50;
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            margin-right: 20px;
            flex-shrink: 0;
        }

        /* Style untuk tombol logout */
        .sidebar .logout-section {
            margin-top: auto; /* Ini akan mendorongnya ke paling bawah */
            padding-top: 20px; /* Sedikit padding di atasnya */
        }

        .sidebar .logout-button {
            display: flex; /* Gunakan flex untuk icon dan teks */
            align-items: center; /* Pusatkan secara vertikal */
            justify-content: flex-start; /* Mulai dari kiri */
            width: 100%; /* Lebar penuh */
            padding: 15px 20px; /* Padding lebih besar */
            font-size: 1.2rem; /* Ukuran font lebih besar */
            color: #ffffff; /* Warna teks putih */
            background-color: #e74c3c; /* Warna latar belakang merah gelap */
            border-radius: 8px; /* Sudut membulat */
            text-decoration: none; /* Hapus underline */
            transition: background-color 0.3s ease;
        }

        .sidebar .logout-button:hover {
            background-color: #c0392b; /* Warna hover yang sedikit lebih gelap */
            color: #ffffff;
        }

        .sidebar .logout-button i {
            margin-right: 15px;
            width: 20px; /* Pastikan icon punya lebar tetap */
            text-align: center;
        }
    </style>
@endpush
@section('content')

    <div class="sidebar">
        <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo">

        <h3 class="sidebar-title text-center">Beranda</h3>
        <hr class="sidebar-divider">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-file-alt"></i>
                    <span>Ajukan Magang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-tasks"></i>
                    <span>Status Pendaftaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-envelope"></i>
                    <span>Surat Balasan</span>
                </a>
            </li>
        </ul>
        <div class="mt-auto"> {{-- mt-auto akan mendorongnya ke bawah --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="nav-link" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <main class="content-body">

            <div class="flow-card welcome-card mb-4">
                <h4 class="mb-1">Selamat Datang, {{ $nama }}!</h4>
                <p class="text-muted mb-0">Kelola pendaftaran magang anda di Pemerintah Kota Banjarmasin</p>
            </div>

            <div class="flow-card">
                <div class="flow-card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Alur Pendaftaran Magang</h5>
                </div>

                <div class="flow-item">
                    <div class="flow-number">1</div>
                    <div class="me-auto">
                        <h6 class="fw-bold mb-1">Ajukan Magang</h6>
                        <p class="text-muted mb-0 small">Pilih dinas yang sesuai dengan minat, lengkapi data diri, upload
                            berkas dan cv serta dokumen pendukung.</p>
                    </div>
                    <a href="#" class="btn btn-outline-primary ms-4"><i class="fas fa-paper-plane me-2"></i>Ajukan</a>
                </div>

                <div class="flow-item">
                    <div class="flow-number">2</div>
                    <div class="me-auto">
                        <h6 class="fw-bold mb-1">Status Pendaftaran</h6>
                        <p class="text-muted mb-0 small">Lihat status pendaftaran setelah keputusan admin dinas.</p>
                    </div>
                    <a href="#" class="btn btn-outline-info ms-4"><i class="fas fa-search me-2"></i>Lihat Status</a>
                </div>

                <div class="flow-item">
                    <div class="flow-number">3</div>
                    <div class="me-auto">
                        <h6 class="fw-bold mb-1">Surat Balasan</h6>
                        <p class="text-muted mb-0 small">Cetak surat balasan dari dinas setelah di nyatakan diterima.</p>
                    </div>
                    <a href="#" class="btn btn-outline-success ms-4"><i class="fas fa-print me-2"></i>Cetak Surat</a>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
