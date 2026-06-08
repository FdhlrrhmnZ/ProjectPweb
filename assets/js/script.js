/**
 * script.js — Pavana Front-End Interactions
 * All JS lives here. No inline scripts in PHP files.
 */

/* ── THEME TOGGLE ───────────────────────────────
   Reads/writes localStorage so the chosen theme
   persists across every page in the site.
─────────────────────────────────────────────── */
const htmlRoot   = document.getElementById('html-root');
const themeIcon  = document.getElementById('themeIcon');
const themeLabel = document.getElementById('themeLabel');

function toggleTheme() {
    const isDark = htmlRoot.getAttribute('data-bs-theme') === 'dark';
    if (isDark) {
        htmlRoot.setAttribute('data-bs-theme', 'light');
        if (themeIcon)  themeIcon.className  = 'ti ti-sun';
        if (themeLabel) themeLabel.textContent = 'Dark';
        localStorage.setItem('pvTheme', 'light');
    } else {
        htmlRoot.setAttribute('data-bs-theme', 'dark');
        if (themeIcon)  themeIcon.className  = 'ti ti-moon';
        if (themeLabel) themeLabel.textContent = 'Light';
        localStorage.setItem('pvTheme', 'dark');
    }
}

// Apply saved theme immediately on page load (prevents flash)
(function () {
    if (localStorage.getItem('pvTheme') === 'light') {
        htmlRoot && htmlRoot.setAttribute('data-bs-theme', 'light');
        if (themeIcon)  themeIcon.className  = 'ti ti-sun';
        if (themeLabel) themeLabel.textContent = 'Dark';
    }
})();

/* ── SIZE SELECTION ─────────────────────────────
   Used on product cards. stopPropagation prevents
   the card's onclick from navigating away.
─────────────────────────────────────────────── */
function selectSize(e, btn) {
    e.stopPropagation();
    const group = btn.closest('.pv-sizes');
    group.querySelectorAll('.pv-size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

/* ── ADD TO CART ────────────────────────────────
   POSTs to cart_add.php (to be built) via fetch.
   Expected response: { success, cart_count, message }
─────────────────────────────────────────────── */
function addToCart(e, productId, productName) {
    e.stopPropagation();

    const sizeGroup  = document.querySelector(`.pv-sizes[data-product="${productId}"]`);
    const activeSize = sizeGroup ? sizeGroup.querySelector('.pv-size-btn.active') : null;

    if (!activeSize) {
        showToast('Pilih ukuran terlebih dahulu.', 'ti-alert-circle');
        return;
    }

    fetch('cart_add.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, size: activeSize.dataset.size, qty: 1 })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(`${productName} (${activeSize.dataset.size}) ditambahkan.`);
            updateCartBadge(data.cart_count);
        } else {
            showToast(data.message || 'Terjadi kesalahan.', 'ti-alert-circle');
        }
    })
    .catch(() => showToast('Koneksi gagal. Coba lagi.', 'ti-alert-circle'));
}

function updateCartBadge(count) {
    let badge = document.querySelector('.pv-cart-badge');
    if (count > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'pv-cart-badge';
            document.querySelector('.pv-cart-btn')?.appendChild(badge);
        }
        badge.textContent = count;
    } else if (badge) {
        badge.remove();
    }
}

/* ── TOAST ──────────────────────────────────────
   Shows a small bottom-right notification for 3s.
─────────────────────────────────────────────── */
let _toastTimer;
function showToast(msg, icon = 'ti-check') {
    const toast = document.getElementById('pvToast');
    if (!toast) return;
    toast.querySelector('i').className = `ti ${icon}`;
    document.getElementById('pvToastMsg').textContent = msg;
    toast.classList.add('show');
    clearTimeout(_toastTimer);
    _toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}
