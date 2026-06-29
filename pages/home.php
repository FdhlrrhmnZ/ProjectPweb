<?php
require_once 'class/class.product.php';
$productObj = new Product();
$featured_products = [$productObj->SelectAllProduct()];
?>

<!-- HERO -->
<section class="pv-hero">
    <div class="pv-hero-left">
        <p class="pv-hero-eyebrow">Debut Collection — 2025</p>
        <h1 class="pv-hero-title">Ride<br><em>in</em><br>Style.</h1>
        <p class="pv-hero-sub">
            <?= $profile->namaPerusahaan ?> crafts motorcycle blazers that move with you —
            on the road and through the city. Precision-made in Indonesia.
        </p>
        <div class="pv-hero-cta">
            <a href="index.php?page=catalog" class="pv-btn">Mulai Belanja <i class="ti ti-arrow-right"></i></a>
            <a href="index.php?page=about"   class="pv-btn-ghost">Pelajari Lebih Lanjut <i class="ti ti-arrow-right"></i></a>
        </div>
    </div>
    <div class="pv-hero-right">
        <span class="pv-hero-badge"><i class="ti ti-diamond" style="font-size:11px;vertical-align:-1px;"></i> Premium Moto Apparel</span>
        <div class="pv-hero-img-wrap">
            <!-- Replace with: <img src="assets/img/hero.jpg" alt="Pavana Blazer"> -->
            <div class="pv-hero-placeholder">
                <i class="ti ti-shirt"></i>
                <span>Campaign photo</span>
            </div>
        </div>
        <span class="pv-hero-origin">Handcrafted — Jakarta, Indonesia</span>
    </div>
</section>

<!-- MARQUEE -->
<div class="pv-marquee" aria-hidden="true">
    <div class="pv-marquee-track">
        <span>Premium Moto Apparel</span><span>•</span>
        <span>Handcrafted in Indonesia</span><span>•</span>
        <span>Road-Ready Blazers</span><span>•</span>
        <span>Debut Collection 2025</span><span>•</span>
        <span>Daily Lifestyle Wear</span><span>•</span>
        <span>Premium Moto Apparel</span><span>•</span>
        <span>Handcrafted in Indonesia</span><span>•</span>
        <span>Road-Ready Blazers</span><span>•</span>
        <span>Debut Collection 2025</span><span>•</span>
        <span>Daily Lifestyle Wear</span><span>•</span>
    </div>
</div>

<!-- PILLARS -->
<section class="pv-section">
    <div class="pv-label">Why <?= $profile->namaPerusahaan ?></div>
    <div class="pv-features">
        <div class="pv-feature">
            <div class="pv-feature-num">01</div>
            <div class="pv-feature-title">Road-Ready Build</div>
            <p class="pv-feature-desc">Abrasion-resistant outer shell engineered for real riding conditions.</p>
        </div>
        <div class="pv-feature">
            <div class="pv-feature-num">02</div>
            <div class="pv-feature-title">Blazer Silhouette</div>
            <p class="pv-feature-desc">Tailored cut that holds its structure on the bike and looks sharp off it.</p>
        </div>
        <div class="pv-feature">
            <div class="pv-feature-num">03</div>
            <div class="pv-feature-title">Made in Indonesia</div>
            <p class="pv-feature-desc">Every piece crafted locally with global quality standards.</p>
        </div>
    </div>
</section>

<div class="pv-divider"></div>

<!-- FEATURED PRODUCTS -->
<section class="pv-section">
    <div class="pv-label">The Collection</div>
    <div class="pv-products">
        <?php foreach ($featured_products as $p): ?>
        <div class="pv-product-card" onclick="window.location='index.php?page=catalog&slug=<?= urlencode($p['slug']) ?>'">
            <div class="pv-product-img">
                <?php if ($p['badge']): ?><span class="pv-product-badge"><?= $p['badge'] ?></span><?php endif; ?>
                <div class="pv-product-img-inner">
                    <!-- <img src="assets/img/products/<?= $p['slug'] ?>.jpg" alt="<?= htmlspecialchars($p['name']) ?>"> -->
                    <i class="ti ti-shirt"></i>
                </div>
            </div>
            <div class="pv-product-info">
                <div class="pv-product-name"><?= htmlspecialchars($p['name']) ?></div>
                <div class="pv-product-color"><?= htmlspecialchars($p['color']) ?></div>
                <div class="pv-product-price"><?= format_idr($p['price']) ?></div>
                <div class="pv-sizes" data-product="<?= $p['id'] ?>">
                    <?php foreach (['S','M','L','XL'] as $sz): ?>
                    <button class="pv-size-btn" onclick="selectSize(event,this)" data-size="<?= $sz ?>"><?= $sz ?></button>
                    <?php endforeach; ?>
                </div>
                <div class="pv-product-actions">
                    <button class="pv-btn" style="flex:1;justify-content:center;"
                        onclick="addToCart(event,<?= $p['id'] ?>,'<?= addslashes(htmlspecialchars($p['name'])) ?>')">
                        <i class="ti ti-shopping-cart-plus"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:3rem;">
        <a href="index.php?page=catalog" class="pv-btn-outline">Lihat Semua Produk <i class="ti ti-arrow-right"></i></a>
    </div>
</section>

<!-- STORY -->
<section style="padding-bottom:2px;">
    <div class="pv-story">
        <div class="pv-story-text">
            <div class="pv-label" style="margin-bottom:2rem;">The Brand</div>
            <h2 class="pv-story-title">Built for<br><span>the road,</span><br>worn for life.</h2>
            <p class="pv-story-body"><?= $profile->deskripsi ?></p>
            <a href="index.php?page=about" class="pv-btn" style="width:fit-content;">Our Story <i class="ti ti-arrow-right"></i></a>
        </div>
        <div class="pv-story-img">
            <!-- <img src="assets/img/brand-story.jpg" alt="Pavana"> -->
            <div class="pv-story-placeholder"><i class="ti ti-camera"></i><p>Brand / lookbook photo</p></div>
        </div>
    </div>
</section>

<!-- INSTAGRAM -->
<section class="pv-section" style="padding-bottom:0;">
    <div class="pv-label">Follow the Ride</div>
</section>
<div class="pv-social-grid">
    <?php for ($i=1;$i<=3;$i++): ?>
    <div class="pv-social-cell">
        <!-- <img src="assets/img/ig/post-<?= $i ?>.jpg" alt="Instagram post"> -->
        <i class="ti ti-photo"></i>
    </div>
    <?php endfor; ?>
    <div class="pv-social-cta">
        <i class="ti ti-brand-instagram" style="font-size:28px;color:var(--pv-gold);"></i>
        <div class="pv-social-handle">@pavana.id</div>
        <div class="pv-social-sub">Join the community</div>
        <a href="https://instagram.com/pavana.id" target="_blank" class="pv-btn-outline" style="font-size:10px;">Follow Us</a>
    </div>
</div>
