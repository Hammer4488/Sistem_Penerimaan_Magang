@extends('layouts.app')

@section('title', 'Riwayat Pendaftaran')

@push('styles')
    <style>
        /* V TAMBAHKAN BLOK BARU INI V */
        .welcome-card {
            background-color: #ffffff border-radius: 12px;
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
            padding-top: 1rem;
            /* <-- TAMBAHKAN */
            padding-bottom: 1rem;
            /* <-- TAMBAHKAN */
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
    <x-sidebar active="riwayatpendaftaran" />

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
                            @forelse ($riwayatPendaftaran as $pendaftaran)
                                <tr>
                                    {{-- Nomor urut otomatis --}}
                                    <th scope="row">{{ $loop->iteration }}</th>

                                    {{-- Menampilkan nama dinas dari relasi --}}
                                    <td>{{ $pendaftaran->dinas->nama_dinas ?? 'Dinas tidak ditemukan' }}</td>

                                    {{-- Tombol Detail Formulir (link bisa disesuaikan nanti) --}}
                                    <td>
                                        <a href="{{ route('pendaftaran.show', $pendaftaran) }}" class="btn btn-dark btn-sm">
                                            Lihat Detail
                                        </a>
                                    </td>

                                    <td>
                                        @php
                                            $statusClass = '';
                                            $statusText = ucfirst($pendaftaran->status); // Teks Status: Diproses, Diterima, Ditolak
                                            $keterangan = $pendaftaran->keterangan_status ?? ''; // Keterangan dari DB
                                            $modalTitle = 'Status Pendaftaran'; // Judul default modal
                                            $modalIcon = 'fa-info-circle'; // Ikon default
                                            $modalColor = 'text-primary'; // Warna ikon default

                                            switch ($pendaftaran->status) {
                                                case 'diterima':
                                                    $statusClass = 'status-diterima';
                                                    $modalTitle = 'Pendaftaran Diterima!';
                                                    $modalIcon = 'fa-check-circle';
                                                    $modalColor = 'text-success';
                                                    $keterangan =
                                                        $keterangan ?: 'Selamat! Pendaftaran Anda telah disetujui.'; // Pesan default jika keterangan kosong
                                                    break;
                                                case 'ditolak':
                                                    $statusClass = 'status-ditolak';
                                                    $modalTitle = 'Pendaftaran Ditolak';
                                                    $modalIcon = 'fa-times-circle';
                                                    $modalColor = 'text-danger';
                                                    $keterangan =
                                                        $keterangan ?:
                                                        'Maaf, pendaftaran Anda ditolak. Hubungi dinas terkait untuk info lebih lanjut.'; // Pesan default
                                                    break;
                                                default:
                                                    // 'diproses'
                                                    $statusClass = 'status-diproses';
                                                    $modalTitle = 'Pendaftaran Diproses';
                                                    $modalIcon = 'fa-spinner fa-spin'; // Ikon loading
                                                    $modalColor = 'text-primary';
                                                    $keterangan =
                                                        $keterangan ?:
                                                        'Pendaftaran Anda sedang dalam proses peninjauan oleh dinas terkait.'; // Pesan default
                                                    break;
                                            }
                                        @endphp

                                        {{-- Ubah span menjadi link/button yang memicu modal --}}
                                        <a href="#" class="status-badge {{ $statusClass }} text-decoration-none"
                                            data-bs-toggle="modal" data-bs-target="#statusDetailModal" {{-- Kirim data ke modal via atribut data-bs-* --}}
                                            data-bs-title="{{ $modalTitle }}" data-bs-icon="{{ $modalIcon }}"
                                            data-bs-icon-color="{{ $modalColor }}"
                                            data-bs-keterangan="{{ $keterangan }}">
                                            {{ $statusText }}
                                        </a>
                                    </td>

                                    {{-- Logika untuk tombol Surat Balasan --}}
                                    <td>
                                        @if ($pendaftaran->status == 'diterima')
                                            <a href="#" class="btn btn-primary btn-sm">Download</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Anda belum pernah mengajukan pendaftaran magang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </main>
    </div>
    {{-- ... (kode tabel Anda) ... --}}

    {{-- [BARU] Struktur Bootstrap Modal --}}
    <div class="modal fade" id="statusDetailModal" tabindex="-1" aria-labelledby="statusDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-body">
                    {{-- Ikon akan diisi oleh JS --}}
                    <p><i id="modalStatusIcon" class="fas fa-3x mb-3"></i></p>
                    {{-- Judul akan diisi oleh JS --}}
                    <h5 class="modal-title mb-3" id="statusDetailModalLabel"></h5>
                    {{-- Keterangan akan diisi oleh JS --}}
                    <p id="modalStatusKeterangan" class="text-muted mb-4"></p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Struktur Modal --}}

@endsection

@push('scripts')
    <script>
        // Pastikan DOM sudah siap
        document.addEventListener('DOMContentLoaded', function() {
            var statusModal = document.getElementById('statusDetailModal');
            if (statusModal) {
                statusModal.addEventListener('show.bs.modal', function(event) {
                    // Tombol/Link yang memicu modal
                    var button = event.relatedTarget;

                    // Ambil data dari atribut data-bs-*
                    var title = button.getAttribute('data-bs-title');
                    var icon = button.getAttribute('data-bs-icon');
                    var iconColor = button.getAttribute('data-bs-icon-color');
                    var keterangan = button.getAttribute('data-bs-keterangan');

                    // Dapatkan elemen di dalam modal
                    var modalTitle = statusModal.querySelector('.modal-title');
                    var modalIconElement = statusModal.querySelector('#modalStatusIcon');
                    var modalKeteranganElement = statusModal.querySelector('#modalStatusKeterangan');

                    // Update konten modal
                    modalTitle.textContent = title;
                    modalKeteranganElement.textContent = keterangan;

                    // Update ikon (hapus kelas lama, tambahkan kelas baru)
                    modalIconElement.className = 'fas fa-3x mb-3 ' + icon + ' ' + iconColor;
                });
            }
        });
    </script>
@endpush
