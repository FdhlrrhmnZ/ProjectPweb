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

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productid'] == $product_id) {
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
            'qty' => $qty
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

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Katalog <span class="text-primary">Produk</span></h2>
        
        <a href="index.php?page=transaction" class="btn btn-success shadow-sm">
            <i class="ti ti-shopping-cart"></i> Proses Transaksi 
            <span class="badge bg-light text-success ms-1"><?= count($_SESSION['cart']) ?> Item</span>
        </a>
    </div>

    <div class="mb-4">
        <form action="index.php" method="GET" class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
            <input type="hidden" name="page" value="catalog">

            <div class="d-flex flex-grow-1" style="max-width: 500px; gap: 5px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary fw-bold text-white">Search</button>
            </div>

            <div class="d-flex" style="gap: 5px;">
                <select name="sort" class="form-select" style="min-width: 220px;">
                    <option value="">-- Pengurutan Default --</option>
                    <option value="termahal" <?= ($sort == 'termahal') ? 'selected' : '' ?>>Harga: Paling Mahal</option>
                    <option value="termurah" <?= ($sort == 'termurah') ? 'selected' : '' ?>>Harga: Paling Murah</option>
                    <option value="az" <?= ($sort == 'az') ? 'selected' : '' ?>>Nama: A - Z</option>
                </select>
                <button type="submit" class="btn btn-danger fw-bold text-white">Urutkan</button>
            </div>
        </form>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'added'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check"></i> Produk berhasil ditambahkan ke keranjang belanja!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-dark text-light">
                        <?php 
    // Mengecek apakah kolom gambar ada isinya, jika kosong pakai gambar default
    $namaGambar = !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; 
?>
<img src="upload/<?= htmlspecialchars($namaGambar) ?>" class="card-img-top bg-secondary" alt="Gambar Produk" style="height: 180px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="<?= htmlspecialchars($row['namaProduk']) ?>">
                                <?= htmlspecialchars($row['namaProduk']) ?>
                            </h5>
                            
                            <p class="card-text text-info fw-bold fs-5 mb-1">
                                <?php 
                                    if(function_exists('format_idr')) {
                                        echo format_idr($row['hargaProduk']);
                                    } else {
                                        echo 'Rp ' . number_format($row['hargaProduk'], 0, ',', '.');
                                    }
                                ?>
                            </p>

                            <p class="card-text text-secondary mb-3" style="font-size: 0.85rem;">
                                Warna: <?= htmlspecialchars($row['warnaProduk'] ?? '-') ?> | Stok: <?= htmlspecialchars($row['sisaStok']) ?>
                            </p>
                            
                            <form method="POST" action="index.php?page=catalog" class="mt-auto">
                                <input type="hidden" name="productid" value="<?= $row['idProduk'] ?>">
                                <input type="hidden" name="productname" value="<?= htmlspecialchars($row['namaProduk']) ?>">
                                <input type="hidden" name="price" value="<?= $row['hargaProduk'] ?>">
                                
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text bg-secondary text-light border-secondary">Qty</span>
                                    <input type="number" name="qty" class="form-control bg-dark text-light border-secondary" value="1" min="1" max="<?= $row['sisaStok'] ?>" required>
                                </div>
                                <button type="submit" name="add_to_cart" class="btn btn-primary w-100" <?= ($row['sisaStok'] <= 0) ? 'disabled' : '' ?>>
                                    <i class="ti ti-shopping-cart-plus"></i> <?= ($row['sisaStok'] <= 0) ? 'Stok Habis' : 'Tambah ke Cart' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center my-5">
                <div class="alert alert-warning d-inline-block">
                    <i class="ti ti-alert-triangle"></i> Belum ada produk atau produk yang dicari tidak ditemukan.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>