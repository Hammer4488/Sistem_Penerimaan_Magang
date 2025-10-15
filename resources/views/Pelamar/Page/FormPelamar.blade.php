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

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nim_nis" class="form-label">NIM/NIS</label>
                            <input type="text" class="form-control" id="nim_nis" name="nim_nis" required>
                        </div>

                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">No HP Aktif</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp_aktif" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jurusan" class="form-label">Jurusan/Program Studi</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                        </div>
                        <div class="col-12">
                            <label for="asal_sekolah" class="form-label">Asal Sekolah/Universitas</label>
                            <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" required>
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                        </div>
                        <div class="col-12">
                            <label for="pilih_divisi" class="form-label">Pilih Divisi</label>
                            <select class="form-select" id="pilih_divisi" name="id_dinas" required>
                                <option selected disabled value="">Pilih...</option>
                                {{-- Data dinas akan di-loop di sini --}}
                                <option value="1">Programmer</option>
                                <option value="2">Jaringan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="surat_pengantar" class="form-label">Surat Pengantar dari Sekolah/Universitas</label>
                            <input class="form-control" type="file" id="surat_pengantar" name="surat_pengantar" required>
                            <div class="form-text">Format yang diterima: JPG, PNG, PDF (Maksimal 2MB)</div>
                        </div>
                        <div class="col-12">
                            <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                            <input class="form-control" type="file" id="cv" name="cv" required>
                            <div class="form-text">Format yang diterima: JPG, PNG, PDF (Maksimal 2MB)</div>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Magang</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir Magang</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan & Ajukan Permintaan Magang</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
