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
}

?>