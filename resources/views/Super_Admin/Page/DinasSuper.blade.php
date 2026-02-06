@extends('layouts.app')
@section('title', 'Kelola Dinas')

@push('styles')
    <style>
        /* Menggunakan style yang sama persis agar konsisten */
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

    <x-sidebar active="keloladinas" />

    <div class="main-content">
        <main class="content-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                    <h5 class="mb-0 fw-bold">Manajemen Dinas</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDinas">
                        <i class="fas fa-plus me-1"></i> Tambah Dinas
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Dinas</th>
                                    <th>Nama Lengkap Dinas</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semua_dinas as $dinas)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $dinas->nama_dinas ?? 'N/A' }}</td>
                                        <td>{{ $dinas->nama_lengkap_dinas ?? '-' }}</td>
                                        <td>{{ Str::limit($dinas->deskripsi, 50) }}</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal"
                                                data-bs-target="#modalEditDinas" data-id="{{ $dinas->id_dinas }}"
                                                data-nama="{{ $dinas->nama_dinas }}"
                                                data-namalengkap="{{ $dinas->nama_lengkap_dinas }}"
                                                data-deskripsi="{{ $dinas->deskripsi }}">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>

                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusDinas" data-id="{{ $dinas->id_dinas }}"
                                                data-nama="{{ $dinas->nama_dinas }}">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Belum ada data dinas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="modalTambahDinas" tabindex="-1" aria-labelledby="modalTambahDinasLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahDinasLabel">Tambah Dinas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.dinas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_dinas" class="form-label">Nama Dinas</label>
                            <input type="text" class="form-control" name="nama_dinas" id="nama_dinas" required
                                placeholder="Contoh: Diskominfotik">
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_lengkap_dinas" class="form-label">Nama Lengkap Dinas</label>
                            <input type="text" class="form-control" name="nama_lengkap_dinas" id="nama_lengkap_dinas"
                                required>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required></textarea>
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

    <div class="modal fade" id="modalEditDinas" tabindex="-1" aria-labelledby="modalEditDinasLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDinasLabel">Edit Dinas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditDinas" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNamaDinas" class="form-label">Nama Dinas</label>
                            <input type="text" class="form-control" name="nama_dinas" id="editNamaDinas" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNamaLengkap" class="form-label">Nama Lengkap Dinas</label>
                            <input type="text" class="form-control" name="nama_lengkap_dinas" id="editNamaLengkap"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="editDeskripsi" rows="3" required></textarea>
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

    <div class="modal fade" id="modalHapusDinas" tabindex="-1" aria-labelledby="modalHapusDinasLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusDinasLabel">Konfirmasi Hapus Dinas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus dinas <strong id="hapusNamaDinas">...</strong>?</p>
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

            // --- HANDLING MODAL EDIT ---
            var modalEdit = document.getElementById('modalEditDinas');
            if (modalEdit) {
                modalEdit.addEventListener('show.bs.modal', function(event) {
                    // Tombol yang memicu modal
                    var button = event.relatedTarget;

                    // Ambil data dari atribut tombol
                    var id = button.getAttribute('data-id');
                    var nama = button.getAttribute('data-nama');
                    var namaLengkap = button.getAttribute('data-namalengkap');
                    var deskripsi = button.getAttribute('data-deskripsi');

                    console.log("ID Dinas:", id);

                    // Ambil elemen form berdasarkan ID yang kita buat tadi
                    var form = document.getElementById('formEditDinas');

                    // Set URL Action form secara dinamis
                    // Hasilnya akan menjadi: http://.../super-admin/kelola-dinas/1
                    var baseUrl = "{{ route('superadmin.dinas.index') }}";
                    form.action = baseUrl + '/' + id;

                    // Isi input form dengan data yang ada
                    document.getElementById('editNamaDinas').value = nama;
                    document.getElementById('editNamaLengkap').value = namaLengkap;
                    document.getElementById('editDeskripsi').value = deskripsi;
                });
            }

            // --- HANDLING MODAL HAPUS ---
            var modalHapus = document.getElementById('modalHapusDinas');
            if (modalHapus) {
                modalHapus.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var nama = button.getAttribute('data-nama');

                    // Pastikan form hapus juga ditarget dengan benar
                    // Tips: Sebaiknya form hapus juga diberi ID seperti form edit
                    var form = modalHapus.querySelector('form');
                    var baseUrl = "{{ route('superadmin.dinas.index') }}";

                    if (id) {
                        form.action = baseUrl + '/' + id;
                    }

                    modalHapus.querySelector('#hapusNamaDinas').textContent = nama;
                });
            }
        });
    </script>
@endpush
