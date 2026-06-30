<?php
class Product extends Connection {
    public $productid = 0;
    public $productname = '';
    public $price = 0.0;
    public $warnaProduk = '';
    public $sisaStok = 0;
    public $gambar = ''; 
    public $kategori = 'Reguler'; 
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

    // Perbaikan: Tambah stok, warna, dan kategori ke database
    public function AddProduct(){
        $stok = !empty($this->sisaStok) ? (int)$this->sisaStok : 0;
        $warna = !empty($this->warnaProduk) ? $this->warnaProduk : 'Standard';
        $kat = !empty($this->kategori) ? $this->kategori : 'Reguler';

        $sql = "INSERT INTO produk (namaProduk, hargaProduk, gambar, sisaStok, warnaProduk, kategori) 
                VALUES ('$this->productname', '$this->price', '$this->gambar', '$stok', '$warna', '$kat')";
        $this->hasil = mysqli_query($this->connection, $sql);
        
        if($this->hasil){
            $this->message = "Data product berhasil ditambahkan";
        } else {
            $this->message = "Data product gagal ditambahkan: " . mysqli_error($this->connection);
        }
    }

    // Perbaikan: Update stok, warna, dan kategori ke database
    public function UpdateProduct(){
        $stok = !empty($this->sisaStok) ? (int)$this->sisaStok : 0;
        $warna = !empty($this->warnaProduk) ? $this->warnaProduk : 'Standard';
        $kat = !empty($this->kategori) ? $this->kategori : 'Reguler';

        if($this->gambar != '') {
            $sql = "UPDATE produk SET namaProduk = '$this->productname', hargaProduk = '$this->price', sisaStok = '$stok', warnaProduk = '$warna', kategori = '$kat', gambar = '$this->gambar' WHERE idProduk = '$this->productid'";
        } else {
            $sql = "UPDATE produk SET namaProduk = '$this->productname', hargaProduk = '$this->price', sisaStok = '$stok', warnaProduk = '$warna', kategori = '$kat' WHERE idProduk = '$this->productid'";
        }
        $this->hasil = mysqli_query($this->connection, $sql);
    }

    public function DeleteProduct(){
        $sql = "DELETE FROM produk WHERE idProduk = '$this->productid'";
        $this->hasil = mysqli_query($this->connection, $sql);
    }

    public function SelectAllProducts($search = '', $sort = ''){
        $sql = "SELECT * FROM produk WHERE 1=1";
        if (!empty($search)) {
            $search_safe = mysqli_real_escape_string($this->connection, $search);
            $sql .= " AND namaProduk LIKE '%$search_safe%'";
        }
        if ($sort == 'termahal') { $sql .= " ORDER BY hargaProduk DESC"; } 
        else if ($sort == 'termurah') { $sql .= " ORDER BY hargaProduk ASC"; } 
        else if ($sort == 'az') { $sql .= " ORDER BY namaProduk ASC"; } 
        else { $sql .= " ORDER BY idProduk DESC"; }

        return mysqli_query($this->connection, $sql);
    }

    public function SelectAllProduct(){
        $sql = "SELECT * FROM produk";
        $query = mysqli_query($this->connection, $sql);
        $data = [];
        if($query){
            while($row = mysqli_fetch_assoc($query)){ $data[] = $row; }
        }
        return $data;
    }

    public function SelectRecommendedProducts($limit = 3){
        $sql = "SELECT * FROM produk WHERE kategori = 'Rekomendasi' ORDER BY idProduk DESC LIMIT $limit";
        $query = mysqli_query($this->connection, $sql);
        $data = [];
        if($query){
            while($row = mysqli_fetch_assoc($query)){ $data[] = $row; }
        }
        return $data;
    }
}
?>