@extends('layouts.app')

@section('title', 'Ajukan Magang')

@push('styles')
    <style>
        /* body {
                                                                        font-family: 'Poppins', sans-serif;
                                                                        background-color: #FF0000;
                                                                    } */

        .main-content {
            margin-left: 300px;
            padding: 0;
        }

        .content-body {
            padding: 30px;
        }


        .welcome-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #dee2e6;
            box-shadow: none;

        }

        .info-magang-alert {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            color: #2c3e50;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .info-magang-alert h5 {
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .info-magang-alert h5 i {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-right: 12px;
        }

        .info-magang-alert ul {
            list-style: none;
            padding-left: 1;
            margin-bottom: 0;
        }

        .info-magang-alert ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            color: #555;
            font-size: 0.95rem;
        }

        .info-magang-alert ul li:last-child {
            margin-bottom: 0;
        }

        .info-magang-alert ul li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 7px;
            width: 8px;
            height: 8px;
            background-color: #2c3e50;
            border-radius: 50%;
        }

        .custom-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .quota-card {
            border-radius: 0.75rem;
            transition: all 0.3s ease-in-out;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .quota-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .quota-card .btn {
            border-radius: 0.5rem;
            font-size: 1rem;
            padding: 0.75rem 0;
            transition: all 0.2s ease-in-out;
        }

        .quota-card .btn:hover {
            transform: scale(1.02);
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


        .stat-box .text-total {
            color: #0d6efd;

        }

        .stat-box .text-terisi {
            color: #dc3545;
        }

        .stat-box .text-sisa {
            color: #198754;

        }

        .modal-icon-error {
            font-size: 3rem;
            color: #dc3545;
            /* Warna merah Bootstrap */
        }
    </style>
@endpush

@section('content')
    <x-sidebar active="ajukanpelamar" />


    <div class="main-content">
        <main class="content-body">
            {{-- 
            <div class="flow-card welcome-card mb-4">
                <h4 class="mb-1">Selamat Datang, {{ $user->name }}!</h4>
                <p class="text-muted mb-0">Kelola pendaftaran magang anda di Pemerintah Kota Banjarmasin</p>
            </div> --}}
            <x-welcome />

            {{-- KOTAK INFORMASI PENDAFTARAN MAGANG --}}
            <div class="info-magang-alert mb-5">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Pendaftaran Magang</h5>
                <ul>
                    <li>Pilih dinas yang sesuai dengan minat dan jurusan anda</li>
                    <li>Pastikan kuota pada dinas yang anda pilih masih tersedia</li>
                    <li>Siapkan berkas pendaftaran seperti surat pengantar dan CV</li>
                </ul>
            </div>

            {{-- DINAS CARD CONTOH (Sama seperti di screenshot) --}}
            <div class="row">

                <div class="row">

                    @foreach ($dinasList as $dinas)
                        @php
                            $sisaKuota = $dinas->total_kuota - $dinas->pendaftaran_count;
                        @endphp
                        <div class="col-lg-6 mb-4">
                            <div class="card quota-card h-100">
                                <div class="card-body p-4 position-relative">

                                    {{-- Badge dinamis --}}
                                    @if ($sisaKuota > 0)
                                        <span
                                            class="badge bg-success position-absolute top-0 end-0 mt-3 me-3">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger position-absolute top-0 end-0 mt-3 me-3">Kuota
                                            Terpenuhi</span>
                                    @endif

                                    <h5 class="fw-bold">{{ $dinas->nama_dinas }}</h5>
                                    <p class="text-muted small mb-1">{{ $dinas->nama_lengkap_dinas }}</p>
                                    <p class="card-text small">{{ $dinas->deskripsi }}</p>
                                </div>

                                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                                    <div class="row text-center g-2 mb-3">
                                        {{-- Statistik Kuota --}}
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <div class="number text-primary">{{ $dinas->total_kuota }}</div>
                                                <div class="label">Total Kuota</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <div class="number text-danger">{{ $dinas->pendaftaran_count }}</div>
                                                <div class="label">Kuota Terisi</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <div class="number text-success">
                                                    {{ $sisaKuota }}</div>
                                                <div class="label">Sisa Kuota</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Blok kode BARU dengan 3 kondisi --}}
                                    <div class="mt-4">
                                        @if (in_array($dinas->id_dinas, $pendaftaranPengguna))
                                            {{-- Kondisi 1: Jika ID dinas ada di dalam riwayat pendaftaran pengguna --}}
                                            <a href ="#" class="btn btn-success w-100 fw-bold disabled"
                                                style="opacity: 0.8;">
                                                <i class="fas fa-check-circle me-2"></i> Sudah Diajukan
                                            </a>
                                        @elseif ($sisaKuota <= 0)
                                            <a href="#" class="btn btn-secondary w-100 fw-bold disabled">
                                                Kuota Penuh
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-primary w-100 fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#pilihJenisPendaftaranModal"
                                                data-dinas-url="{{ route('pendaftaran.create', $dinas) }}"
                                                data-sisa-kuota="{{ $sisaKuota }}">
                                                Pilih Dinas Ini
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </main>
    </div>

    {{-- [BARU] Modal untuk Memilih Jenis Pendaftaran --}}
    <div class="modal fade" id="pilihJenisPendaftaranModal" tabindex="-1" aria-labelledby="pilihJenisModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pilihJenisModalLabel">Pilih Jenis Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan mendaftar untuk diri sendiri atau mewakili kelompok?</p>
                    <div class="d-grid gap-2">
                        <a href="#" id="lanjutkanIndividuBtn" class="btn btn-outline-primary">
                            <i class="fas fa-user me-2"></i> Daftar Sebagai Individu
                        </a>
                        <a href="#" id="lanjutkanKelompok2Btn" class="btn btn-outline-info">
                            <i class="fas fa-users me-2"></i> Daftar Sebagai Kelompok (2 Orang)
                        </a>
                        <a href="#" id="lanjutkanKelompok3Btn" class="btn btn-outline-info">
                            <i class="fas fa-users me-2"></i> Daftar Sebagai Kelompok (3 Orang)
                        </a>
                        <a href="#" id="lanjutkanKelompok4Btn" class="btn btn-outline-info">
                            <i class="fas fa-users me-2"></i> Daftar Sebagai Kelompok (4 Orang)
                        </a>
                    </div>

                    {{-- Simpan URL target dinas di sini (akan diisi oleh JS) --}}
                    <input type="hidden" id="modalTargetUrl">
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Modal --}}

    <div class="modal fade" id="kuotaTidakCukupModal" tabindex="-1" aria-labelledby="kuotaErrorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-body">
                    <p><i class="fas fa-times-circle modal-icon-error mb-3"></i></p>
                    <h5 class="modal-title mb-3" id="kuotaErrorModalLabel">Pendaftaran Gagal</h5>
                    <p id="kuotaErrorMessage" class="text-muted mb-4"></p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var pilihJenisModal = document.getElementById('pilihJenisPendaftaranModal');
            var modalTargetUrlInput = document.getElementById('modalTargetUrl');
            var btnIndividu = document.getElementById('lanjutkanIndividuBtn');
            var btnKelompok2 = document.getElementById('lanjutkanKelompok2Btn');
            var btnKelompok3 = document.getElementById('lanjutkanKelompok3Btn');
            var btnKelompok4 = document.getElementById('lanjutkanKelompok4Btn');
            var kuotaDinasSaatIni = 0;
            var kuotaErrorModalElement = document.getElementById('kuotaTidakCukupModal');
            var kuotaErrorModal = new bootstrap.Modal(kuotaErrorModalElement);
            var modalErrorMessage = document.getElementById('kuotaErrorMessage');


            if (pilihJenisModal) {
                pilihJenisModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var targetUrl = button.getAttribute('data-dinas-url');
                    modalTargetUrlInput.value = targetUrl;
                    var sisaKuotaStr = button.getAttribute('data-sisa-kuota');
                    kuotaDinasSaatIni = parseInt(sisaKuotaStr) || 0;
                });

                function navigateToForm(jumlah) {
                    if (jumlah > kuotaDinasSaatIni) {
                        modalErrorMessage.textContent = 'Jumlah anggota anda (' + jumlah +
                            ' orang) melebihi sisa kuota yang tersedia (' + kuotaDinasSaatIni + ' orang).';
                        var pilihJenisModalInstance = bootstrap.Modal.getInstance(pilihJenisModal);
                        pilihJenisModalInstance.hide();
                        kuotaErrorModal.show();

                        return;
                    }
                    var baseUrl = modalTargetUrlInput.value;
                    var finalUrl = baseUrl + '?jumlah=' + jumlah;
                    window.location.href = finalUrl;
                }

                btnIndividu.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateToForm(1);
                    _
                });
                btnKelompok2.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateToForm(2);
                });
                btnKelompok3.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateToForm(3);
                    label
                });
                btnKelompok4.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateToForm(4);
                });
            }
        });
    </script>
@endpush
