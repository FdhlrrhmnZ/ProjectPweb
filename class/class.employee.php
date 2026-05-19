<?php
class Employee extends Connection {
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

    public function AddEmployee(){
        $sql = "INSERT INTO employee (ssn, fname, address) VALUES ('$this->ssn', '$this->fname', '$this->address')";
        $this->hasil = mysqli_query($this->conn, $sql);

        if($this->hasil){
            $this->message = "Data employee berhasil ditambahkan";
        } else {
            $this->message = "Data employee gagal ditambahkan: " . mysqli_error($this->conn);
        }
    }

    public function UpdateEmployee(){
        $sql = "UPDATE employee
                SET fname = '$this->fname',
                address = '$this->address'
                WHERE ssn = '$this->ssn'";

        $this->hasil = mysqli_query($this->connection, $sql);
        if($this->hasil){
            $this->message = "Data berhasil diubah!";
        } else {
            $this->message = "Data gagal diubah!";
        }
    }

    public function DeleteEmployee(){
        $sql = "DELETE FROM employee WHERE ssn = '$this->ssn'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data berhasil dihapus!";
        } else {
            $this->message = "Data gagal dihapus!";
        }
    }

    public function SelectAllEmployee(){
        $sql = "SELECT * FROM employee";
        $result = mysqli_query($this->connection, $sql);
        $arrResult = [];
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                $objEmployee = new Employee();
                $objEmployee->ssn = $data['ssn'];
                $objEmployee->fname = $data['fname'];
                $objEmployee->address = $data['address'];
                $arrResult[$count] = $objEmployee;
                $count++;
            }
        }
        return $arrResult;
    }

    public function SelectOneEmployee(){
        $sql = "SELECT * FROM employee WHERE ssn = '$this->ssn'";
        $resultOne = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($resultOne) == 1){
            $this->hasil = true;
            $data = mysqli_fetch_assoc($resultOne);
            $this->fname = $data['fname'];
            $this->address = $data['address'];
        }

    }
}
?>