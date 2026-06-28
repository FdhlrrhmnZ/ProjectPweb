<?php
class Product extends Connection {
    private $productid = 0;
    private $productname = '';
    private $price = 0.0;
    private $gambar = ''; // Properti baru untuk menyimpan nama file gambar
    public $hasil = false;
    public $message = '';

    public function __get($attribute){
        if(property_exists($this, $attribute)){
            return $this->$attribute;
        }
    }

    public function __set($attribute, $value){
        if(property_exists($this, $attribute)){
            $this->$attribute = $value;
        }
    }

    public function AddProduct(){
        // Query disesuaikan dengan tabel 'produk' di database company.sql dan disisipkan kolom 'gambar'
        $sql = "INSERT INTO produk (namaProduk, hargaProduk, gambar) VALUES ('$this->productname', '$this->price', '$this->gambar')";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data product berhasil ditambahkan";
        } else {
            $this->message = "Data product gagal ditambahkan: " . mysqli_error($this->connection);
        }
    }

    public function UpdateProduct(){
        // Query disesuaikan dengan tabel 'produk' di database company.sql
        $sql = "UPDATE produk SET namaProduk = '$this->productname', hargaProduk = '$this->price' WHERE idProduk = '$this->productid'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data product berhasil diubah";
        } else {
            $this->message = "Data product gagal diubah: " . mysqli_error($this->connection);
        }
    }

    public function DeleteProduct(){
        // Query disesuaikan dengan tabel 'produk' di database company.sql
        $sql = "DELETE FROM produk WHERE idProduk = '$this->productid'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data product berhasil dihapus";
        } else {
            $this->message = "Data product gagal dihapus: " . mysqli_error($this->connection);
        }
    }

    public function SelectProductByID(){
        // Query disesuaikan dengan tabel 'produk' di database company.sql
        $sql = "SELECT * FROM produk WHERE idProduk = '$this->productid'";
        $query = mysqli_query($this->connection, $sql);
        
        if($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $this->productname = $row['namaProduk'];
            $this->price = $row['hargaProduk'];
            return $row;
        }
        return null;
    }

    // ==========================================
    // FITUR PENCARIAN & PENGURUTAN KATALOG
    // ==========================================
    public function SelectAllProducts($search = '', $sort = ''){
        $sql = "SELECT * FROM produk WHERE 1=1";

        // Fitur Search (Cari berdasarkan namaProduk)
        if (!empty($search)) {
            $search_safe = mysqli_real_escape_string($this->connection, $search);
            $sql .= " AND namaProduk LIKE '%$search_safe%'";
        }

        // Fitur Sort (Pengurutan berdasarkan hargaProduk dan namaProduk)
        if ($sort == 'termahal') {
            $sql .= " ORDER BY hargaProduk DESC";
        } else if ($sort == 'termurah') {
            $sql .= " ORDER BY hargaProduk ASC";
        } else if ($sort == 'az') {
            $sql .= " ORDER BY namaProduk ASC";
        } else {
            $sql .= " ORDER BY idProduk DESC"; // Default: ID terbaru
        }

        return mysqli_query($this->connection, $sql);
    }
}
?>