<?php
class Product extends Connection {
    private $productid = 0;
    private $productname = '';
    private $price = 0.0;
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
        $sql = "INSERT INTO product (productname, price) VALUES ('$this->productname', '$this->price')";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data product berhasil ditambahkan";
        } else {
            $this->message = "Data product gagal ditambahkan: " . mysqli_error($this->connection);
        }
    }

    public function UpdateProduct(){
        $sql = "UPDATE product SET productname = '$this->productname', price = '$this->price' WHERE productid = '$this->productid'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data product berhasil diubah";
        } else {
            $this->message = "Data product gagal diubah: " . mysqli_error($this->connection);
        }
    }

    public function DeleteProduct(){
        $sql = "DELETE FROM product WHERE productid = '$this->productid'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data product berhasil dihapus";
        } else {
            $this->message = "Data product gagal dihapus: " . mysqli_error($this->connection);
        }
    }

    public function SelectProductByID(){
        $sql = "SELECT * FROM product WHERE productid = '$this->productid'";
        $query = mysqli_query($this->connection, $sql);
        
        if($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $this->productname = $row['productname'];
            $this->price = $row['price'];
            return $row;
        }
        return null;
    }
}

?>