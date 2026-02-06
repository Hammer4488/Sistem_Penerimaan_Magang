@extends('layouts.app')
@section('title', 'Verifikasi Pendaftar')


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

        .detail-info-box dt {
            font-weight: 600;
            color: #333;
        }

        .detail-info-box dd {
            color: #555;
            margin-bottom: 1rem;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }

            .content-body {
                padding: 20px 15px;
            }
        }

        #detail-section-grup table.table-sm td,
        #detail-section-grup table.table-sm th {
            padding: 6px 8px !important;
        }
    </style>
@endpush

@section('content')




    <x-sidebar active="pendaftardinas" />
    <div class="main-content">
        <main class="content-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Menampilkan Pesan Error (dari validasi atau lainnya) --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Menampilkan Error Validasi (jika ada) --}}
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

            {{-- KARTU UTAMA BERISI TABEL --}}
            <div class="custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Data Pendaftar</h5>
                    <div class="w-25">

                        <form action="{{ route('pendaftar.dinas') }}" method="GET">

                            <select class="form-select" name="status" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                                    Diterima
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Asal Sekolah/Universitas</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop semua data pendaftar --}}
                                @forelse ($pendaftarList as $pendaftaran)
                                    {{-- ✅ SESUDAHNYA (GANTI DENGAN INI) --}}
                                    @php
                                        $cv = $pendaftaran->dokumen->where('jenis_dokumen', 'cv')->first();
                                        $surat = $pendaftaran->dokumen
                                            ->where('jenis_dokumen', 'surat_pengantar')
                                            ->first();
                                        $suratBalasan = $pendaftaran->dokumen
                                            ->where('jenis_dokumen', 'surat_balasan')
                                            ->first();

                                        // --- Persiapan Data Detail (Individu/Grup) ---
                                        $isGrup = $pendaftaran->id_grup && $pendaftaran->anggotaGrup->isNotEmpty();
                                        $anggotaJson = '[]';

                                        if ($isGrup) {
                                            $anggotaList = $pendaftaran->anggotaGrup->map(function ($anggota) {
                                                $cvAnggota = $anggota->dokumen->where('jenis_dokumen', 'cv')->first();
                                                return [
                                                    'nama' => $anggota->nama_lengkap,
                                                    'nim' => $anggota->nis_nim,
                                                    'asal_instansi' => $anggota->asal_sekolah_universitas,
                                                    'jurusan' => $anggota->jurusan_program_studi,
                                                    'no_hp' => $anggota->no_hp_aktif,
                                                    'alamat' => $anggota->alamat,
                                                    'detailEmail' => $anggota->user->email ?? '-',
                                                ];
                                            });

                                            $anggotaJson = htmlspecialchars(
                                                $anggotaList->toJson(),
                                                ENT_QUOTES,
                                                'UTF-8',
                                            );
                                        }
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $pendaftaran->nama_lengkap }}
                                            {{-- Beri tanda jika ini pendaftar grup --}}
                                            @if ($pendaftaran->id_grup)
                                                <span class="badge bg-info-subtle text-info-emphasis ms-1">Kelompok</span>
                                            @endif
                                        </td>
                                        <td>{{ $pendaftaran->asal_sekolah_universitas }}</td>
                                        <td>{{ $pendaftaran->created_at->format('d M Y') }}</td>
                                        <td>
                                            {{-- Badge status dinamis --}}
                                            @if ($pendaftaran->status == 'diproses')
                                                <span class="badge bg-primary">Diproses</span>
                                            @elseif ($pendaftaran->status == 'diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif ($pendaftaran->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif ($pendaftaran->status == 'selesai')
                                                <span class="badge bg-secondary">Selesai Magang</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $detailButtonHtml =
                                                    '
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailPendaftar"

                                            data-instansi="' .
                                                    $pendaftaran->asal_sekolah_universitas .
                                                    '"
                                            data-jurusan="' .
                                                    $pendaftaran->jurusan_program_studi .
                                                    '"
                                            data-surat-url="' .
                                                    ($surat ? Storage::url($surat->path_file) : '#') .
                                                    '"
                                            data-tgl-mulai="' .
                                                    $pendaftaran->tanggal_mulai_magang->format('d M Y') .
                                                    '"
                                            data-tgl-akhir="' .
                                                    $pendaftaran->tanggal_akhir_magang->format('d M Y') .
                                                    '"
                                        data-divisi="' .
                                                    ($pendaftaran->divisi->nama_divisi ?? '-') .
                                                    '"
                                            data-is-grup="' .
                                                    ($isGrup ? 'true' : 'false') .
                                                    '"
                                            data-nama="' .
                                                    $pendaftaran->nama_lengkap .
                                                    '"
                                            data-email="' .
                                                    ($pendaftaran->user->email ?? 'N/A') .
                                                    '"
                                            data-cv-url="' .
                                                    ($cv ? Storage::url($cv->path_file) : '#') .
                                                    '"
                                            data-nim="' .
                                                    $pendaftaran->nis_nim .
                                                    '"
                                            data-alamat="' .
                                                    $pendaftaran->alamat .
                                                    '"
                                            data-no-hp="' .
                                                    $pendaftaran->no_hp_aktif .
                                                    '"
                                            data-anggota="' .
                                                    $anggotaJson .
                                                    '">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </button>
                                    ';
                                            @endphp


                                            @if ($pendaftaran->status == 'diproses')
                                                {{-- --- STATUS: DIPROSES --- --}}

                                                {!! $detailButtonHtml !!} {{-- Cetak tombol detail dinamis --}}

                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#modalKonfirmasiSetujui"
                                                    data-pendaftar-id="{{ $pendaftaran->id_grup ? $pendaftaran->id_grup : $pendaftaran->id_pendaftaran }}"
                                                    data-is-grup="{{ $pendaftaran->id_grup ? 'true' : 'false' }}"
                                                    data-nama="{{ $pendaftaran->nama_lengkap }}">
                                                    <i class="fas fa-check me-1"></i> Setujui
                                                </button>


                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#modalTolak"
                                                    data-pendaftar-id="{{ $pendaftaran->id_pendaftaran }}"
                                                    data-is-grup="{{ $pendaftaran->id_grup ? 'true' : 'false' }}"
                                                    data-nama="{{ $pendaftaran->nama_lengkap }}">
                                                    <i class="fas fa-times me-1"></i> Tolak
                                                </button>
                                            @elseif ($pendaftaran->status == 'diterima')
                                                {{-- --- STATUS: DITERIMA --- --}}

                                                {!! $detailButtonHtml !!} {{-- Cetak tombol detail dinamis --}}

                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalSetujui"
                                                    data-pendaftar-id="{{ $pendaftaran->id_grup ? $pendaftaran->id_grup : $pendaftaran->id_pendaftaran }}"
                                                    data-is-grup="{{ $pendaftaran->id_grup ? 'true' : 'false' }}"
                                                    data-nama="{{ $pendaftaran->nama_lengkap }}">
                                                    <i class="fas fa-upload me-1"></i> Kirim Surat
                                                </button>

                                                {{-- GANTI FORM YANG TADI DENGAN TOMBOL INI --}}
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#modalSelesai"
                                                    data-id="{{ $pendaftaran->id_pendaftaran }}"
                                                    data-nama="{{ $pendaftaran->nama_lengkap }}">
                                                    <i class="fas fa-check-double me-1"></i> Selesai
                                                </button>

                                                @if ($suratBalasan)
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#modalHapusSurat"
                                                        data-pendaftar-id="{{ $pendaftaran->id_pendaftaran }}"
                                                        data-suraturl="{{ Storage::url($suratBalasan->path_file) }}">
                                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                                    </button>
                                                @endif
                                            @elseif ($pendaftaran->status == 'ditolak')
                                                {{-- --- STATUS: DITOLAK --- --}}
                                                {!! $detailButtonHtml !!} {{-- Cetak tombol detail dinamis --}}

                                                <button class="btn btn-sm btn-outline-danger" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modalLihatAlasan"
                                                    data-alasan="{{ $pendaftaran->keterangan_status }}">
                                                    <i class="fas fa-info-circle me-1"></i> Lihat Alasan
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Tampilkan ini jika tidak ada data pendaftar --}}
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada pendaftar magang.
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

    {{-- modal --}}
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakLabel">Tolak Pendaftar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- <input type="hidden" name="pendaftar_id" id="tolakIdPendaftar"> --}}
                <form action="{{ route('admin.pendaftardinas.tolak') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pendaftar_id" id="tolakIdPendaftar">
                    <input type="hidden" name="is_grup" id="tolakIsGrup">

                    <div class="modal-body">
                        <p>Anda akan menolak pendaftaran atas nama <strong id="tolakNamaPendaftar">...</strong>.</p>
                        <div class="mb-3">
                            <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" name="alasan_penolakan" id="alasan_penolakan" rows="4"
                                placeholder="Contoh: Kuota untuk divisi IT sudah penuh..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLihatAlasan" tabindex="-1" aria-labelledby="modalAlasanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAlasanLabel">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Pendaftar ini ditolak dengan alasan:</p>
                    <p id="isiAlasan" class="fw-bold">...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKonfirmasiSetujui" tabindex="-1" aria-labelledby="modalKonfirmasiSetujuiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKonfirmasiSetujuiLabel">Konfirmasi Persetujuan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pendaftar.approveOnly') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pendaftar_id" id="approveOnlyIdPendaftar">
                    <div class="modal-body">
                        <p>Anda yakin ingin menyetujui pendaftaran atas nama <strong
                                id="approveOnlyNamaPendaftar">...</strong>?</p>
                        <p class="text-muted small">Tindakan ini akan mengubah status pendaftar
                            menjadi "Diterima". Anda dapat mengirimkan surat balasan setelah ini.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSetujui" tabindex="-1" aria-labelledby="modalSetujuiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSetujuiLabel">Kirim Surat Balasan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pendaftar.setujui') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pendaftar_id" id="setIdPendaftar">

                    <input type="hidden" name="jenis_dokumen" value="surat_balasan">

                    <div class="modal-body">
                        <p>Anda akan menyetujui pendaftar atas nama <strong id="setNamaPendaftar">...</strong>.</p>
                        <p>Silakan upload surat balasan (PDF) untuk dikirimkan kepada pendaftar.</p>
                        <div class="mb-3">
                            <label for="file_surat" class="form-label">File Surat Balasan (PDF)</label>
                            <input class="form-control" type="file" name="file_surat" id="file_surat" accept=".pdf"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSelesai" tabindex="-1" aria-labelledby="modalSelesaiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSelesaiLabel">Konfirmasi Selesai Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Form Action akan di-update via Javascript --}}
                <form id="formSelesai" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-check-circle text-success fa-3x"></i>
                        </div>
                        <p class="text-center">
                            Apakah Anda yakin ingin menandai peserta <br>
                            <strong id="namaPesertaSelesai" class="fs-5">...</strong> <br>
                            sebagai <strong>Selesai Magang</strong>?
                        </p>
                        <p class="text-center text-muted small">
                            Status akan berubah menjadi "Selesai" dan tidak bisa dikembalikan ke "Diterima".
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusSurat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.pendaftar.hapusSurat') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pendaftar_id" id="hapusIdPendaftar">

                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Surat Balasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus surat balasan ini?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalDetailPendaftar" tabindex="-1" aria-labelledby="modalDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Detail Pendaftar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="detail-section-individu">
                        <h6 class="text-muted fw-bold mb-3">Data Diri</h6>
                        <dl class="row detail-info-box">
                            <dt class="col-sm-4">Nama Lengkap</dt>
                            <dd class="col-sm-8" id="detailNama">...</dd>
                            <dt class="col-sm-4">NIS / NIM</dt>
                            <dd class="col-sm-8" id="detailNim">...</dd>
                            <dt class="col-sm-4">No. HP Aktif</dt>
                            <dd class="col-sm-8" id="detailNoHp">...</dd>
                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8" id="detailEmail">...</dd>
                            <dt class="col-sm-4">Alamat</dt>
                            <dd class="col-sm-8" id="detailAlamat">...</dd>
                        </dl>

                        <hr class="my-3">

                    </div>


                    <h6 class="text-muted fw-bold mb-3">Data Akademik & Magang</h6>
                    <dl class="row detail-info-box">
                        <dt class="col-sm-4">Asal Sekolah/Universitas</dt>
                        <dd class="col-sm-8" id="detailInstansi">...</dd>
                        <dt class="col-sm-4">Jurusan/Program Studi</dt>
                        <dd class="col-sm-8" id="detailJurusan">...</dd>
                        <dt class="col-sm-4">Tanggal Mulai Magang</dt>
                        <dd class="col-sm-8" id="detailTglMulai">...</dd>
                        <dt class="col-sm-4">Tanggal Akhir Magang</dt>
                        <dd class="col-sm-8" id="detailTglAkhir">...</dd>
                        <dt class="col-sm-4">Divisi yang Dipilih</dt>
                        <dd class="col-sm-8" id="detailDivisi">...</dd>
                    </dl>

                    <hr class="my-3">


                    <h6 class="text-muted fw-bold mb-3">Berkas Pendaftaran</h6>
                    <div class="row mb-3">
                        <div class="col-md-6 text-center">
                            <a href="#" id="detailLinkSurat" class="btn btn-outline-dark w-100 mb-2"
                                target="_blank">
                                <i class="fas fa-file-alt me-2"></i> Surat Pengantar
                            </a>
                        </div>
                        <div class="col-md-6 text-center">
                            <a href="#" id="detailLinkCV" class="btn btn-outline-dark w-100 mb-2" target="_blank">
                                <i class="fas fa-file-alt me-2"></i> Lihat CV
                            </a>
                        </div>
                    </div>

                    <div id="detail-section-grup" style="display: none;">
                        <hr class="my-3">
                        <h6 class="text-muted fw-bold mb-3">Daftar Anggota Kelompok</h6>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 40px;">No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIS / NIM</th>
                                        <th>No. HP Aktif</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody id="detailTabelAnggota" style="font-size: 0.9rem;">
                                </tbody>
                            </table>
                        </div>
                    </div>




                @endsection

                @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modalDetail = document.getElementById('modalDetailPendaftar');
                            if (modalDetail) {
                                modalDetail.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;
                                    var isGrup = button.getAttribute('data-is-grup') === 'true';
                                    var instansi = button.getAttribute('data-instansi');
                                    var jurusan = button.getAttribute('data-jurusan');
                                    var divisi = button.getAttribute('data-divisi');
                                    modalDetail.querySelector('#detailDivisi').textContent = divisi || '-';
                                    var suratUrl = button.getAttribute('data-surat-url');
                                    var tglMulai = button.getAttribute('data-tgl-mulai');
                                    var tglAkhir = button.getAttribute('data-tgl-akhir');

                                    var modalTitle = modalDetail.querySelector('#modalDetailLabel');
                                    var sectionIndividu = modalDetail.querySelector('#detail-section-individu');
                                    var sectionGrup = modalDetail.querySelector('#detail-section-grup');
                                    var linkCV = modalDetail.querySelector('#detailLinkCV');
                                    var tabelAnggota = modalDetail.querySelector('#detailTabelAnggota');

                                    modalDetail.querySelector('#detailInstansi').textContent = instansi || '...';
                                    modalDetail.querySelector('#detailJurusan').textContent = jurusan || '...';
                                    modalDetail.querySelector('#detailLinkSurat').setAttribute('href', suratUrl || '#');
                                    modalDetail.querySelector('#detailTglMulai').textContent = tglMulai || '...';
                                    modalDetail.querySelector('#detailTglAkhir').textContent = tglAkhir || '...';

                                    if (isGrup) {
                                        modalTitle.textContent = 'Detail Pendaftar (Kelompok)';
                                        sectionIndividu.style.display = 'none';
                                        sectionGrup.style.display = 'block';
                                        var cvUrl = button.getAttribute('data-cv-url');
                                        if (cvUrl && cvUrl !== '#') {
                                            linkCV.style.display = 'inline-block';
                                            linkCV.setAttribute('href', cvUrl);
                                        } else {
                                            linkCV.style.display = 'none';
                                        }

                                        var anggotaData = [];
                                        try {
                                            var decodedJson = new DOMParser().parseFromString(
                                                button.getAttribute('data-anggota'),
                                                "text/html"
                                            ).documentElement.textContent;
                                            anggotaData = JSON.parse(decodedJson || '[]');
                                        } catch (e) {
                                            console.error("Gagal parsing JSON data anggota:", e);
                                        }

                                        tabelAnggota.innerHTML = '';
                                        if (anggotaData.length > 0) {
                                            anggotaData.forEach(function(anggota, index) {
                                                var cvButton = (anggota.cv_url && anggota.cv_url !== '#') ?
                                                    `<a href="${anggota.cv_url}" class="btn btn-sm btn-outline-dark" target="_blank">
                               <i class="fas fa-file"></i>
                            </a>` :
                                                    `<span class="text-muted">N/A</span>`;

                                                var row = `<tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>${anggota.nama || 'N/A'}</td>
                                    <td>${anggota.nim || 'N/A'}</td>
                                    <td>${anggota.no_hp || '-'}</td>
                                    <td>${anggota.detailEmail || '-'}</td>
                                    <td>${anggota.alamat || '-'}</td>
                                </tr>`;
                                                tabelAnggota.innerHTML += row;
                                            });
                                        } else {
                                            tabelAnggota.innerHTML =
                                                '<tr><td colspan="8" class="text-center text-muted">Tidak ada data anggota.</td></tr>';
                                        }
                                    } else {
                                        // === Jika pendaftar individu ===
                                        modalTitle.textContent = 'Detail Pendaftar (Individu)';
                                        sectionIndividu.style.display = 'block';
                                        sectionGrup.style.display = 'none';
                                        linkCV.style.display = 'inline-block';
                                        tabelAnggota.innerHTML = '';

                                        var nama = button.getAttribute('data-nama');
                                        var email = button.getAttribute('data-email');
                                        var cvUrl = button.getAttribute('data-cv-url');
                                        var nim = button.getAttribute('data-nim');
                                        var alamat = button.getAttribute('data-alamat');
                                        var noHp = button.getAttribute('data-no-hp');

                                        modalDetail.querySelector('#detailNama').textContent = nama || '...';
                                        modalDetail.querySelector('#detailEmail').textContent = email || '...';
                                        modalDetail.querySelector('#detailLinkCV').setAttribute('href', cvUrl || '#');
                                        modalDetail.querySelector('#detailNim').textContent = nim || '...';
                                        modalDetail.querySelector('#detailAlamat').textContent = alamat || '...';
                                        modalDetail.querySelector('#detailNoHp').textContent = noHp || '...';
                                    }
                                });
                            }


                            // --- Modal 2: Setujui (FITUR 2 & 4) ---
                            var modalSetujui = document.getElementById('modalSetujui');
                            if (modalSetujui) {
                                modalSetujui.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;
                                    var pendaftarId = button.getAttribute('data-pendaftar-id');
                                    var nama = button.getAttribute('data-nama');

                                    // Masukkan data ke modal
                                    modalSetujui.querySelector('#setIdPendaftar').value = pendaftarId;
                                    modalSetujui.querySelector('#setNamaPendaftar').textContent = nama;
                                });
                            }

                            // --- Modal 3: Tolak (FITUR 2 & 3) ---
                            var modalTolak = document.getElementById('modalTolak');
                            if (modalTolak) {
                                modalTolak.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;
                                    var pendaftarId = button.getAttribute('data-pendaftar-id');
                                    var isGrup = button.getAttribute('data-is-grup');
                                    var nama = button.getAttribute('data-nama');

                                    modalTolak.querySelector('#tolakIdPendaftar').value = pendaftarId;

                                    var inputGrup = modalTolak.querySelector('#tolakIsGrup');
                                    if (inputGrup) {
                                        inputGrup.value = isGrup;
                                    }

                                    modalTolak.querySelector('#tolakNamaPendaftar').textContent = nama;
                                });
                            }

                            // --- Modal 4: Lihat Alasan (Tambahan) ---
                            var modalAlasan = document.getElementById('modalLihatAlasan');
                            if (modalAlasan) {
                                modalAlasan.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;
                                    var alasan = button.getAttribute('data-alasan');

                                    // Debugging: Cek di Inspect Element -> Console
                                    console.log("Tombol diklik, data alasan:", alasan);

                                    // Ambil elemen <p> tempat menaruh teks
                                    var elemenIsi = modalAlasan.querySelector('#isiAlasan');

                                    // Cek apakah ada isinya atau tidak
                                    if (alasan && alasan.trim() !== "") {
                                        elemenIsi.textContent = alasan;
                                    } else {
                                        elemenIsi.textContent = "Tidak ada alasan yang dicantumkan.";
                                    }
                                });
                            }
                            var modalKonfirmasiSetujui = document.getElementById('modalKonfirmasiSetujui');
                            if (modalKonfirmasiSetujui) {
                                modalKonfirmasiSetujui.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;
                                    var pendaftarId = button.getAttribute('data-pendaftar-id');
                                    var nama = button.getAttribute('data-nama');
                                    // Masukkan data ke modal
                                    modalKonfirmasiSetujui.querySelector('#approveOnlyIdPendaftar').value = pendaftarId;
                                    modalKonfirmasiSetujui.querySelector('#approveOnlyNamaPendaftar').textContent = nama;
                                });
                            }

                            // ===== FIX: MENGISI INPUT HAPUS SURAT =====
                            var modalHapus = document.getElementById('modalHapusSurat');
                            if (modalHapus) {
                                modalHapus.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;

                                    // AMBIL DATA DARI BUTTON
                                    var id = button.getAttribute('data-pendaftar-id'); // <-- DIUBAH

                                    // SET NILAI KE INPUT HIDDEN
                                    modalHapus.querySelector('#hapusIdPendaftar').value = id;
                                });
                            }

                            // --- Modal 5: Konfirmasi Selesai (BARU) ---
                            var modalSelesai = document.getElementById('modalSelesai');
                            if (modalSelesai) {
                                modalSelesai.addEventListener('show.bs.modal', function(event) {
                                    var button = event.relatedTarget;

                                    // Ambil data dari tombol
                                    var id = button.getAttribute('data-id');
                                    var nama = button.getAttribute('data-nama');

                                    // 1. Update Nama di teks modal
                                    modalSelesai.querySelector('#namaPesertaSelesai').textContent = nama;

                                    // 2. Update Action URL pada Form secara dinamis
                                    // Kita gunakan placeholder ':id' lalu replace dengan ID asli
                                    var form = modalSelesai.querySelector('#formSelesai');
                                    var urlTemplate = "{{ route('pendaftaran.selesai', ':id') }}";

                                    // Ganti ':id' dengan ID pendaftar yang diklik
                                    form.action = urlTemplate.replace(':id', id);
                                });
                            }

                        });
                    </script>
                @endpush
