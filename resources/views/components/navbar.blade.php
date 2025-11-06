<style>
    .navbar-custom {
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        /* Kita pakai versi ini */
        padding: 0.5rem 0;
    }

    .navbar-custom .logo-img {
        height: 120px;
        width: 120px;
        object-fit: contain;
        margin-right: -8px;
        /* Ini penting */
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}" style="margin-left:-35px;">
            <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo-img">
            <div style="line-height:1.1;">
                <div class="fw-bold text-dark" style="font-size:1.5rem; font-family:'Segoe UI',sans-serif;">Pemerintah
                    Kota</div>
                <div class="fw-bold text-dark"
                    style="font-size:2rem; margin-top:-4px; font-family:'Segoe UI',sans-serif;">Banjarmasin</div>
            </div>
        </a>

        <div class="navbar-nav me-auto ms-4">
            {{-- [PERBAIKAN DI SINI] --}}
            {{-- 
              Kita gunakan helper request()->routeIs() untuk mengecek rute mana yang sedang aktif.
              Jika rute aktif, kita beri kelas 'fw-bold' (bold).
              Jika tidak aktif, kita beri kelas 'fw-normal' (standar).
            --}}
            
            <a href="{{ route('beranda') }}" 
               class="nav-link text-dark me-4 {{ request()->routeIs('beranda') ? 'fw-bold' : 'fw-normal' }}"
               style="font-size: 1.2rem;">Beranda</a>
               
            <a href="{{ route('kuotamagang') }}" 
               class="nav-link text-dark {{ request()->routeIs('kuotamagang') ? 'fw-bold' : 'fw-normal' }}" 
               style="font-size: 1.2rem;">Lihat kuota magang</a>
            {{-- [AKHIR PERBAIKAN] --}}
        </div>

        <div class="navbar-nav ms-auto">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2"><i
                    class="fas fa-right-to-bracket me-1"></i>Login</a>
            <a href="{{ route('daftar') }}" class="btn btn-primary btn-lg"><i
                    class="fas fa-user-plus me-1"></i>Daftar</a>
        </div>
    </div>
</nav>
