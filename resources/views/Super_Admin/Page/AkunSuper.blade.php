@extends('layouts.app')
@section('title', 'Kelola Akun User')

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

    {{-- Asumsi identifier sidebar adalah 'kelolaakun' --}}
    <x-sidebar active="kelolaakun" />

    <div class="main-content">
        <main class="content-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
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
                    <h5 class="mb-0 fw-bold">Manajemen Akun Pengguna</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="fas fa-user-plus me-1"></i> Tambah User
                    </button>
                </div>
                <div class="card-body">

                    {{-- FITUR FILTER & SEARCH --}}
                    <form action="{{ route('superadmin.users.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="filterRole" class="form-label small text-muted">Filter Role</label>
                                <select name="role" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Role</option>
                                    <option value="super admin" {{ request('role') == 'super admin' ? 'selected' : '' }}>
                                        Super Admin</option>
                                    <option value="admin dinas" {{ request('role') == 'admin dinas' ? 'selected' : '' }}>
                                        Admin Dinas</option>
                                    <option value="pelamar" {{ request('role') == 'pelamar' ? 'selected' : '' }}>Pelamar
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label for="search" class="form-label small text-muted">Cari Nama / Email</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Cari nama atau email..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i>
                                        Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-wrapper">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Instansi (Dinas)</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            <small class="text-muted">Bergabung:
                                                {{ $user->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role == 'super admin')
                                                <span class="badge bg-danger">Super Admin</span>
                                            @elseif($user->role == 'admin dinas')
                                                <span class="badge bg-primary">Admin Dinas</span>
                                            @else
                                                <span class="badge bg-secondary">Pelamar</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Menampilkan nama dinas jika ada relasi --}}
                                            {{ $user->dinas->nama_dinas ?? '-' }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                                data-bs-target="#modalEditUser" data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                data-role="{{ $user->role }}" data-dinas="{{ $user->id_dinas }}">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>

                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapusUser" data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Data user tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination (Optional) --}}
                    <div class="d-flex justify-content-end mt-3">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL TAMBAH USER --}}
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahUserLabel">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" required placeholder="Nama User">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required
                                placeholder="user@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select select-role" name="role" required>
                                <option value="pelamar">Pelamar</option>
                                <option value="admin dinas">Admin Dinas</option>
                                <option value="super admin">Super Admin</option>
                            </select>
                        </div>
                        {{-- Dropdown Dinas (Hanya aktif jika Admin Dinas) --}}
                        <div class="mb-3 div-dinas d-none">
                            <label for="id_dinas" class="form-label">Pilih Dinas</label>
                            <select class="form-select" name="id_dinas">
                                <option value="">-- Pilih Dinas --</option>
                                @foreach ($list_dinas as $d)
                                    <option value="{{ $d->id_dinas }}">{{ $d->nama_dinas }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">*Wajib dipilih jika role Admin Dinas</small>
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

    {{-- MODAL EDIT USER --}}
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditUser" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="editPassword">
                                <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted text-small fst-italic">Kosongkan jika tidak ingin mengubah
                                password.</small>
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select select-role" name="role" id="editRole" required>
                                <option value="pelamar">Pelamar</option>
                                <option value="admin dinas">Admin Dinas</option>
                                <option value="super admin">Super Admin</option>
                            </select>
                        </div>
                        <div class="mb-3 div-dinas d-none" id="divEditDinas">
                            <label for="editIdDinas" class="form-label">Pilih Dinas</label>
                            <select class="form-select" name="id_dinas" id="editIdDinas">
                                <option value="">-- Pilih Dinas --</option>
                                @foreach ($list_dinas as $d)
                                    <option value="{{ $d->id_dinas }}">{{ $d->nama_dinas }}</option>
                                @endforeach
                            </select>
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

    {{-- MODAL HAPUS USER --}}
    <div class="modal fade" id="modalHapusUser" tabindex="-1" aria-labelledby="modalHapusUserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusUserLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formHapusUser" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus user: <strong id="hapusNamaUser">...</strong>?</p>
                        <p class="text-danger small">Data yang dihapus tidak dapat dikembalikan.</p>
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

            function setupPasswordToggle(buttonId, inputId) {
                const toggleBtn = document.getElementById(buttonId);
                const inputField = document.getElementById(inputId);

                if (toggleBtn && inputField) {
                    toggleBtn.addEventListener('click', function() {
                        // Ubah tipe input: password <-> text
                        const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                        inputField.setAttribute('type', type);

                        // Ubah ikon: mata terbuka <-> mata dicoret
                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    });
                }
            }
            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('toggleEditPassword', 'editPassword');

            function toggleDinasInput(selectElement) {
                // Cari div pembungkus dropdown dinas (sibling dari parent atau closest form)
                var form = selectElement.closest('form');
                var dinasDiv = form.querySelector('.div-dinas');

                if (selectElement.value === 'admin dinas') {
                    dinasDiv.classList.remove('d-none');
                } else {
                    dinasDiv.classList.add('d-none');
                    // Reset value jika disembunyikan (opsional)
                    // form.querySelector('[name="id_dinas"]').value = "";
                }
            }

            // Pasang event listener ke semua select role (tambah & edit)
            document.querySelectorAll('.select-role').forEach(function(select) {
                select.addEventListener('change', function() {
                    toggleDinasInput(this);
                });
            });


            // --- HANDLING MODAL EDIT ---
            var modalEdit = document.getElementById('modalEditUser');
            if (modalEdit) {
                modalEdit.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;

                    var id = button.getAttribute('data-id');
                    var name = button.getAttribute('data-name');
                    var email = button.getAttribute('data-email');
                    var role = button.getAttribute('data-role');
                    var dinas = button.getAttribute('data-dinas');

                    var form = document.getElementById('formEditUser');
                    var baseUrl = "{{ route('superadmin.users.index') }}";
                    form.action = baseUrl + '/' + id;

                    document.getElementById('editName').value = name;
                    document.getElementById('editEmail').value = email;

                    // Set Role dan Trigger Event change agar dropdown dinas muncul/hilang
                    var roleSelect = document.getElementById('editRole');
                    roleSelect.value = role;

                    // Manual trigger event change untuk update tampilan input dinas
                    toggleDinasInput(roleSelect);

                    // Set Dinas
                    document.getElementById('editIdDinas').value = dinas;
                });
            }

            // --- HANDLING MODAL HAPUS ---
            var modalHapus = document.getElementById('modalHapusUser');
            if (modalHapus) {
                modalHapus.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var name = button.getAttribute('data-name');

                    var form = document.getElementById('formHapusUser');
                    var baseUrl = "{{ route('superadmin.users.index') }}";
                    form.action = baseUrl + '/' + id;

                    document.getElementById('hapusNamaUser').textContent = name;
                });
            }
        });
    </script>
@endpush
