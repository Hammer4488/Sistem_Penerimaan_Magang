@extends('layouts.app')
@section('title', 'Kelola Data Divisi')

@push('styles')
    <style>
        .main-content {
            margin-left: 300px;
            padding: 0;
            transition: margin-left 0.3s ease;
        }

        .content-body {
            padding: 30px;
            background-color: #f4f7f6;
            min-height: 100vh;
        }

        .custom-card {
            background-color: #ffffff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .custom-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 25px;
            font-weight: 600;
        }

        .custom-card .card-body {
            padding: 25px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            color: #555;
            text-transform: uppercase;
        }

        .table td {
            vertical-align: middle;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }

            .content-body {
                padding: 20px 15px;
            }
        }
    </style>
@endpush

@section('content')

    <x-sidebar active="kelolakuota" />

    <div class="main-content">
        <main class="content-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- @if (session('deleted'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('deleted') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Input tidak valid:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Manajemen Divisi</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDivisi">
                        <i class="fas fa-plus me-1"></i> Tambah Divisi
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Divisi</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($divisis as $divisi)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $divisi->nama_divisi ?? 'N/A' }}</td>
                                        <td class="text-nowrap">

                                            <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal"
                                                data-bs-target="#modalEditDivisi" data-id="{{ $divisi->id_divisi ?? '' }}"
                                                data-nama="{{ $divisi->nama_divisi ?? '' }}"
                                                data-kuota="{{ $divisi->total_kuota ?? 0 }}">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>

                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusDivisi" data-id="{{ $divisi->id_divisi ?? '' }}"
                                                data-nama="{{ $divisi->nama_divisi ?? '' }}">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    ...
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="modalTambahDivisi" tabindex="-1" aria-labelledby="modalTambahDivisiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDivisiLabel">Tambah Divisi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.divisi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_divisi" class="form-label">Nama Divisi</label>
                            <input type="text" class="form-control" name="nama_divisi" id="nama_divisi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditDivisi" tabindex="-1" aria-labelledby="modalEditDivisiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDivisiLabel">Edit Divisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNamaDivisi" class="form-label">Nama Divisi</label>
                            <input type="text" class="form-control" name="nama_divisi" id="editNamaDivisi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusDivisi" tabindex="-1" aria-labelledby="modalHapusDivisiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusDivisiLabel">Konfirmasi Hapus Divisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus divisi <strong id="hapusNamaDivisi">...</strong>?</p>
                        <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var modalEdit = document.getElementById('modalEditDivisi');
            if (modalEdit) {
                modalEdit.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var nama = button.getAttribute('data-nama');
                    var kuota = button.getAttribute('data-kuota');

                    var form = modalEdit.querySelector('form');
                    form.action = '/kelola-kuota/' + id;
                    modalEdit.querySelector('#editNamaDivisi').value = nama;
                    modalEdit.querySelector('#editKuota').value = kuota;
                });
            }

            var modalHapus = document.getElementById('modalHapusDivisi');
            if (modalHapus) {
                modalHapus.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var nama = button.getAttribute('data-nama');

                    var form = modalHapus.querySelector('form');
                    form.action = '/kelola-kuota/' + id;
                    modalHapus.querySelector('#hapusNamaDivisi').textContent = nama;
                });
            }

        });
    </script>
@endpush
