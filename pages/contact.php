<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4 text-center">Hubungi Kami</h2>
                <div class="mb-4">
                    <h5 class="fw-bold">Alamat Kantor</h5>
                    <p class="text-muted"><?= $profile->kontak['alamat']; ?></p>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h5 class="fw-bold">Email</h5>
                        <p class="text-muted"><?= $profile->kontak['email']; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <h5 class="fw-bold">Telepon / WhatsApp</h5>
                        <p class="text-muted"><?= $profile->kontak['telepon']; ?></p>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="https://wa.me/<?= $profile->kontak['whatsapp']; ?>" class="btn btn-success btn-lg px-5">
                        Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>