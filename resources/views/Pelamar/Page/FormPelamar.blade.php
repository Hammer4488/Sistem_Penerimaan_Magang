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
                    /* Atur lebar maksimal form */
                    margin: 40px auto;
                    /* Posisikan di tengah halaman */
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
                    <div class="d-flex justify-content-start mb-3">
                        <a href="{{ isset($mode) && $mode == 'show' ? route('statuspelamar') : route('ajukanpelamar') }}"
                            class="back-arrow">←</a>
                    </div>

                    <div class="text-center mb-4">
                        <span class="form-header-icon">{!! isset($mode) && $mode == 'show' ? '📄' : '⬆️' !!}</span>
                        <h3 class="fw-bold mt-3">
                            {{ isset($mode) && $mode == 'show' ? 'Detail Formulir Pendaftaran' : 'Formulir Peserta Magang' }}
                        </h3>
                        <p class="text-muted">
                            {{ isset($mode) && $mode == 'show' ? 'Berikut adalah data yang telah Anda ajukan.' : 'Daftar untuk mengikuti program magang di Pemerintah Kota' }}
                        </p>
                    </div>

                    <form action="{{ isset($mode) && $mode == 'show' ? '#' : route('pendaftaran.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @if (!isset($mode) || $mode != 'show')
                            @csrf
                        @endif

                        {{-- Menampilkan pesan error umum (jika ada) --}}
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <input type="hidden" name="id_dinas" value="{{ $dinas->id_dinas ?? $pendaftaran->id_dinas }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nis_nim" class="form-label">NIS/NIM</label>
                                <input type="text" class="form-control" name="nis_nim"
                                    value="{{ old('nis_nim', $pendaftaran->nis_nim ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                                @error('nis/nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">No HP Aktif</label>
                                <input type="tel" class="form-control" name="no_hp_aktif"
                                    value="{{ old('no_hp_aktif', $pendaftaran->no_hp_aktif ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                            </div>
                            <div class="col-md-6">
                                <label for="jurusan_program_studi" class="form-label">Jurusan/Program Studi</label>
                                <input type="text" class="form-control" name="jurusan_program_studi"
                                    value="{{ old('jurusan_program_studi', $pendaftaran->jurusan_program_studi ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                            </div>
                            <div class="col-12">
                                <label for="asal_sekolah_universitas" class="form-label">Asal Sekolah/Universitas</label>
                                <input type="text" class="form-control" name="asal_sekolah_universitas"
                                    value="{{ old('asal_sekolah_universitas', $pendaftaran->asal_sekolah_universitas ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2" @if (isset($mode) && $mode == 'show') readonly @endif required>{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="id_divisi" class="form-label">Pilih Divisi</label>
                                <select class="form-select" name="id_divisi"
                                    @if (isset($mode) && $mode == 'show') disabled @endif required>
                                    @foreach ($divisiList as $divisi)
                                        <option value="{{ $divisi->id_divisi }}"
                                            @if (isset($pendaftaran) && $pendaftaran->id_divisi == $divisi->id_divisi) selected @endif>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_divisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="surat_pengantar" class="form-label">Surat Pengantar dari
                                    Sekolah/Universitas</label>
                                <input class="form-control" type="file" id="surat_pengantar" name="surat_pengantar"
                                    required>
                                <div class="form-text">Format yang diterima: JPG, PNG, PDF (Maksimal 2MB)</div>
                            </div>
                            <div class="col-12">
                                <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                                <input class="form-control" type="file" id="cv" name="cv" required>
                                <div class="form-text">Format yang diterima: JPG, PNG, PDF (Maksimal 2MB)</div>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_mulai_magang" class="form-label">Tanggal Mulai Magang</label>
                                <input type="date" class="form-control" name="tanggal_mulai_magang"
                                    value="{{ old('tanggal_mulai_magang', $pendaftaran->tanggal_mulai_magang ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_akhir_magang" class="form-label">Tanggal Akhir Magang</label>
                                <input type="date" class="form-control" name="tanggal_akhir_magang"
                                    value="{{ old('tanggal_akhir_magang', $pendaftaran->tanggal_akhir_magang ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                            </div>
                        </div>

                        {{-- <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan & Ajukan Permintaan
                                Magang</button>
                        </div> --}}
                        {{-- Tombol submit disembunyikan saat mode 'show' --}}
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
