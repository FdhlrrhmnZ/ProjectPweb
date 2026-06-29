<?php
require_once 'class/class.product.php';

$prodObj = new Product();
$listProduk = $prodObj->SelectAllProduct();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen <span class="text-primary">Katalog</span></h2>
        <a href="admindashboard.php?page=produk" class="btn btn-primary shadow-sm">
            <i class="ti ti-plus"></i> Tambah Produk
        </a>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listProduk)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada produk di katalog.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listProduk as $row): ?>
                            <tr>
                                <td class="ps-3"><?= $row['idProduk'] ?></td>
                                <td class="fw-medium"><?= htmlspecialchars($row['namaProduk']) ?></td>
                                <td>Rp <?= number_format($row['hargaProduk'], 0, ',', '.') ?></td>
                                <td><?= $row['sisaStok'] ?></td>
                                <td class="text-center">
                                    <a href="dashboardadmin.php?page=produk&id=<?= $row['idProduk'] ?>" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <a href="dashboardadmin.php?page=deleteproduk&id=<?= $row['idProduk'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>