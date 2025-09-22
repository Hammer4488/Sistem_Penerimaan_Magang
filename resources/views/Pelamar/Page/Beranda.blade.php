<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Penerimaan Magang Pemkot Banjarmasin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(26, 41, 86, 0.85) 0%, rgba(34, 51, 102, 0.85) 100%),
            url('{{ asset("image/background.jpg") }}') center right / cover no-repeat;
            color: white;
            padding: 100px 0;
            min-height: 500px;
        }
        .logo-img {
            height: 120px;
            width: 120px;
            object-fit: contain;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}" style="margin-left:-35px;">
                <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo-img" style="margin-right:-8px;">
                <div style="line-height:1.1;">
                    <div class="fw-bold text-dark" style="font-size:1.5rem; font-family:'Segoe UI',sans-serif;">Pemerintah Kota</div>
                    <div class="fw-bold text-dark" style="font-size:2rem; margin-top:-4px; font-family:'Segoe UI',sans-serif;">Banjarmasin</div>
                </div>
            </a>

            <div class="navbar-nav me-auto ms-4">
                <a href="{{ route('beranda') }}" class="nav-link text-dark fw-semibold me-4" style="font-size: 1.2rem;">beranda</a>
                <a href="{{ route('kuotamagang') }}" class="nav-link text-dark fw-semibold" style="font-size: 1.2rem;">Lihat kuota magang</a>
            </div>

            <div class="navbar-nav ms-auto">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2"><i class="fas fa-right-to-bracket me-1"></i>Login</a>
                <a href="{{ route('daftar') }}" class="btn btn-primary btn-lg"><i class="fas fa-user-plus me-1"></i>Daftar</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Selamat Datang di Sistem Penerimaan Magang Pemkot Banjarmasin</h1>
                    <p class="lead mb-4">Bergabunglah dengan kami dalam program magang yang akan memberikan pengalaman berharga di lingkungan Pemerintah Kota Banjarmasin.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('daftar') }}" class="btn btn-light btn-lg"><i class="fas fa-user-plus me-2"></i>Buat Akun Sekarang</a>
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg"><i class="fas fa-right-to-bracket me-2"></i>Login</a>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kuotamagang') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-chart-bar me-2"></i>Ayo Lihat Kuota Divisi Sebelum Mendaftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Prosedur Pengajuan Magang</h2>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="row g-4">
                        <div class="col-md-4 col-12 text-center">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="mb-3"><i class="fas fa-user-plus fa-2x text-primary"></i></div>
                                    <h6 class="fw-bold">1. Daftar Akun</h6>
                                    <p class="text-muted small">Buat akun untuk bisa login ke dalam sistem.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 text-center">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="mb-3"><i class="fas fa-sign-in-alt fa-2x text-primary"></i></div>
                                    <h6 class="fw-bold">2. Login</h6>
                                    <p class="text-muted small">Masuk ke sistem menggunakan akun yang sudah didaftarkan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 text-center">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="mb-3"><i class="fas fa-hourglass-half fa-2x text-primary"></i></div>
                                    <h6 class="fw-bold">3. Pendafataran</h6>
                                    <p class="text-muted small">Pilih dinas yang di inginkan, lalu jika kuota tersedia bisa mengajukan pendaftaran dan menunggu proses hasil akhirnya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Pemerintah Kota Banjarmasin</h5>
                    <p>Layanan untuk masyarakat</p>
                    <p><i class="fas fa-phone me-2"></i>0812-3456-7890</p>
                    <p><i class="fas fa-envelope me-2"></i>magang@banjarmasinkota.go.id</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Kontak Kami</h5>
                    <p><i class="fab fa-facebook me-2"></i>Pemerintah Kota Banjarmasin</p>
                    <p><i class="fab fa-youtube me-2"></i>Pemerintah Kota Banjarmasin</p>
                    <p><i class="fab fa-instagram me-2"></i>@banjarmasinkota</p>
                    <p><i class="fab fa-twitter me-2"></i>@PemkotBjm</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Pemerintah Kota Banjarmasin. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>