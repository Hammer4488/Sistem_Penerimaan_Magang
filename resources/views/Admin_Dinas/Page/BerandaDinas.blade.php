@extends('layouts.app')

@section('title', 'Dashboard Admin Dinas')

@push('styles')
    <style>
        .main-content-wrapper {
            margin-left: 300px;
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            .main-content-wrapper {
                margin-left: 0;
            }
        }

        .stat-card {
            background-color: #ffffff;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1.75rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 170px;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .stat-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #5e6e82;
            /* Abu-abu seperti di foto */
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 0.5rem;
            /* Sudut ikon melengkung */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-bg-primary {
            background-color: #e9e7fd;
            color: #4339F2;
        }

        .icon-bg-success {
            background-color: #e0f8f0;
            color: #00bfa5;
        }

        .icon-bg-warning {
            background-color: #fff4e5;
            color: #ff9f43;
        }

        .stat-card-body {
            /* Kosongkan, bisa diisi nanti */
        }

        .stat-card-number {
            font-size: 2.75rem;
            font-weight: 700;
            color: #111;
            margin-top: 0.25rem;
        }

        .stat-card-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endpush
@section('content')

    <x-sidebar active="berandadinas" />

    <div class="main-content-wrapper">

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Pendaftar</span>
                        <div class="stat-card-icon icon-bg-primary">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <h2 class="stat-card-number">{{ $jumlahDiproses }}</h2>
                        <div class="stat-card-subtitle">Menunggu peninjauan Anda</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Anak Magang Aktif</span>
                        <div class="stat-card-icon icon-bg-success">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <h2 class="stat-card-number">{{ $jumlahDiterima }}</h2>
                        <div class="stat-card-subtitle">Sedang magang di dinas Anda</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Total Divisi</span>
                        {{-- Saya ganti icon-bg-warning jadi icon-bg-primary (biru) atau info agar beda --}}
                        <div class="stat-card-icon icon-bg-primary">
                            {{-- Icon diganti jadi sitemap (struktur) --}}
                            <i class="fas fa-sitemap"></i>
                        </div>
                    </div>

                    <div class="stat-card-body">
                        {{-- Panggil variabel $totalDivisi dari controller --}}
                        <h2 class="stat-card-number">{{ $totalDivisi }}</h2>
                        <div class="stat-card-subtitle">Divisi aktif saat ini</div>
                    </div>
                </div>
            </div>

        </div> {{-- Penutup untuk .row --}}

    </div> {{-- <-- INI DIA! Penutup .main-content-wrapper yang dipindah ke SINI --}}

@endsection
