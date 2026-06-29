<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 1. Proses Hapus Item dari Keranjang
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id_remove = $_GET['id'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['productid'] == $id_remove) {
            unset($_SESSION['cart'][$key]);
        }
    }
    // Re-index array setelah dihapus
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    echo "<script>window.location.href='index.php?page=cart';</script>";
    exit;
}

// 2. Proses Update Kuantitas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $productid => $new_qty) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['productid'] == $productid) {
                    // Pastikan kuantitas minimal 1
                    $_SESSION['cart'][$key]['qty'] = max(1, intval($new_qty));
                }
            }
        }
    }
    echo "<script>window.location.href='index.php?page=cart';</script>";
    exit;
}
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Keranjang <span class="text-primary">Belanja</span></h2>
    </div>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info text-center p-5 shadow-sm rounded">
            <i class="ti ti-shopping-cart fs-1 text-secondary mb-3 d-block"></i>
            <h4 class="fw-bold">Keranjang Anda masih kosong!</h4>
            <p class="mb-4">Yuk, cari produk menarik di katalog kami.</p>
            <a href="index.php?page=catalog" class="btn btn-primary btn-lg px-4 rounded-pill">
                Belanja Sekarang
            </a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <form action="index.php?page=cart" method="POST">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th class="text-start ps-3">Nama Produk</th>
                                    <th>Harga Satuan</th>
                                    <th width="150px">Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $grand_total = 0;
                                foreach ($_SESSION['cart'] as $item):
                                    $subtotal = $item['price'] * $item['qty'];
                                    $grand_total += $subtotal;
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-start ps-3 fw-medium"><?= htmlspecialchars($item['productname']) ?></td>
                                    <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <input type="number" name="qty[<?= $item['productid'] ?>]" class="form-control text-center" value="<?= $item['qty'] ?>" min="1">
                                    </td>
                                    <td class="fw-bold text-success">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    <td>
                                        <a href="index.php?page=cart&action=remove&id=<?= $item['productid'] ?>" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Hapus produk ini dari keranjang?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="4" class="text-end py-3">Total Belanja:</th>
                                    <th class="fw-bold text-success fs-5 py-3">Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="card-footer bg-white d-flex justify-content-between p-3 border-top-0">
                        <a href="index.php?page=catalog" class="btn btn-outline-secondary">
                            Lanjut Belanja
                        </a>
                        <div>
                            <button type="submit" name="update_cart" class="btn btn-warning me-2 text-white shadow-sm">
                                Perbarui Keranjang
                            </button>
                            <a href="index.php?page=transaction" class="btn btn-primary shadow-sm px-4">
                                Lanjut ke Pembayaran
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>