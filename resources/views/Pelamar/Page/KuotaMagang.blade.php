@extends('layouts.app')

@section('title', 'Lihat Instansi')

@push('styles')
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
        }

        /* .navbar-custom {
                                    background-color: #ffffff;
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                                    padding: 0.5rem 0;
                                }

                                .navbar-custom .logo-img {
                                    height: 120px;
                                    width: 120px;
                                    object-fit: contain;
                                    margin-right: -8px;
                                } */

        .quota-card {
            border: 1px solid #e0e0e0;
            border-radius: 0.75rem;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
        }

        .quota-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
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
@endpush
@section('content')

    <x-navbar />
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Lihat Instansi Yang Ada</h1>
            <p class="lead text-muted">Lihat keseterdiaan dinas di Pemerintah Kota Banjarmasin</p>
        </div>

        <div class="row g-4">
            @forelse ($dinasList as $dinas)

                <div class="col-lg-6">
                    <div class="card quota-card h-100">
                        <div class="card-body p-4 position-relative">

                            {{-- Badge dinamis berdasarkan Sisa Kuota --}}

                            {{-- Tampilkan data dinamis dari database --}}
                            <h5 class="fw-bold">{{ $dinas->nama_dinas }}</h5>
                            <p class="text-muted small mb-3">{{ $dinas->nama_lengkap_dinas }}</p>
                            <p class="card-text">{{ $dinas->deskripsi }}</p>
                        </div>

                    </div>
                </div>
            @empty
                {{-- Ini akan tampil jika tidak ada data dinas di database --}}
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada data dinas yang tersedia saat ini.
                    </div>
                </div>
            @endforelse
            {{-- [AKHIR PENGGANTIAN] --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
