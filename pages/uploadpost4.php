<?php
    $ukuran_maks_file = 1000000; // 1MB
    $lokasi_file      = $_FILES['fupload']['tmp_name'];
    $nama_file        = $_FILES['fupload']['name'];
    $ukuran_file      = $_FILES['fupload']['size'];
    $folder           = './upload/';

    if($ukuran_file > $ukuran_maks_file){
        echo "<script>alert('Ukuran file terlalu besar. Pilih file yang lain');</script>";
        echo "<script>window.location = 'index.php?page=upload';</script>";
    } else{
        $isSuccessUpload = move_uploaded_file($lokasi_file, $folder.$nama_file);
        if($isSuccessUpload)
        {
            echo "Nama File : $nama_file sukses diupload<br>";
            echo "Ukuran File : $ukuran_file bytes";
        }
    }
?>