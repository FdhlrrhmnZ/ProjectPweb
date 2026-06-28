<html>
    <body>
        <h3>Form Tambah Produk Baru</h3>
        <form enctype="multipart/form-data" method="post" action="index.php?page=uploadpost">
            
            <p>Nama Produk: <br>
            <input type="text" name="namaproduk" required></p>
            
            <p>Harga (Rp): <br>
            <input type="number" name="hargaproduk" required></p>
            
            <p>File Gambar: <br>
            <input type="file" name="fupload" accept="image/*" required></p>
            
            <br><input type="submit" value="Upload & Simpan!">
            
        </form>
    </body>
</html>