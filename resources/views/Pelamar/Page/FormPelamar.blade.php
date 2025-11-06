@extends('layouts.app')

@section('title', isset($mode) && $mode == 'show' ? 'Detail Pendaftaran' : 'Formulir Pengajuan Magang')

@push('styles')
    <style>
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: 40px auto;
        }

        .form-header-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            background-color: #e8f0fe;
            color: #1a73e8;
            border-radius: 50%;
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .back-arrow {
            font-size: 1.5rem;
            text-decoration: none;
            color: #333;
        }

        input[readonly],
        textarea[readonly],
        select[disabled] {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="form-container">
            {{-- Bagian Header (Tombol Kembali, Judul, Ikon) --}}
            <div class="d-flex justify-content-start mb-3">
                <a href="{{ isset($mode) && $mode == 'show' ? route('riwayatpelamar') : route('ajukanpelamar') }}"
                    class="back-arrow">←</a>
            </div>
            <div class="text-center mb-4">
                <span class="form-header-icon">{!! isset($mode) && $mode == 'show' ? '📄' : '⬆️' !!}</span>
                <h3 class="fw-bold mt-3">
                    {{ isset($mode) && $mode == 'show' ? 'Detail Formulir Pendaftaran' : 'Formulir Peserta Magang' }}</h3>
                <p class="text-muted">
                    {{ isset($mode) && $mode == 'show' ? 'Berikut adalah data yang telah Anda ajukan.' : 'Daftar untuk mengikuti program magang di Pemerintah Kota' }}
                </p>
            </div>
            {{-- Akhir Bagian Header --}}

            <form action="{{ isset($mode) && $mode == 'show' ? '#' : route('pendaftaran.store') }}" method="POST"
                enctype="multipart/form-data">
                @if (!isset($mode) || $mode != 'show')
                    @csrf
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <input type="hidden" name="id_dinas" value="{{ $dinas->id_dinas ?? $pendaftaran->id_dinas }}">

                @php
                    $loopCount = isset($mode) && $mode == 'show' ? 1 : $jumlahAnggota ?? 1;
                    $data = isset($pendaftaran) ? $pendaftaran : null;
                @endphp

                {{-- ======================================================= --}}
                {{-- VVV SISIPKAN BLOK BARU INI VVV --}}
                {{-- ======================================================= --}}
                @if (isset($mode) && $mode == 'show' && $anggotaList)
                    {{-- 
                    ============================================================
                    TAMPILAN BARU: DETAIL UNTUK KELOMPOK (MODE SHOW)
                    ============================================================
                    --}}

                    <h5 class="fw-bold mt-4 mb-3">Data Pengajuan Kelompok</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dinas</label>
                            <input type="text" class="form-control" value="{{ $data->dinas->nama_dinas }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Divisi</label>
                            <input type="text" class="form-control" value="{{ $data->divisi->nama_divisi ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" value="{{ $data->tanggal_mulai_magang }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" value="{{ $data->tanggal_akhir_magang }}" readonly>
                        </div>
                    </div>

                    <hr>
                    <h5 class="fw-bold mt-4 mb-3">Daftar Anggota ({{ $anggotaList->count() }} Orang)</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">NIS/NIM</th>
                                    <th scope="col">No HP Aktif</th>
                                    <th scope="col">Jurusan/Program Studi</th>
                                    <th scope="col">Asal Sekolah/Universitas</th>
                                    <th scope="col">Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggotaList as $index => $anggota)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $anggota->nama_lengkap }}</td>
                                        <td>{{ $anggota->nis_nim }}</td>
                                        <td>{{ $anggota->no_hp_aktif }}</td>
                                        <td>{{ $anggota->jurusan_program_studi }}</td>
                                        <td>{{ $anggota->asal_sekolah_universitas }}</td>
                                        <td>{{ $anggota->alamat }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <h5 class="fw-bold mt-4 mb-3">Dokumen Kelompok</h5>
                    @php
                        $surat = $data->dokumen->firstWhere('jenis_dokumen', 'surat_pengantar');
                        $cv = $data->dokumen->firstWhere('jenis_dokumen', 'cv');
                    @endphp
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Surat Pengantar</label><br>
                        @if ($surat)
                            <a href="{{ asset('storage/' . $surat->path_file) }}" target="_blank"
                                class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye me-1"></i> Lihat File
                                ({{ $surat->nama_file }})</a>
                        @else
                            <span class="text-muted">File tidak ditemukan.</span>
                        @endif
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Curriculum Vitae (CV)</label><br>
                        @if ($cv)
                            <a href="{{ asset('storage/' . $cv->path_file) }}" target="_blank"
                                class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye me-1"></i> Lihat
                                File ({{ $cv->nama_file }})</a>
                        @else
                            <span class="text-muted">File tidak ditemukan.</span>
                        @endif
                    </div>
                    {{-- ======================================================= --}}
                    {{-- ^^^ AKHIR DARI BLOK BARU ^^^ --}}
                    {{-- ======================================================= --}}

                    {{-- 
                ============================================================
                AWAL LOGIKA PEMISAH TAMPILAN
                ============================================================
                --}}
                @elseif ($loopCount == 1)
                    {{-- 
                    ============================================================
                    TAMPILAN UNTUK INDIVIDU (atau Mode Show)
                    Sesuai gambar 1: Semua field digabung dalam satu grup.
                    ============================================================
                    --}}

                    <h5 class="fw-bold mt-4 mb-3">
                        @if (isset($mode) && $mode == 'show')
                            Detail Pendaftar
                        @else
                        @endif
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap_1" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap[]"
                                value="{{ old('nama_lengkap.0', $data->nama_lengkap ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('nama_lengkap.0')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nis_nim_1" class="form-label">NIS/NIM</label>
                            <input type="text" class="form-control" name="nis_nim[]"
                                value="{{ old('nis_nim.0', $data->nis_nim ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('nis_nim.0')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp_aktif_1" class="form-label">No HP Aktif</label>
                            <input type="tel" class="form-control" name="no_hp_aktif[]"
                                value="{{ old('no_hp_aktif.0', $data->no_hp_aktif ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('no_hp_aktif.0')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jurusan_program_studi_1" class="form-label">Jurusan/Program Studi</label>
                            <input type="text" class="form-control" name="jurusan_program_studi[]"
                                value="{{ old('jurusan_program_studi.0', $data->jurusan_program_studi ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('jurusan_program_studi.0')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="asal_sekolah_universitas_1" class="form-label">Asal Sekolah/Universitas</label>
                            <input type="text" class="form-control" name="asal_sekolah_universitas[]"
                                value="{{ old('asal_sekolah_universitas.0', $data->asal_sekolah_universitas ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('asal_sekolah_universitas.0')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="alamat_1" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat[]" rows="2" @if (isset($mode) && $mode == 'show') readonly @endif
                                required>{{ old('alamat.0', $data->alamat ?? '') }}</textarea>
                            @error('alamat.0')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="id_divisi" class="form-label">Divisi yang Dipilih</label>
                            <select class="form-select" name="id_divisi"
                                @if (isset($mode) && $mode == 'show') disabled @endif required>
                                @foreach ($divisiList as $divisi)
                                    <option value="{{ $divisi->id_divisi }}"
                                        @if (isset($data) && $data->id_divisi == $divisi->id_divisi) selected @endif>
                                        {{ $divisi->nama_divisi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_divisi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dokumen (Link atau Input) --}}
                        @if (isset($mode) && $mode == 'show')
                            @php
                                $surat = $data->dokumen->firstWhere('jenis_dokumen', 'surat_pengantar');
                                $cv = $data->dokumen->firstWhere('jenis_dokumen', 'cv');
                            @endphp
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Surat Pengantar</label><br>
                                @if ($surat)
                                    <a href="{{ asset('storage/' . $surat->path_file) }}" target="_blank"
                                        class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye me-1"></i> Lihat
                                        File
                                        ({{ $surat->nama_file }})</a>
                                @else
                                    <span class="text-muted">File tidak ditemukan.</span>
                                @endif
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Curriculum Vitae (CV)</label><br>
                                @if ($cv)
                                    <a href="{{ asset('storage/' . $cv->path_file) }}" target="_blank"
                                        class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye me-1"></i> Lihat
                                        File ({{ $cv->nama_file }})</a>
                                @else
                                    <span class="text-muted">File tidak ditemukan.</span>
                                @endif
                            </div>
                        @else
                            <div class="col-12">
                                <label for="surat_pengantar" class="form-label">Surat Pengantar</label>
                                <input class="form-control @error('surat_pengantar') is-invalid @enderror" type="file"
                                    name="surat_pengantar" required>
                                <div class="form-text">Format yang diterima: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                                @error('surat_pengantar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                                <input class="form-control @error('cv') is-invalid @enderror" type="file"
                                    name="cv" required>
                                <div class="form-text">Format yang diterima: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                                @error('cv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="col-md-6">
                            <label for="tanggal_mulai_magang" class="form-label">Tanggal Mulai Magang</label>
                            <input type="date" class="form-control" name="tanggal_mulai_magang"
                                value="{{ old('tanggal_mulai_magang', $data->tanggal_mulai_magang ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('tanggal_mulai_magang')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_akhir_magang" class="form-label">Tanggal Akhir Magang</label>
                            <input type="date" class="form-control" name="tanggal_akhir_magang"
                                value="{{ old('tanggal_akhir_magang', $data->tanggal_akhir_magang ?? '') }}"
                                @if (isset($mode) && $mode == 'show') readonly @endif required>
                            @error('tanggal_akhir_magang')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @else
                    {{-- 
                    ============================================================
                    TAMPILAN UNTUK KELOMPOK
                    Sesuai gambar 2: Form anggota diulang, data kelompok di bawah.
                    ============================================================
                    --}}

                    @for ($i = 1; $i <= $loopCount; $i++)
                        <div class="anggota-form" id="form-anggota-{{ $i }}">
                            <hr>
                            <h5 class="fw-bold mt-4 mb-3">Data Anggota {{ $i }}
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_lengkap_{{ $i }}" class="form-label">Nama
                                        Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap[]"
                                        value="{{ old('nama_lengkap.' . ($i - 1)) }}" required>
                                    @error('nama_lengkap.' . ($i - 1))
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nis_nim_{{ $i }}" class="form-label">NIS/NIM</label>
                                    <input type="text" class="form-control" name="nis_nim[]"
                                        value="{{ old('nis_nim.' . ($i - 1)) }}" required>
                                    @error('nis_nim.' . ($i - 1))
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="no_hp_aktif_{{ $i }}" class="form-label">No HP
                                        Aktif</label>
                                    <input type="tel" class="form-control" name="no_hp_aktif[]"
                                        value="{{ old('no_hp_aktif.' . ($i - 1)) }}" required>
                                    @error('no_hp_aktif.' . ($i - 1))
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="jurusan_program_studi_{{ $i }}"
                                        class="form-label">Jurusan/Program Studi</label>
                                    <input type="text" class="form-control" name="jurusan_program_studi[]"
                                        value="{{ old('jurusan_program_studi.' . ($i - 1)) }}" required>
                                    @error('jurusan_program_studi.' . ($i - 1))
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="asal_sekolah_universitas_{{ $i }}" class="form-label">Asal
                                        Sekolah/Universitas</label>
                                    <input type="text" class="form-control" name="asal_sekolah_universitas[]"
                                        value="{{ old('asal_sekolah_universitas.' . ($i - 1)) }}" required>
                                    @error('asal_sekolah_universitas.' . ($i - 1))
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="alamat_{{ $i }}" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat[]" rows="2" required>{{ old('alamat.' . ($i - 1)) }}</textarea>
                                    @error('alamat.' . ($i - 1))
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Divisi hanya untuk anggota 1 --}}
                                @if ($i == 1)
                                    <div class="col-12">
                                        <label for="id_divisi" class="form-label">Divisi yang Dipilih (untuk
                                            Kelompok)</label>
                                        <select class="form-select" name="id_divisi" required>
                                            @foreach ($divisiList as $divisi)
                                                <option value="{{ $divisi->id_divisi }}"
                                                    @if (old('id_divisi') == $divisi->id_divisi) selected @endif>
                                                    {{ $divisi->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_divisi')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endfor

                    {{-- Data Kelompok (Tanggal & File) dipisah di luar loop --}}
                    <hr>
                    <h5 class="fw-bold mt-4 mb-3">Data Kelompok</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="surat_pengantar" class="form-label">Surat Pengantar </label>
                            <input class="form-control @error('surat_pengantar') is-invalid @enderror" type="file"
                                name="surat_pengantar" required>
                            <div class="form-text">Format yang diterima: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                            @error('surat_pengantar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="cv" class="form-label">Curriculum Vitae (CV) </label>
                            <input class="form-control @error('cv') is-invalid @enderror" type="file" name="cv"
                                required>
                            <div class="form-text">Format yang diterima: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                            @error('cv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_mulai_magang" class="form-label">Tanggal Mulai Magang</label>
                            <input type="date" class="form-control" name="tanggal_mulai_magang"
                                value="{{ old('tanggal_mulai_magang') }}" required>
                            @error('tanggal_mulai_magang')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_akhir_magang" class="form-label">Tanggal Akhir Magang</label>
                            <input type="date" class="form-control" name="tanggal_akhir_magang"
                                value="{{ old('tanggal_akhir_magang') }}" required>
                            @error('tanggal_akhir_magang')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif
                {{-- 
                ============================================================
                AKHIR LOGIKA PEMISAH TAMPILAN
                ============================================================
                --}}


                {{-- Tombol submit --}}
                @if (!isset($mode) || $mode != 'show')
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan & Ajukan Permintaan
                            Magang</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Skrip ini tidak perlu diubah, sudah benar untuk kedua layout --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isReadOnly = document.body.contains(document.querySelector('input[readonly]'));
            if (!isReadOnly) {
                const anggotaForms = document.querySelectorAll('.anggota-form');
                anggotaForms.forEach(form => {
                    const inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        if (input.type !== 'hidden') {
                            if (input.name === 'id_divisi' && form.id !== 'form-anggota-1') {
                                // jangan lakukan apa-apa
                            } else {
                                input.required = true;
                            }
                        }
                    });
                });
            }
        });
    </script>
@endpush
