<?php
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['userid'])) {
        echo "<script>
                alert('Silakan login terlebih dahulu untuk menambahkan barang ke keranjang!');
                window.location.href='index.php?page=login';
              </script>";
        exit;
    }
    
    $product_id = $_POST['productid'];
    $product_name = $_POST['productname'];
    $price = $_POST['price'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    $ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : '';
    $warna = isset($_POST['warna']) ? $_POST['warna'] : '';

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productid'] == $product_id && $item['ukuran'] == $ukuran && $item['warna'] == $warna) {
            $item['qty'] += $qty;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'productid' => $product_id,
            'productname' => $product_name,
            'price' => $price,
            'qty' => $qty,
            'ukuran' => $ukuran,
            'warna' => $warna
        ];
    }

    echo "<script>window.location.href='index.php?page=catalog&status=added';</script>";
    exit;
}

require_once 'class/class.product.php';
$productObj = new Product();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort   = isset($_GET['sort']) ? $_GET['sort'] : '';
$result = $productObj->SelectAllProducts($search, $sort);
$db_error = mysqli_error($productObj->connection);
?>

<div class="pv-page-wrap text-light" style="padding: 3rem 2.5rem;">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="pv-page-title mb-0">Katalog <span>Produk</span></h2>
        <a href="index.php?page=transaction" class="pv-btn">
            <i class="ti ti-shopping-cart"></i> Keranjang Belanja 
            <span class="badge bg-light text-dark ms-2"><?= count($_SESSION['cart']) ?> Item</span>
        </a>
    </div>

    <div class="mb-5">
        <form action="index.php" method="GET" class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
            <input type="hidden" name="page" value="catalog">
            <div class="d-flex flex-grow-1" style="max-width: 500px; gap: 10px;">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="pv-btn-outline">Cari</button>
            </div>
            <div class="d-flex" style="gap: 10px;">
                <select name="sort" class="form-select" style="min-width: 220px; background:#111; color:#fff;">
                    <option value="">-- Urutkan Default --</option>
                    <option value="termahal" <?= ($sort == 'termahal') ? 'selected' : '' ?>>Harga: Termahal</option>
                    <option value="termurah" <?= ($sort == 'termurah') ? 'selected' : '' ?>>Harga: Termurah</option>
                    <option value="az" <?= ($sort == 'az') ? 'selected' : '' ?>>Nama: A - Z</option>
                </select>
                <button type="submit" class="pv-btn-outline">Pilih</button>
            </div>
        </form>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'added'): ?>
        <div class="alert alert-success bg-dark text-success border-success mb-4">
            <i class="ti ti-check"></i> Produk berhasil dimasukkan ke keranjang belanja!
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col d-flex">
                    <div class="pv-product-card w-100 d-flex flex-column">
                        <div class="pv-product-img" style="height: 250px;">
                            <div class="pv-product-img-inner">
                                <?php $namaGambar = !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>
                                <img src="upload/<?= htmlspecialchars($namaGambar) ?>" alt="Gambar Produk">
                            </div>
                        </div>
                        <div class="pv-product-info d-flex flex-column flex-grow-1">
                            <div class="pv-product-name"><?= htmlspecialchars($row['namaProduk']) ?></div>
                            <div class="pv-product-price">Rp <?= number_format($row['hargaProduk'], 0, ',', '.'); ?></div>
                            <p style="font-size:11px; color:gray; margin-bottom:15px;">Stok: <?= $row['sisaStok'] ?></p>
                            
                            <form method="POST" action="index.php?page=catalog" class="mt-auto">
                                <input type="hidden" name="productid" value="<?= $row['idProduk'] ?>">
                                <input type="hidden" name="productname" value="<?= htmlspecialchars($row['namaProduk']) ?>">
                                <input type="hidden" name="price" value="<?= $row['hargaProduk'] ?>">
                                
                                <div class="mb-2">
                                    <input type="number" name="qty" class="form-control form-control-sm mb-2" value="1" min="1" max="<?= $row['sisaStok'] ?>" style="background:#1a1a1a; color:#white;" required>
                                </div>

                                <div class="d-flex gap-2 mb-3">
                                    <select name="ukuran" class="form-select form-select-sm" style="background:#111; color:#fff;" required>
                                        <option value="" disabled selected>Ukuran</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                    <select name="warna" class="form-select form-select-sm" style="background:#111; color:#fff;" required>
                                        <option value="" disabled selected>Warna</option>
                                        <option value="Hitam">Hitam</option>
                                        <option value="Putih">Putih</option>
                                        <option value="Navy">Navy</option>
                                    </select>
                                </div>

                                <button type="submit" name="add_to_cart" class="pv-btn w-100" style="justify-content:center;" <?= ($row['sisaStok'] <= 0) ? 'disabled' : '' ?>>
                                    <?= ($row['sisaStok'] <= 0) ? 'Stok Habis' : '<i class="ti ti-shopping-cart-plus"></i> Tambah Ke Keranjang' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center w-100"><p class="text-muted">Produk tidak ditemukan.</p></div>
        <?php endif; ?>
    </div>
</div>