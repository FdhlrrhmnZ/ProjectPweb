<?php

// Inisialisasi keranjang belanja jika belum ada di sesi
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle logika ketika tombol "Tambah ke Cart" ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['productid'];
    $product_name = $_POST['productname'];
    $price = $_POST['price'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

    // Cek apakah produk sudah ada di dalam cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productid'] == $product_id) {
            $item['qty'] += $qty; // Jika ada, tambahkan quantity-nya saja
            $found = true;
            break;
        }
    }

    // Jika belum ada, masukkan sebagai item baru
    if (!$found) {
        $_SESSION['cart'][] = [
            'productid' => $product_id,
            'productname' => $product_name,
            'price' => $price,
            'qty' => $qty
        ];
    }

    // Refresh halaman untuk menghindari form resubmission
    echo "<script>window.location.href='index.php?page=catalog&status=added';</script>";
    exit;
}

// Sertakan class Product untuk menggunakan koneksi database-nya
require_once 'class/class.product.php';
$productObj = new Product();

// Ambil data produk dari database
// Mengambil asumsi nama tabel adalah 'product' sesuai dengan method AddProduct()
$query = "SELECT * FROM produk";
$result = mysqli_query($productObj->connection, $query);
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Katalog <span class="text-primary">Produk</span></h2>
        
        <a href="index.php?page=transaction" class="btn btn-success shadow-sm">
            <i class="ti ti-shopping-cart"></i> Proses Transaksi 
            <span class="badge bg-light text-success ms-1"><?= count($_SESSION['cart']) ?> Item</span>
        </a>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'added'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check"></i> Produk berhasil ditambahkan ke keranjang belanja!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-dark text-light">
                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="ti ti-photo" style="font-size: 3rem; color: #aaa;"></i>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="<?= htmlspecialchars($row['productname']) ?>">
                                <?= htmlspecialchars($row['productname']) ?>
                            </h5>
                            
                            <p class="card-text text-info fw-bold fs-5">
                                <?= format_idr($row['price']) ?>
                            </p>
                            
                            <form method="POST" action="index.php?page=catalog" class="mt-auto">
                                <input type="hidden" name="productid" value="<?= $row['productid'] ?>">
                                <input type="hidden" name="productname" value="<?= htmlspecialchars($row['productname']) ?>">
                                <input type="hidden" name="price" value="<?= $row['price'] ?>">
                                
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text bg-secondary text-light border-secondary">Qty</span>
                                    <input type="number" name="qty" class="form-control bg-dark text-light border-secondary" value="1" min="1" required>
                                </div>
                                <button type="submit" name="add_to_cart" class="btn btn-primary w-100">
                                    <i class="ti ti-shopping-cart-plus"></i> Tambah ke Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle"></i> Belum ada produk di katalog.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>