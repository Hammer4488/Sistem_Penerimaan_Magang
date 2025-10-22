        @extends('layouts.app')

        @section('title', 'Formulir Pengajuan Magang')

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
            </style>
        @endpush

        @section('content')
            <div class="container py-4">
                <div class="form-container">
                    <div class="d-flex justify-content-start mb-3">
                        <a href="{{ route('ajukanpelamar') }}" class="back-arrow">←</a>
                    </div>

                    <div class="text-center mb-4">
                        <span class="form-header-icon">⬆️</span>
                        <h3 class="fw-bold mt-3">Formulir Peserta Magang</h3>
                        <p class="text-muted">Daftar untuk mengikuti program magang di Pemerintah Kota</p>
                    </div>

                    <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Menampilkan pesan error umum (jika ada) --}}
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                       
                        <input type="hidden" name="id_dinas" value="{{ $dinas->id_dinas }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nis_nim" class="form-label">NIS/NIM</label>
                                <input type="text" class="form-control @error('nis_nim') is-invalid @enderror"
                                    id="nis_nim" name="nis_nim" value="{{ old('nis_nim') }}" required>
                                @error('nis/nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">No HP Aktif</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp_aktif" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jurusan_program_studi" class="form-label">Jurusan/Program Studi</label>
                                <input type="text" class="form-control" id="jurusan_program_studi" name="jurusan_program_studi" required>
                            </div>
                            <div class="col-12">
                                <label for="asal_sekolah_universitas" class="form-label">Asal Sekolah/Universitas</label>
                                <input type="text" class="form-control" id="asal_sekolah_universitas" name="asal_sekolah_universitas" required>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                            </div>
                            <div class="col-12">
                                <label for="id_divisi" class="form-label">Pilih Divisi</label>
                                <select class="form-select @error('id_divisi') is-invalid @enderror" id="id_divisi"
                                    name="id_divisi" required>
                                    <option selected disabled value="">-- Pilih Divisi yang Tersedia --</option>
                                    @foreach ($divisiList as $divisi)
                                        {{-- UBAH 'value' DI BAWAH INI --}}
                                        <option value="{{ $divisi->id_divisi }}"
                                            {{ old('id_divisi') == $divisi->id_divisi ? 'selected' : '' }}>
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
                                <input type="date" class="form-control" id="tanggal_mulai_magang" name="tanggal_mulai_magang" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_akhir_magang" class="form-label">Tanggal Akhir Magang</label>
                                <input type="date" class="form-control" id="tanggal_akhir_magang" name="tanggal_akhir_magang"
                                    required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan & Ajukan Permintaan
                                Magang</button>
                        </div>
                    </form>
                </div>
            </div>
        @endsection
