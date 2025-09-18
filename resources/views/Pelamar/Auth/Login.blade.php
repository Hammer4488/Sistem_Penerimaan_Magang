<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Mengatur body dan latar belakang */
        body {
            background: linear-gradient(rgba(26, 41, 86, 0.8), rgba(34, 51, 102, 0.8)),
            url('{{ asset("image/background.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Wrapper untuk menengahkan kartu login */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Styling untuk kartu login */
        .login-card {
            width: 100%;
            max-width: 500px;
            /* Dipersempit agar lebih ramping */
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 50px;
            /* Padding diubah agar lebih seimbang */
        }

        .login-card .logo {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .login-card h2 {
            font-weight: 700;
        }

        .form-control:focus {
            border-color: #dee2e6;
            /* Ubah warna border saat fokus menjadi abu-abu */
            box-shadow: none;
            /* Hapus efek bayangan (box-shadow) */
        }

        .forgot-password a,
        .register-link a {
            font-size: 0.9rem;
            text-decoration: none;
        }

        /* ... CSS Anda yang sudah ada ... */
        #togglePassword {
            cursor: pointer;
        }

        /* ... CSS Anda yang sudah ada ... */
        .input-group .btn-outline-secondary {
            background-color: transparent;
            border-color: #dee2e6;
            border-left: none;
            /* TAMBAHKAN BARIS INI */
            color: #495057;
        }

        .input-group .btn-outline-secondary:hover {
            background-color: rgba(0, 0, 0, 0.05);
            /* Sedikit efek hover transparan */
            border-color: #dee2e6;
            color: #495057;
        }


        /* Opsional: Memastikan border kanan input tetap rapi saat fokus */
        .input-group>.form-control:focus {
            z-index: 5;
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

        .input-group .btn-outline-secondary:hover,
        .input-group .btn-outline-secondary:active {
            background-color: transparent !important;
            border: 1px solid #dee2e6;
            border-left: none;
            color: #495057;
            box-shadow: none !important;
        }

        .input-group .btn-outline-secondary:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card text-center">

            <img src="{{ asset('image/LOGO-PEMKOT-BARU.png') }}" alt="Logo" class="logo">

            <h2>Login</h2>
            <p class="text-muted">Masuk ke akun anda</p>

            <form method="POST" action="{{ route('login') }}" class="text-start mt-4">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="register-link">
                        <a href="{{ route('daftar') }}">Daftar disini</a>
                    </div>
                    <div class="forgot-password">
                        <a href="#">Lupa password?</a>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>

        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</div>
</div>

<script>
    // Pilih elemen tombol dan input password dari dokumen
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const toggleIcon = document.querySelector('#toggleIcon');

    // Tambahkan event listener untuk 'click' pada tombol
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            // Cek tipe dari input password
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata
            if (type === 'password') {
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        });
    }
</script>

</body>

</html>

</html>