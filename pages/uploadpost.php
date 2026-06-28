<?php
    // Panggil koneksi dan class product
    require_once 'class/class.product.php';
    $productObj = new Product();

    $lokasi_file    = $_FILES['fupload']['tmp_name'];
    $nama_file      = $_FILES['fupload']['name'];
    $ukuran_file    = $_FILES['fupload']['size'];
    $folder         = './upload/'; // Folder tujuan

    // Pindahkan file gambar aslinya ke dalam folder upload
    $isSuccessUpload = move_uploaded_file($lokasi_file, $folder.$nama_file);
    
    if($isSuccessUpload) {
        // Jika file berhasil masuk ke folder, simpan data ke database
        
        // 1. Ambil nama dan harga yang diketik di form upload.php
        $productObj->productname = $_POST['namaproduk'];
        $productObj->price       = $_POST['hargaproduk'];
        
        // 2. Simpan NAMA FILE-nya saja ke properti gambar
        $productObj->gambar      = $nama_file; 

        // 3. Eksekusi penyimpanan ke tabel phpMyAdmin
        $productObj->AddProduct();

        echo "<div style='padding: 20px; border: 2px solid green;'>";
        echo "<h3>Sukses!</h3>";
        echo "Nama File : <b>$nama_file</b> sukses diupload ke folder.<br>";
        echo "Data Produk : <b>".$_POST['namaproduk']."</b> sukses disimpan ke database!<br><br>";
        
        // Tombol untuk kembali melihat hasilnya di katalog
        echo "<a href='index.php?page=catalog'>Cek Katalog Sekarang</a>";
        echo "</div>";
    } else {
        echo "<h3 style='color:red;'>Gagal upload gambar! Pastikan folder 'upload' sudah dibuat dan memiliki izin akses.</h3>";
    }
?>