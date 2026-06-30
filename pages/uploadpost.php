<?php
session_start();

// 1. Panggil koneksi dan class dengan urutan yang benar
require_once '../inc.koneksi.php';
require_once '../class/class.product.php';

// 2. Inisialisasi Object
$productObj = new Product();

// 3. Pastikan object berhasil dibuat
if ($productObj === null) {
    die("Error: Object Product gagal dibuat. Pastikan file class.product.php aman!");
}

// 4. Tangkap tipe aksi: 'insert' (tambah baru) atau 'update' (edit)
$action_type = isset($_POST['action_type']) ? $_POST['action_type'] : 'insert';

// 5. Masukkan data dari form ke dalam properti object
$productObj->productname = $_POST['namaproduk'];
$productObj->price       = $_POST['hargaproduk'];
$productObj->warnaProduk = isset($_POST['warnaproduk']) ? $_POST['warnaproduk'] : '';
$productObj->sisaStok    = $_POST['stok'];
$productObj->kategori    = isset($_POST['kategori']) ? $_POST['kategori'] : 'Reguler';

// 6. Penanganan Folder dan Upload Gambar
$folder = '../upload/';
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

$nama_file = "";
if (isset($_FILES['fupload']['name']) && $_FILES['fupload']['name'] != "") {
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = time() . "_" . basename($_FILES['fupload']['name']);
    move_uploaded_file($lokasi_file, $folder . $nama_file);
}

// 7. Eksekusi Logika Berdasarkan Aksi
if ($action_type == 'update') {
    
    // PROSES UPDATE DATA BARANG
    $productObj->productid = $_POST['productid'];

    // Jika Admin mengganti gambar, set properti gambar dengan yang baru
    if ($nama_file != "") {
        $productObj->gambar = $nama_file;
    }

    $productObj->UpdateProduct();
    echo "<script>alert('Data produk sukses diperbarui!'); window.location.href='../index.php?page=admincatalog';</script>";

} else {
    
    // PROSES INSERT (TAMBAH BARANG BARU)
    $productObj->gambar = $nama_file;
    $productObj->AddProduct();
    echo "<script>alert('Produk baru sukses ditambahkan!'); window.location.href='../index.php?page=admincatalog';</script>";
}
?>