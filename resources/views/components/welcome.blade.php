<style>
    .welcome-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid #dee2e6;
        /* Menambahkan garis batas tipis */
        box-shadow: none;
        /* Menghapus efek bayangan */
    }
</style>


<div>
    <div class="flow-card welcome-card mb-4">
        <h4 class="mb-1">Selamat Datang, {{ $user->name }}!</h4>
        <p class="text-muted mb-0">Kelola pendaftaran magang anda di Pemerintah Kota Banjarmasin</p>
    </div>
</div>
