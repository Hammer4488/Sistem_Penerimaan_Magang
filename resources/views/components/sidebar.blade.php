{{-- SEMUA CSS UNTUK SIDEBAR SEKARANG ADA DI SINI --}}
<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 300px;
        height: 100vh;
        background-color: #2c3e50;
        padding: 20px;
        color: white;
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar .logo {
        display: block;
        margin: 0 auto 20px auto;
        width: 100px;
    }

    .sidebar-title {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.8rem;
        margin-top: 15px;
        margin-bottom: 15px;
        text-align: center;
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
        display: flex;
        align-items: center;
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

    .logout-section {
        margin-top: auto;
    }

    .logout-button {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 12px 15px;
        font-size: 1rem;
        color: #bdc3c7;
        background-color: transparent;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .logout-button:hover {
        background-color: #34495e;
        color: #ffffff;
    }

    .logout-button i {
        margin-right: 15px;
        width: 20px;
        text-align: center;
    }

    .main-content {
        margin-left: 300px;
        /* Sesuaikan dengan lebar sidebar */
    }
</style>
<div>
    <div class="sidebar">
        <div>
            <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo">

            @php
                $judul = 'Menu'; // Default

                switch ($active) {
                    // PELAMAR
                    case 'berandapelamar': $judul = 'Beranda'; break;
                    case 'ajukanpelamar': $judul = 'Ajukan Magang'; break;
                    case 'riwayatpendaftaran': $judul = 'Riwayat Pendaftaran'; break;
                    
                    // ADMIN DINAS
                    case 'berandadinas': $judul = 'Beranda'; break;
                    case 'pendaftardinas': $judul = 'Verifikasi Pendaftar'; break;
                    case 'kelolakuota': $judul = 'Kelola Data Divisi'; break;

                    // SUPER ADMIN
                    case 'dashboard_super': $judul = 'Beranda'; break;
                    case 'keloladinas': $judul = 'Kelola Data Dinas'; break;
                    case 'kelolaakun': $judul = 'Kelola Data Akun'; break;
                }
            @endphp

            <h3 class="sidebar-title">{{ $judul }}</h3>
            <hr class="sidebar-divider">

            @if (Auth::user()->role === 'pelamar')
                {{-- ### MENU UNTUK PELAMAR (KODE ASLI ANDA) ### --}}

                <ul class="nav flex-column">
                    <li class="nav-item">
                        {{-- Gunakan $active untuk menentukan kelas 'active' --}}
                        <a class="nav-link {{ $active === 'berandapelamar' ? 'active' : '' }}"
                            href="{{ route('berandapelamar') }}">
                            <i class="fas fa-home"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item has-submenu">
                        <a class="nav-link {{ $active === 'ajukanpelamar' ? 'active' : '' }}"
                            href="{{ route('ajukanpelamar') }}">
                            {{-- 'ajukanpelamar_parent' adalah penanda untuk induknya --}}
                            <i class="fas fa-file-alt"></i>
                            <span>Ajukan Magang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- V DIUBAH href dan kondisi active V --}}
                        <a class="nav-link {{ $active === 'riwayatpendaftaran' ? 'active' : '' }}"
                            href="{{ route('riwayatpelamar') }}">
                            <i class="fas fa-tasks"></i>
                            <span>Riwayat Pendaftaran</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ $active === 'suratbalasan' ? 'active' : '' }}" href="#">
                            <i class="fas fa-envelope"></i>
                            <span>Logbook</span>
                        </a>
                    </li> --}}
                </ul>
            @elseif (Auth::user()->role === 'admin dinas')
                {{-- ### MENU BARU UNTUK ADMIN DINAS ### --}}

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'berandadinas' ? 'active' : '' }}"
                            href="{{ route('beranda.dinas') }}"> 
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'pendaftardinas' ? 'active' : '' }}"
                            href="{{ route('pendaftar.dinas') }}"> 
                            <i class="fas fa-users"></i>
                            <span>Verifikasi Pendaftar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'kelolakuota' ? 'active' : '' }}" }
                            href="{{ route('Admin_Dinas.page.KuotaDinas') }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Kelola Data Divisi</span>
                        </a>
                    </li>
                </ul>
            @elseif (Auth::user()->role === 'super admin')

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'dashboard_super' ? 'active' : '' }}"
                            href="{{ route('superadmin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Beranda</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'keloladinas' ? 'active' : '' }}"
                            href="{{ route('superadmin.dinas.index') }}">
                            <i class="fas fa-building"></i>
                            <span>Kelola Data Dinas</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'kelolaakun' ? 'active' : '' }}"
                            href="{{ route('superadmin.users.index') }}">
                            <i class="fas fa-user-cog"></i>
                            <span>Kelola Data Akun</span>
                        </a>
                    </li>

                </ul>
            @endif

            {{-- ============================================== --}}
            {{--           AKHIR LOGIKA KONDISI ROLE              --}}
            {{-- ============================================== --}}

        </div>

        {{-- Bagian Logout ini sama untuk semua role --}}
        <div class="logout-section">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="logout-button" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>
</div>
