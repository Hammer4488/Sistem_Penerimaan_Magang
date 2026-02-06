@extends('layouts.app') 

@section('title', 'Dashboard Super Admin')

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
    }

    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* Warna Icon Custom */
    .icon-bg-primary {
        background-color: #e9e7fd; 
        color: #4339F2;           
    }

    .icon-bg-info { /* Warna Biru Muda untuk Dinas */
        background-color: #e0f2f1; 
        color: #00acc1;           
    }

    .icon-bg-success {
        background-color: #e0f8f0; 
        color: #00bfa5;           
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

{{-- Pastikan parameter active sesuai dengan controller --}}
<x-sidebar active="dashboard_super" /> 

<div class="main-content-wrapper">
    
    <div class="row g-4">

        {{-- CARD 1: JUMLAH USER --}}
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-title">Total Pengguna</span>
                    <div class="stat-card-icon icon-bg-primary">
                        <i class="fas fa-users"></i> {{-- Ikon Users --}}
                    </div>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-card-number">{{ $jumlahUser }}</h2>
                    <div class="stat-card-subtitle">Akun terdaftar dalam sistem</div>
                </div>
            </div>
        </div>

        {{-- CARD 2: JUMLAH DINAS --}}
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-title">Total Dinas</span>
                    <div class="stat-card-icon icon-bg-info">
                        <i class="fas fa-building"></i> {{-- Ikon Building --}}
                    </div>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-card-number">{{ $jumlahDinas }}</h2>
                    <div class="stat-card-subtitle">Dinas yang tersedia</div>
                </div>
            </div>
        </div>

        {{-- CARD 3: MAGANG AKTIF --}}
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-title">Magang Aktif</span>
                    <div class="stat-card-icon icon-bg-success">
                        <i class="fas fa-user-check"></i> {{-- Ikon User Check --}}
                    </div>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-card-number">{{ $jumlahMagangAktif }}</h2>
                    <div class="stat-card-subtitle">Peserta diterima di seluruh dinas</div>
                </div>
            </div>
        </div>

    </div> {{-- End Row --}}

</div> {{-- End Main Content Wrapper --}}

@endsection