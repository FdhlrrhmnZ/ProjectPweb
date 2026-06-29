<?php
    // Panggil koneksi dan class product
    require_once '../inc.koneksi.php'; // Pastikan path koneksi disesuaikan jika perlu
    require_once '../class/class.product.php';
    
    $productObj = new Product();

    // Pastikan folder upload ada
    $folder = '../upload/'; 
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $lokasi_file    = $_FILES['fupload']['tmp_name'];
    $nama_file      = time() . "_" . basename($_FILES['fupload']['name']); // Agar nama file unik & tidak bentrok
    $ukuran_file    = $_FILES['fupload']['size'];

    // Pindahkan file gambar aslinya ke dalam folder upload
    $isSuccessUpload = move_uploaded_file($lokasi_file, $folder.$nama_file);
    
    if($isSuccessUpload) {
        // Jika file berhasil masuk ke folder, simpan data ke database
        
        $productObj->productname = $_POST['namaproduk'];
        $productObj->price       = $_POST['hargaproduk'];
        $productObj->gambar      = $nama_file; 
        
        // Asumsi jika ada field stok, jika tidak class product otomatis set default
        if(isset($_POST['stok'])) {
             $productObj->sisaStok = $_POST['stok'];
        }

        // Eksekusi penyimpanan ke tabel phpMyAdmin
        $productObj->AddProduct();

        echo "<script>
                alert('Produk berhasil ditambahkan!');
                window.location.href='../index.php?page=catalog';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengupload gambar! Periksa folder upload.');
                window.history.back();
              </script>";
    }
?>