@extends('layouts.app')

@section('title', 'Daftar')

@push('styles')
    <style>
        /* Mengatur body dan latar belakang */
        body {
            background: linear-gradient(rgba(26, 41, 86, 0.8), rgba(34, 51, 102, 0.8)),
                url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Wrapper untuk menengahkan kartu */
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }

        /* Styling untuk kartu daftar */
        .register-card {
            width: 100%;
            max-width: 500px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 50px;
        }

        .register-card .logo {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .register-card h2 {
            font-weight: 700;
        }

        .login-link a {
            font-size: 0.9rem;
            text-decoration: none;
        }

        /* Styling untuk tombol lihat password */
        .input-group .btn-outline-secondary {
            cursor: pointer;
            background-color: transparent;
            border: 1px solid #dee2e6;
            border-left: none;
            color: #495057;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .btn-outline-secondary:focus {
            box-shadow: none;
        }

        /* Styling untuk semua input field saat di-klik (fokus) */
        .form-control:focus {
            border-color: #dee2e6;
            box-shadow: none;
        }

        .input-group>.form-control:focus {
            z-index: 5;
        }
    </style>
@endpush
@section('content')

    <div class="register-wrapper">
        <div class="register-card text-center">

            <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo">

            <h2>Daftar</h2>
            <p class="text-muted">Buat akun baru untuk mendaftar magang</p>

            <form method="POST" action="{{ route('daftar') }}" class="text-start mt-4">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Aktif</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                            <i class="fas fa-eye" id="toggleIconConfirmation"></i>
                        </button>
                    </div>
                </div>

                <div class="text-end mb-4">
                    <div class="login-link">
                        <a href="{{ route('login') }}">Sudah terdaftar?</a>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function setupPasswordToggle(toggleButtonId, passwordInputId, toggleIconId) {
        const toggleButton = document.querySelector(toggleButtonId);
        const passwordInput = document.querySelector(passwordInputId);
        const toggleIcon = document.querySelector(toggleIconId);

        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'password') {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });
        }
    }

    // Setup untuk input password utama
    setupPasswordToggle('#togglePassword', '#password', '#toggleIcon');

    // Setup untuk input konfirmasi password
    setupPasswordToggle('#togglePasswordConfirmation', '#password_confirmation', '#toggleIconConfirmation');
</script>
@endpush
