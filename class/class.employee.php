<?php
class Employee {
    private $ssn = "";
    private $fname = "";
    private $address = "";

    public $hasil = false;
    public $message = "";

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

    public funstion AddEmployee(){
        $sql = "INSERT INTO employee (ssn, fname, address) VALUES ('$this->ssn', '$this->fname', '$this->address')";
        $this->hasil = mysqli_query($this->conn, $sql);

        if($this->hasil){
            $this->message = "Data employee berhasil ditambahkan";
        } else {
            $this->message = "Data employee gagal ditambahkan: " . mysqli_error($this->conn);
        }
    }

    public function UpdateEmployee(){

    }

    public function DeleteEmployee(){

    }

    public function SelectAllEmployee(){

    }

    public function SelectOneEmployee(){

    }
}
?>