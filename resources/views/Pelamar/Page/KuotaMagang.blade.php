<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Kuota Dinas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 0.5rem 0;
        }
        .navbar-custom .logo-img {
            height: 120px;
            width: 120px;
            object-fit: contain;
            margin-right: -8px;
        }
        .quota-card {
            border: 1px solid #e0e0e0;
            border-radius: 0.75rem;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        }
        .quota-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
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
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}" style="margin-left:-35px;">
                <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo-img">
                <div style="line-height:1.1;">
                    <div class="fw-bold text-dark" style="font-size:1.5rem; font-family:'Segoe UI',sans-serif;">Pemerintah Kota</div>
                    <div class="fw-bold text-dark" style="font-size:2rem; margin-top:-4px; font-family:'Segoe UI',sans-serif;">Banjarmasin</div>
                </div>
            </a>
            
            <div class="navbar-nav me-auto ms-4">
                <a href="{{ route('beranda') }}" class="nav-link text-dark fw-semibold me-4" style="font-size: 1.2rem;">Beranda</a>
                <a href="{{ route('kuotamagang') }}" class="nav-link text-dark fw-semibold" style="font-size: 1.2rem;">Lihat kuota magang</a>
            </div>
            
            <div class="navbar-nav ms-auto">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2"><i class="fas fa-right-to-bracket me-1"></i>Login</a>
                <a href="{{ route('daftar') }}" class="btn btn-primary btn-lg"><i class="fas fa-user-plus me-1"></i>Daftar</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Kuota Magang per Dinas</h1>
            <p class="lead text-muted">Lihat keseterdiaan kuota magang di setiap dinas Pemerintah Kota Banjarmasin</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card quota-card h-100">
                    <div class="card-body p-4 position-relative">
                        <span class="badge bg-success position-absolute top-0 end-0 mt-3 me-3">Tersedia</span>
                        <h5 class="fw-bold">Diskominfotik</h5>
                        <p class="text-muted small mb-3">Dinas Komunikasi, Informatika, dan Statistik</p>
                        <p class="card-text">Dinas yang menangani bidang komunikasi, informatika, dan statistik daerah.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                        <div class="row text-center g-2">
                            <div class="col-4"><div class="stat-box"><div class="number text-primary">100</div><div class="label">Total Kuota</div></div></div>
                            <div class="col-4"><div class="stat-box"><div class="number">5</div><div class="label">Kuota Terisi</div></div></div>
                            <div class="col-4"><div class="stat-box"><div class="number text-success">95</div><div class="label">Sisa Kuota</div></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card quota-card h-100">
                    <div class="card-body p-4 position-relative">
                        <span class="badge bg-danger position-absolute top-0 end-0 mt-3 me-3">Kuota Terpenuhi</span>
                        <h5 class="fw-bold">Dinas Pendidikan</h5>
                        <p class="text-muted small mb-3">Dinas Pendidikan Kota Banjarmasin</p>
                        <p class="card-text">Dinas yang menangani bidang pendidikan dasar, menengah, dan nonformal.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                        <div class="row text-center g-2">
                            <div class="col-4"><div class="stat-box"><div class="number text-primary">10</div><div class="label">Total Kuota</div></div></div>
                            <div class="col-4"><div class="stat-box"><div class="number">10</div><div class="label">Kuota Terisi</div></div></div>
                            <div class="col-4"><div class="stat-box"><div class="number text-danger">0</div><div class="label">Sisa Kuota</div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>