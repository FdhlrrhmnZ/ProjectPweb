<?php

    $tipe_file = $_FILES ['fupload']['type'];
    $lokasi_file = $_FILES ['fupload']['tmp_name'];
    $nama_file = $_FILES ['fupload']['name'];
    $ukuran_file = $_FILES ['fupload']['size'];
    $folder = './upload/';

    $isSuccessUpload = move_uploaded_file($lokasi_file, $folder.$nama_file);
    if ($isSuccessUpload) {
        if($tipe_file == 'image/jpeg' OR $tipe_file == 'image/gif' OR $tipe_file == 'image/png')
            echo '<img src="' .$folder. $nama_file . '">';
        else
            echo '<a href="' .$folder. $nama_file . '"> Lihat file </a>';
    }
?>