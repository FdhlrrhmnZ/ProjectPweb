<?php

class User extends Connection{
    private $userid = 0;
    private $email = '';
    private $password = '';
    private $name = '';
    private $role = '';
    private $emp;

    private $hasil = false;
    public $message = '';

    public function __get($atribute){
        if (property_exists($this, $atribute)) {
            return $this->$atribute;
        }
    }

    public function __set($atribut, $value){
        if (property_exists($this, $atribut)) {
            $this->$atribut = $value;
        }
    }

    public function AddUser(){
        $sql = "INSERT INTO user(email, password, name, role)
        VALUES ('$this->email', '$this->password', '$this->name', '$this->role')";
        $this->hasil = mysqli_query($this->connection, $sql);

        if ($this->hasil) {
            $this->message = "Data berhasil ditambahkan!";
        } else {
            $this->message = "Data gagal ditambahkan!";
        }
    }

    public function ValidateEmail($inputemail){
        $sql = "SELECT * FROM user
        WHERE email='$inputemail'";

        $result = mysqli_query($this->connection, $sql);
        if (mysqli_num_rows($result) == 1) {
            $this->hasil = true;
            $data = mysqli_fetch_assoc($result);
            $this->userid = $data['userid'];
            $this->password = $data['password'];
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->role = $data['role'];
        }
    }

    public function UpdateUser(){
        $sql = "UPDATE user SET 
                email = '$this->email', 
                password = '$this->password', 
                name = '$this->name', 
                role = '$this->role' 
                WHERE userid = '$this->userid'";
                
        $this->hasil = mysqli_query($this->connection, $sql);

        if ($this->hasil) {
            $this->message = "Data user berhasil diubah!";
        } else {
            $this->message = "Data user gagal diubah: " . mysqli_error($this->connection);
        }
    }

    public function DeleteUser(){
        $sql = "DELETE FROM user WHERE userid = '$this->userid'";
        $this->hasil = mysqli_query($this->connection, $sql);

        if ($this->hasil) {
            $this->message = "Data user berhasil dihapus!";
        } else {
            $this->message = "Data user gagal dihapus: " . mysqli_error($this->connection);
        }
    }

    public function SelectAllUser(){
        $sql = "SELECT * FROM user";
        $query = mysqli_query($this->connection, $sql);
        
        $data = [];
        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function SelectOneUser(){
        $sql = "SELECT * FROM user WHERE userid = '$this->userid'";
        $query = mysqli_query($this->connection, $sql);
        
        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->name = $row['name'];
            $this->role = $row['role'];
            return $row;
        }
        return null;
    }
}

?>