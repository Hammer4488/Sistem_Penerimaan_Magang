@extends('layouts.app')

@section('title', 'Status Pendaftaran')

@push('styles')
    <style>
        /* V TAMBAHKAN BLOK BARU INI V */
        .welcome-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #dee2e6;
            box-shadow: none;
            margin-bottom: 25px;
            /* <-- BARIS INI DITAMBAHKAN */
        }

        .main-content {
            margin-left: 300px;
            /* <-- BARIS INI DITAMBAHKAN */
            padding: 30px;
        }

        /* Gaya umum sudah ada di layout utama, kita hanya tambahkan yang spesifik */
        .status-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .table thead th {
            font-weight: 600;
            color: #2c3e50;
            border-bottom-width: 2px;
            border-color: #e0e0e0;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .status-ditolak {
            background-color: #fce8e6;
            color: #c5221f;
        }

        .status-diterima {
            background-color: #e6f4ea;
            color: #137333;
        }

        .status-diproses {
            background-color: #e8f0fe;
            color: #1967d2;
        }
    </style>
@endpush

@section('content')
    {{-- Memanggil komponen sidebar dan menandai 'statuspendaftaran' sebagai link aktif --}}
    <x-sidebar active="statuspendaftaran" />

    <div class="main-content">
        <main class="content-body">

            {{-- <div class="welcome-card mb-4">
                <h4 class="mb-1">Selamat Datang, {{ $user->name ?? 'Pelamar' }}!</h4>
                <p class="text-muted mb-0">Berikut adalah riwayat dan status pendaftaran magang Anda.</p>
            </div> --}}
              <x-welcome />


            <div class="status-card">
                <h5 class="fw-bold mb-4">Riwayat Pendaftaran</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">Dinas Yang Dipilih</th>
                                <th scope="col">Detail Formulir</th>
                                <th scope="col">Status</th>
                                <th scope="col">Surat Balasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- CONTOH DATA: DITOLAK --}}
                            <tr>
                                <th scope="row">1</th>
                                <td>Diskominfotik</td>
                                <td><a href="#" class="btn btn-dark btn-sm">Click disini</a></td>
                                <td><span class="status-badge status-ditolak">Ditolak</span></td>
                                <td>-</td>
                            </tr>

                            {{-- CONTOH DATA: DITERIMA --}}
                            <tr>
                                <th scope="row">2</th>
                                <td>Dinas Pendidikan</td>
                                <td><a href="#" class="btn btn-dark btn-sm">Click disini</a></td>
                                <td><span class="status-badge status-diterima">Diterima</span></td>
                                <td><a href="#" class="btn btn-primary btn-sm">Download</a></td>
                            </tr>

                            {{-- CONTOH DATA: DIPROSES --}}
                            <tr>
                                <th scope="row">3</th>
                                <td>Dinas Lingkungan Hidup</td>
                                <td><a href="#" class="btn btn-dark btn-sm">Click disini</a></td>
                                <td><span class="status-badge status-diproses">Diproses</span></td>
                                <td>-</td>
                            </tr>

                            {{-- Baris ini bisa Anda hapus/ganti dengan data dinamis dari database menggunakan @foreach --}}
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
@endsection
