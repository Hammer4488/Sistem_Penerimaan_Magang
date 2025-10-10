    @push('styles')
        <div>
            <div class="sidebar">
                <div>
                    <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo">

                    <h3 class="sidebar-title">Beranda</h3>
                    <hr class="sidebar-divider">

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
                            <a class="nav-link {{ $active === 'statuspendaftaran' ? 'active' : '' }}" href="#">
                                <i class="fas fa-tasks"></i>
                                <span>Status Pendaftaran</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $active === 'suratbalasan' ? 'active' : '' }}" href="#">
                                <i class="fas fa-envelope"></i>
                                <span>Surat Balasan</span>
                            </a>
                        </li>
                    </ul>
                </div>

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
                /* <-- DIUBAH, disamakan dengan .nav-link */
                font-size: 1rem;
                /* <-- DIUBAH, disamakan dengan .nav-link */
                color: #bdc3c7;
                /* <-- DIUBAH, dari putih menjadi abu-abu seperti .nav-link */
                background-color: transparent;
                /* <-- DIUBAH, dari merah menjadi transparan */
                border-radius: 8px;
                text-decoration: none;
                transition: all 0.3s ease;
                /* <-- DIUBAH, disamakan dengan .nav-link */
            }

            .logout-button:hover {
                background-color: #34495e;
                /* <-- DIUBAH, hover menjadi abu-abu gelap */
                color: #ffffff;
                /* <-- DITAMBAHKAN, teks menjadi putih saat hover */
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
