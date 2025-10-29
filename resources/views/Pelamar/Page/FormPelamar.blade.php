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

                input[readonly],
                textarea[readonly],
                select[disabled] {
                    background-color: #f8f9fa !important;
                    cursor: not-allowed;
                }

                /* Style untuk menyembunyikan form anggota tambahan */
                .anggota-tambahan {
                    display: none;
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
                        <a href="{{ isset($mode) && $mode == 'show' ? route('riwayatpelamar') : route('ajukanpelamar') }}"
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

                        {{-- Hanya tampil jika bukan mode 'show' --}}
                        @if (!isset($mode) || $mode != 'show')
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="jumlah_anggota" class="form-label fw-bold">Jumlah Anggota Kelompok</label>
                                    <select id="jumlah_anggota" name="jumlah_anggota" class="form-select">
                                        {{-- Opsi akan dipilih berdasarkan $jumlahAnggota dari controller --}}
                                        <option value="1" @if ($jumlahAnggota == 1) selected @endif>Sendiri (1
                                            Orang)</option>
                                        <option value="2" @if ($jumlahAnggota == 2) selected @endif>2 Orang
                                        </option>
                                        <option value="3" @if ($jumlahAnggota == 3) selected @endif>3 Orang
                                        </option>
                                        <option value="4" @if ($jumlahAnggota == 4) selected @endif>4 Orang
                                        </option>
                                    </select>
                                    <div class="form-text">Anda adalah ketua kelompok (Anggota 1).</div>
                                </div>
                            </div>
                        @endif

                        {{-- [MODIFIKASI] Looping untuk menampilkan form anggota --}}
                        @php
                            $loopCount = isset($mode) && $mode == 'show' ? 1 : $jumlahAnggota ?? 1;
                        @endphp

                        @for ($i = 1; $i <= $loopCount; $i++)
                            {{-- Tambahkan style="display: block" untuk anggota pertama --}}
                            <div class="anggota-form {{ $i > 1 ? 'anggota-tambahan' : '' }}"
                                id="form-anggota-{{ $i }}"
                                @if ($i == 1) style="display: block;" @endif>
                                <hr>
                                <h5 class="fw-bold mt-4 mb-3">
                                    @if (isset($mode) && $mode == 'show')
                                        Detail Pendaftar
                                    @elseif ($loopCount == 1)
                                        Data Pendaftar
                                    @else
                                        Data Anggota {{ $i }} {{ $i == 1 ? '(Ketua Kelompok)' : '' }}
                                    @endif
                                </h5>
                                <div class="row g-3">
                                    @php $data = ($i == 1 && isset($pendaftaran)) ? $pendaftaran : null; @endphp

                                    {{-- Nama Lengkap --}}
                                    <div class="col-md-6">
                                        <label for="nama_lengkap_{{ $i }}" class="form-label">Nama
                                            Lengkap</label>
                                        <input type="text" class="form-control" name="nama_lengkap[]"
                                            value="{{ old('nama_lengkap.' . ($i - 1), $data->nama_lengkap ?? '') }}"
                                            @if (isset($mode) && $mode == 'show') readonly @endif {{-- Required akan diatur JS --}}>
                                        @error('nama_lengkap.' . ($i - 1))
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- NIS/NIM --}}
                                    <div class="col-md-6">
                                        <label for="nis_nim_{{ $i }}" class="form-label">NIS/NIM</label>
                                        <input type="text" class="form-control" name="nis_nim[]"
                                            value="{{ old('nis_nim.' . ($i - 1), $data->nis_nim ?? '') }}"
                                            @if (isset($mode) && $mode == 'show') readonly @endif {{-- Required akan diatur JS --}}>
                                        @error('nis_nim.' . ($i - 1))
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- No HP --}}
                                    <div class="col-md-6">
                                        <label for="no_hp_aktif_{{ $i }}" class="form-label">No HP Aktif</label>
                                        <input type="tel" class="form-control" name="no_hp_aktif[]"
                                            value="{{ old('no_hp_aktif.' . ($i - 1), $data->no_hp_aktif ?? '') }}"
                                            @if (isset($mode) && $mode == 'show') readonly @endif {{-- Required akan diatur JS --}}>
                                        @error('no_hp_aktif.' . ($i - 1))
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- Jurusan --}}
                                    <div class="col-md-6">
                                        <label for="jurusan_program_studi_{{ $i }}"
                                            class="form-label">Jurusan/Program Studi</label>
                                        <input type="text" class="form-control" name="jurusan_program_studi[]"
                                            value="{{ old('jurusan_program_studi.' . ($i - 1), $data->jurusan_program_studi ?? '') }}"
                                            @if (isset($mode) && $mode == 'show') readonly @endif {{-- Required akan diatur JS --}}>
                                        @error('jurusan_program_studi.' . ($i - 1))
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- Asal Sekolah --}}
                                    <div class="col-12">
                                        <label for="asal_sekolah_universitas_{{ $i }}" class="form-label">Asal
                                            Sekolah/Universitas</label>
                                        <input type="text" class="form-control" name="asal_sekolah_universitas[]"
                                            value="{{ old('asal_sekolah_universitas.' . ($i - 1), $data->asal_sekolah_universitas ?? '') }}"
                                            @if (isset($mode) && $mode == 'show') readonly @endif {{-- Required akan diatur JS --}}>
                                        @error('asal_sekolah_universitas.' . ($i - 1))
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- Alamat --}}
                                    <div class="col-12">
                                        <label for="alamat_{{ $i }}" class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat[]" rows="2" @if (isset($mode) && $mode == 'show') readonly @endif
                                            {{-- Required akan diatur JS --}}>{{ old('alamat.' . ($i - 1), $data->alamat ?? '') }}</textarea>
                                        @error('alamat.' . ($i - 1))
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Divisi (Hanya untuk Anggota 1 atau mode Show) --}}
                                    @if ($i == 1 || (isset($mode) && $mode == 'show'))
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
                                    @endif
                                </div>
                            </div>
                        @endfor
                        {{-- Akhir Looping Form Anggota --}}

                        {{-- Pindahkan bagian Tanggal & File ke LUAR looping --}}
                        <hr>
                        <h5 class="fw-bold mt-4 mb-3">
                            {{ isset($mode) && $mode == 'show' ? 'Detail Lainnya' : 'Data Kelompok' }}</h5>
                        <div class="row g-3">
                            {{-- Tanggal Mulai --}}
                            <div class="col-md-6">
                                <label for="tanggal_mulai_magang" class="form-label">Tanggal Mulai Magang</label>
                                <input type="date" class="form-control" name="tanggal_mulai_magang"
                                    value="{{ old('tanggal_mulai_magang', $pendaftaran->tanggal_mulai_magang ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                                @error('tanggal_mulai_magang')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Tanggal Akhir --}}
                            <div class="col-md-6">
                                <label for="tanggal_akhir_magang" class="form-label">Tanggal Akhir Magang</label>
                                <input type="date" class="form-control" name="tanggal_akhir_magang"
                                    value="{{ old('tanggal_akhir_magang', $pendaftaran->tanggal_akhir_magang ?? '') }}"
                                    @if (isset($mode) && $mode == 'show') readonly @endif required>
                                @error('tanggal_akhir_magang')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dokumen (Link atau Input) --}}
                            @if (isset($mode) && $mode == 'show')
                                @php
                                    $surat = $pendaftaran->dokumen->firstWhere('jenis_dokumen', 'surat_pengantar');
                                    $cv = $pendaftaran->dokumen->firstWhere('jenis_dokumen', 'cv');
                                @endphp
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Surat Pengantar</label><br>
                                    @if ($surat)
                                        <a href="{{ asset('storage/' . $surat->path_file) }}" target="_blank"
                                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye me-1"></i> Lihat
                                            File ({{ $surat->nama_file }})</a>
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
                                    <input class="form-control @error('surat_pengantar') is-invalid @enderror"
                                        type="file" name="surat_pengantar" required>
                                    @error('surat_pengantar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: PDF, JPG, PNG (Maks. 2MB)</div>
                                </div>
                                <div class="col-12">
                                    <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                                    <input class="form-control @error('cv') is-invalid @enderror" type="file"
                                        name="cv" required>
                                    @error('cv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Format: PDF, JPG, PNG (Maks. 2MB)</div>
                                </div>
                            @endif
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
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selectJumlah = document.getElementById('jumlah_anggota');

                    // Fungsi untuk menampilkan/menyembunyikan form
                    function toggleAnggotaForms(jumlah) {
                        for (let i = 2; i <= 4; i++) {
                            const formAnggota = document.getElementById('form-anggota-' + i);
                            if (!formAnggota) continue; // Lanjut jika form tidak ada

                            const inputs = formAnggota.querySelectorAll('input, select, textarea');

                            if (i <= jumlah) {
                                formAnggota.style.display = 'block';
                                // Hanya wajibkan jika mode BUKAN 'show'
                                if (!document.body.contains(document.querySelector('input[readonly]'))) {
                                    inputs.forEach(input => input.required = true);
                                }
                            } else {
                                formAnggota.style.display = 'none';
                                inputs.forEach(input => {
                                    input.required = false; // Hapus required
                                    input.value = ''; // Kosongkan nilai jika disembunyikan
                                });
                            }
                        }
                    }

                    // Jika dropdown jumlah anggota ada (mode create)
                    if (selectJumlah) {
                        // Panggil fungsi saat halaman load sesuai pilihan awal
                        toggleAnggotaForms(parseInt(selectJumlah.value));

                        // Panggil fungsi saat pilihan dropdown berubah
                        selectJumlah.addEventListener('change', function() {
                            toggleAnggotaForms(parseInt(this.value));
                        });
                    }
                    // Jika mode show (dropdown tidak ada), pastikan hanya form pertama tampil
                    else {
                        for (let i = 2; i <= 4; i++) {
                            const formAnggota = document.getElementById('form-anggota-' + i);
                            if (formAnggota) formAnggota.style.display = 'none';
                        }
                    }
                });
            </script>
        @endpush
