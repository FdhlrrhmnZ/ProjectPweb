<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- FITUR PROTEKSI GUEST ---
if (!isset($_SESSION['userid'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu untuk melanjutkan proses transaksi!');
            window.location.href='index.php?page=login';
          </script>";
    exit;
}

// Redirect jika keranjang kosong
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>alert('Keranjang belanja Anda kosong!'); window.location.href='index.php?page=catalog';</script>";
    exit;
}

// ... (sisa kode transaction.php di bawahnya tetap sama)

// Redirect jika keranjang kosong
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>alert('Keranjang belanja Anda kosong!'); window.location.href='index.php?page=catalog';</script>";
    exit;
}

require_once 'class/class.Transaksi.php';
require_once 'class/class.DetailTransaksi.php';

// Proses saat form checkout disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    $idUser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : 1; // Default idUser = 1 jika belum ada sistem login
    $alamat = $_POST['alamat'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $tanggal = date('Y-m-d H:i:s');
    
    $transaksiObj = new Transaksi();
    $detailObj = new DetailTransaksi();
    
    $pesan_wa = "Halo Admin, saya ingin melakukan konfirmasi pesanan:\n\n";
    $grand_total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $idProduk = $item['productid'];
        $qty = $item['qty'];
        $harga = $item['price'];
        $subtotal = $qty * $harga;
        
        // 1. Simpan Record ke Tabel Transaksi
        $transaksiObj->tanggal = $tanggal;
        $transaksiObj->idUser = $idUser;
        $transaksiObj->idProduk = $idProduk;
        $transaksiObj->AddTransaksi();
        
        // Ambil idTransaksi terakhir yang baru di-insert untuk relasi ke Detail Transaksi
        $idTransaksi = mysqli_insert_id($transaksiObj->connection);
        
        // 2. Simpan Record ke Tabel Detail Transaksi
        if ($idTransaksi) {
            $detailObj->idTransaksi = $idTransaksi;
            $detailObj->jumlahPesanan = $qty;
            $detailObj->totalHarga = $subtotal;
            $detailObj->AddDetailTransaksi();
        }
        
        // 3. Susun Teks Pesanan untuk WhatsApp
        $pesan_wa .= "- " . $item['productname'] . " (" . $qty . "x) : Rp " . number_format($subtotal, 0, ',', '.') . "\n";
        $grand_total += $subtotal;
    }
    
    // Tambahkan detail Alamat & Pembayaran ke Teks WA
    $pesan_wa .= "\n*Grand Total: Rp " . number_format($grand_total, 0, ',', '.') . "*\n";
    $pesan_wa .= "Alamat Pengiriman: " . $alamat . "\n";
    $pesan_wa .= "Metode Pembayaran: " . $metode_pembayaran . "\n\n";
    $pesan_wa .= "Terima kasih!";

    // Kosongkan session keranjang setelah checkout direkam
    unset($_SESSION['cart']);

    // Generate link WhatsApp (Ganti 6281234567890 dengan nomor WA Admin yang sesungguhnya)
    $nomor_admin = "6281234567890";
    $link_wa = "https://api.whatsapp.com/send?phone=" . $nomor_admin . "&text=" . urlencode($pesan_wa);
    
    echo "<script>
            alert('Transaksi berhasil disimpan! Anda akan diarahkan ke WhatsApp Admin untuk penyelesaian.');
            window.location.href='" . $link_wa . "';
          </script>";
    exit;
}
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Keranjang <span class="text-primary">Transaksi</span></h2>
        <a href="index.php?page=catalog" class="btn btn-secondary shadow-sm">
            <i class="ti ti-arrow-left"></i> Kembali ke Katalog
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="ti ti-shopping-cart"></i> Daftar Item Belanja</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th class="pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_semua = 0;
                                foreach ($_SESSION['cart'] as $item):
                                    $subtotal = $item['price'] * $item['qty'];
                                    $total_semua += $subtotal;
                                ?>
                                <tr>
                                    <td class="ps-3 fw-medium"><?= htmlspecialchars($item['productname']) ?></td>
                                    <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td><?= $item['qty'] ?></td>
                                    <td class="pe-3 fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Grand Total:</th>
                                    <th class="pe-3 fw-bold text-success fs-5">Rp <?= number_format($total_semua, 0, ',', '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="ti ti-truck-delivery"></i> Detail Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?page=transaction" method="POST">
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat tujuan pengiriman..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="metode_pembayaran" class="form-label fw-bold">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="" disabled selected>Pilih Pembayaran...</option>
                                <option value="Transfer Bank BCA">Transfer Bank (BCA)</option>
                                <option value="Transfer Bank Mandiri">Transfer Bank (Mandiri)</option>
                                <option value="E-Wallet (GoPay/Dana/OVO)">E-Wallet (GoPay/Dana/OVO)</option>
                                <option value="Cash on Delivery (COD)">Cash on Delivery (COD)</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="checkout" class="btn btn-success btn-lg shadow-sm">
                                <i class="ti ti-brand-whatsapp"></i> Konfirmasi & Pesan via WA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>