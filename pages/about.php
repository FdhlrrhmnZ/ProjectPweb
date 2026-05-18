<div class="text-center mb-5">
    <h2 class="fw-bold display-6">Tentang Kami</h2>
    <p class="text-muted">Mengenal lebih dekat perjalanan dan tujuan <?= $profile->namaPerusahaan; ?></p>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title fw-bold text-primary mb-3">Visi Perusahaan</h4>
                <p class="card-text fs-5"><?= $profile->visi; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title fw-bold text-primary mb-3">Misi Perusahaan</h4>
                <ul class="list-group list-group-flush">
                    <?php foreach($profile->misi as $item): ?>
                        <li class="list-group-item bg-transparent fs-5 border-0 px-0 mb-2">
                            &#10003; <?= $item; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>