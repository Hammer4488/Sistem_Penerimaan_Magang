@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        .main-content {
            margin-left: 300px;
            /* Sesuaikan dengan lebar sidebar */
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
    </style>
@endpush
@section('content')

    <x-sidebar active="berandapelamar" />
    <div class="main-content">
        <main class="content-body">

            <div class="flow-card welcome-card mb-4">
                <h4 class="mb-1">Selamat Datang, {{ $user->name }}!</h4>
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
