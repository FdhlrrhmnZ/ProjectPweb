<?php
// Pastikan hanya admin yang bisa akses jika ada sistem role
require_once 'class/class.Transaksi.php';

$transaksiObj = new Transaksi();
$listTransaksi = $transaksiObj->SelectAllTransaksi();
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Histori <span class="text-primary">Transaksi</span></h2>
    
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>ID User</th>
                            <th>Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listTransaksi)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada transaksi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listTransaksi as $row): ?>
                            <tr>
                                <td class="ps-3"><?= $row['idTransaksi'] ?></td>
                                <td><?= $row['tanggal'] ?></td>
                                <td><?= $row['idUser'] ?></td>
                                <td><?= $row['nama_produk'] ?></td>
                                <td>
                                    <a class="btn btn-sm btn-info text-white">Detail</a>
                                    <a class="btn btn-danger btn-sm" href="dashboardadmin.php?page=deleteproduk&productid='.$d->productid.'"
                                    onclick="return confirm(\'Hapus Produk?\')">Delete</a>
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