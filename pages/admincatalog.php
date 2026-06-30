<?php
require_once 'class/class.product.php';
$prodObj = new Product();

// Logika Delete
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
    $prodObj->productid = $_GET['id'];
    $prodObj->DeleteProduct();
    echo "<script>alert('Produk berhasil dihapus!'); window.location='index.php?page=admincatalog';</script>";
}

$listProduk = $prodObj->SelectAllProduct();
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen <span class="text-primary">Katalog</span></h2>
    </div>
    
    <div class="card shadow-sm border-0 mb-5 bg-dark text-light">
        <div class="card-body p-4">
            <h5 class="text-warning mb-3" id="formTitle">Tambah Produk Baru</h5>
            <form action="pages/uploadpost.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action_type" id="actionType" value="insert">
                <input type="hidden" name="productid" id="productId" value="">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Nama Produk</label>
                        <input type="text" name="namaproduk" id="namaProduk" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="hargaproduk" id="hargaProduk" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Sisa Stok</label>
                        <input type="number" name="stok" id="sisaStok" class="form-control" required>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Warna Produk</label>
                        <input type="text" name="warnaproduk" id="warnaProduk" class="form-control" placeholder="Hitam / Putih">
                    </div>
                    <div class="col-md-4">
                        <label>Penempatan (Kategori)</label>
                        <select name="kategori" id="kategoriProduk" class="form-select" required>
                            <option value="Reguler">Reguler (Hanya di Katalog)</option>
                            <option value="Rekomendasi">Rekomendasi (Tampil di Home & Katalog)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Upload Gambar</label>
                        <input type="file" name="fupload" class="form-control" accept="image/*">
                        <small class="text-muted" style="font-size:10px;">*Kosongkan jika tidak ingin ganti gambar saat edit.</small>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="ti ti-save"></i> Simpan Data</button>
                    <button type="button" class="btn btn-outline-light ms-2" onclick="resetForm()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status Penempatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listProduk)): ?>
                            <tr><td colspan="6" class="py-4">Belum ada produk di katalog.</td></tr>
                        <?php else: ?>
                            <?php foreach ($listProduk as $row): ?>
                            <tr>
                                <td>
                                    <?php $img = !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>
                                    <img src="upload/<?= htmlspecialchars($img) ?>" style="width:60px; height:60px; object-fit:cover; border-radius:5px;">
                                </td>
                                <td class="fw-medium text-start"><?= htmlspecialchars($row['namaProduk']) ?></td>
                                <td>Rp <?= number_format($row['hargaProduk'], 0, ',', '.') ?></td>
                                <td><?= $row['sisaStok'] ?></td>
                                <td>
                                    <?php if($row['kategori'] == 'Rekomendasi'): ?>
                                        <span class="badge bg-warning text-dark">Rekomendasi (Home)</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Reguler</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning text-dark" onclick="editData(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                                    <a href="index.php?page=admincatalog&action=delete&id=<?= $row['idProduk'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
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

<script>
function editData(data) {
    document.getElementById('formTitle').innerText = "Update Produk: " + data.namaProduk;
    document.getElementById('actionType').value = "update";
    document.getElementById('productId').value = data.idProduk;
    document.getElementById('namaProduk').value = data.namaProduk;
    document.getElementById('hargaProduk').value = data.hargaProduk;
    document.getElementById('sisaStok').value = data.sisaStok;
    document.getElementById('warnaProduk').value = data.warnaProduk || '';
    document.getElementById('kategoriProduk').value = data.kategori || 'Reguler';
    window.scrollTo(0, 0); // Scroll ke atas saat klik edit
}
function resetForm() {
    document.getElementById('formTitle').innerText = "Tambah Produk Baru";
    document.getElementById('actionType').value = "insert";
    document.getElementById('productId').value = "";
    document.getElementById('namaProduk').value = "";
    document.getElementById('hargaProduk').value = "";
    document.getElementById('sisaStok').value = "";
    document.getElementById('warnaProduk').value = "";
    document.getElementById('kategoriProduk').value = "Reguler";
}
</script>