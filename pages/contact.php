<!-- Original contact data ($profile->kontak) fully preserved -->
<div class="pv-page-wrap" style="max-width:680px;">
    <p class="pv-label">Kontak</p>
    <h1 class="pv-page-title">Hubungi <span>Kami</span></h1>

    <div class="card mb-3">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-sm-12 mb-2">
                    <div style="font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--pv-fg3);margin-bottom:.4rem;">Alamat Kantor</div>
                    <p style="font-size:13px;color:var(--pv-fg2);margin:0;"><?= $profile->kontak['alamat'] ?></p>
                </div>
                <div class="col-sm-6">
                    <div style="font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--pv-fg3);margin-bottom:.4rem;">Email</div>
                    <p style="font-size:13px;color:var(--pv-fg2);margin:0;"><?= $profile->kontak['email'] ?></p>
                </div>
                <div class="col-sm-6">
                    <div style="font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--pv-fg3);margin-bottom:.4rem;">Telepon / WhatsApp</div>
                    <p style="font-size:13px;color:var(--pv-fg2);margin:0;"><?= $profile->kontak['telepon'] ?></p>
                </div>
            </div>
            <div class="mt-4">
                <a href="https://wa.me/<?= $profile->kontak['whatsapp'] ?>" class="pv-btn">
                    <i class="ti ti-brand-whatsapp"></i> Chat via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
