<div class="row align-items-center mb-5">
    <div class="col-lg-6 mb-4 mb-lg-0">
        <h1 class="display-4 fw-bold text-dark">Selamat Datang di <?= $profile->namaPerusahaan; ?></h1>
        <p class="lead text-secondary"><?= $profile->deskripsi; ?></p>
        <div class="d-flex gap-3 mt-4">
            <a href="index.php?page=catalog" class="btn btn-primary btn-lg px-4">Mulai Belanja</a>
            <a href="index.php?page=about" class="btn btn-outline-secondary btn-lg px-4">Pelajari Lebih Lanjut</a>
        </div>
    </div>
    <div class="col-lg-6 text-center">
        <!-- Gunakan class img-fluid agar gambar responsif di HP -->
        <img src="https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=800" alt="Hero Image" class="img-fluid rounded shadow-lg">
    </div>
</div>