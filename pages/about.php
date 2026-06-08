<!-- Pavana About — original data ($profile->visi, $profile->misi) fully preserved -->
<div class="pv-page-wrap">
    <p class="pv-label">Tentang Kami</p>
    <h1 class="pv-page-title">Mengenal <span><?= $profile->namaPerusahaan ?></span></h1>
    <p style="font-size:14px;color:var(--pv-fg2);max-width:560px;line-height:2;margin-bottom:3rem;">
        <?= $profile->deskripsi ?>
    </p>

    <div class="row g-2">
        <div class="col-md-6">
            <div class="card p-0">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3" style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:300;">
                        <span style="color:var(--pv-gold);">Visi</span> Perusahaan
                    </h4>
                    <p class="card-text" style="font-size:13px;line-height:2;"><?= $profile->visi ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-0">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3" style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:300;">
                        <span style="color:var(--pv-gold);">Misi</span> Perusahaan
                    </h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.8rem;">
                        <?php foreach ($profile->misi as $item): ?>
                        <li style="font-size:13px;color:var(--pv-fg2);display:flex;gap:10px;align-items:flex-start;line-height:1.8;">
                            <i class="ti ti-check" style="color:var(--pv-gold);margin-top:3px;flex-shrink:0;"></i>
                            <?= $item ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
