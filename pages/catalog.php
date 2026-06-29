<?php
// Inisialisasi keranjang belanja jika belum ada di sesi
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle logika ketika tombol "Tambah ke Cart" ditekan
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
        // Jika id, ukuran, dan warna sama, tambahkan qty saja
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

// Tangkap parameter Search & Sort
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort   = isset($_GET['sort']) ? $_GET['sort'] : '';

// Ambil data dari database yang sesuai
$result = $productObj->SelectAllProducts($search, $sort);
$db_error = mysqli_error($productObj->connection);
?>

<div class="pv-page-wrap">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="pv-page-title mb-0">Katalog <span>Produk</span></h2>
        
        <a href="index.php?page=transaction" class="pv-btn">
            <i class="ti ti-shopping-cart"></i> Proses Transaksi 
            <span class="badge bg-light text-dark ms-2"><?= count($_SESSION['cart']) ?> Item</span>
        </a>
    </div>

    <div class="mb-5">
        <form action="index.php" method="GET" class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
            <input type="hidden" name="page" value="catalog">

            <div class="d-flex flex-grow-1" style="max-width: 500px; gap: 10px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="pv-btn-outline" style="padding: 10px 15px;">Search</button>
            </div>

            <div class="d-flex" style="gap: 10px;">
                <select name="sort" class="form-select" style="min-width: 220px;">
                    <option value="">-- Pengurutan Default --</option>
                    <option value="termahal" <?= ($sort == 'termahal') ? 'selected' : '' ?>>Harga: Paling Mahal</option>
                    <option value="termurah" <?= ($sort == 'termurah') ? 'selected' : '' ?>>Harga: Paling Murah</option>
                    <option value="az" <?= ($sort == 'az') ? 'selected' : '' ?>>Nama: A - Z</option>
                </select>
                <button type="submit" class="pv-btn-outline" style="padding: 10px 15px;">Urutkan</button>
            </div>
        </form>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'added'): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="ti ti-check"></i> Produk berhasil ditambahkan ke keranjang belanja!
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if ($db_error): ?>
            <div class="col-12 my-5">
                <div class="alert alert-danger">
                    <b>⚠️ DATABASE ERROR:</b> <?= htmlspecialchars($db_error) ?>
                </div>
            </div>
        <?php elseif ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col d-flex">
                    <div class="pv-product-card w-100 d-flex flex-column">
                        <div class="pv-product-img" style="height: 250px;">
                            <div class="pv-product-img-inner">
                                <?php 
                                    // Mengecek apakah kolom gambar ada isinya, jika kosong pakai gambar default
                                    $namaGambar = !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; 
                                ?>
                                <img src="upload/<?= htmlspecialchars($namaGambar) ?>" alt="<?= htmlspecialchars($row['namaProduk']) ?>">
                            </div>
                        </div>
                        
                        <div class="pv-product-info d-flex flex-column flex-grow-1">
                            <div class="pv-product-name"><?= htmlspecialchars($row['namaProduk']) ?></div>
                            <div class="pv-product-price mb-2">
                                <?php 
                                    if(function_exists('format_idr')) {
                                        echo format_idr($row['hargaProduk']);
                                    } else {
                                        echo 'Rp ' . number_format($row['hargaProduk'], 0, ',', '.');
                                    }
                                ?>
                            </div>

                            <p class="mb-3" style="font-size: 10px; color: var(--pv-fg3); text-transform: uppercase;">
                                Stok Tersedia: <?= htmlspecialchars($row['sisaStok'] ?? '0') ?>
                            </p>
                            
                            <form method="POST" action="index.php?page=catalog" class="mt-auto">
                                <input type="hidden" name="productid" value="<?= $row['idProduk'] ?>">
                                <input type="hidden" name="productname" value="<?= htmlspecialchars($row['namaProduk']) ?>">
                                <input type="hidden" name="price" value="<?= $row['hargaProduk'] ?>">
                                
                                <div class="d-flex gap-2 mb-3">
                                    <div class="flex-grow-1">
                                        <select name="ukuran" class="form-select form-select-sm" style="background: var(--pv-bg2); color: var(--pv-fg); border-color: var(--pv-border); font-size: 11px; padding: 8px;" required>
                                            <option value="" disabled selected>Ukuran</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1">
                                        <select name="warna" class="form-select form-select-sm" style="background: var(--pv-bg2); color: var(--pv-fg); border-color: var(--pv-border); font-size: 11px; padding: 8px;" required>
                                            <option value="" disabled selected>Warna</option>
                                            <option value="Hitam">Hitam</option>
                                            <option value="Putih">Putih</option>
                                            <option value="Navy">Navy</option>
                                            <option value="Abu-abu">Abu-abu</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" name="add_to_cart" class="pv-btn w-100" style="justify-content:center;" <?= (isset($row['sisaStok']) && $row['sisaStok'] <= 0) ? 'disabled' : '' ?>>
                                    <i class="ti ti-shopping-cart-plus"></i> <?= (isset($row['sisaStok']) && $row['sisaStok'] <= 0) ? 'Stok Habis' : 'Tambah ke Cart' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center my-5 w-100">
                <div class="alert alert-warning d-inline-block">
                    <i class="ti ti-alert-triangle"></i> Belum ada produk atau produk yang dicari tidak ditemukan.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>