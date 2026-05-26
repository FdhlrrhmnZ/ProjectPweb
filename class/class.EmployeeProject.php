<?php
class EmployeeProject extends Connection{
    private $id = '';
    private $ssn = '';
    private $pcode = '';
    private $hours = '';

    private $fname = '';
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

    public function AddEmployeeProject(){
        $sql = "INSERT INTO employeeproject (ssn, pcode, hours) VALUES ('$this->ssn', '$this->pcode', '$this->hours')";
        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data berhasil ditambahkan";
        } else {
            $this->message = "Data gagal ditambahkan: " . mysqli_error($this->connection);
        }
    }

    public function UpdateEmployeeProject(){
        $sql = "UPDATE employeeproject 
                SET ssn='$this->ssn', 
                pcode='$this->pcode', 
                hours='$this->hours' 
                WHERE id='$this->id'";

        $this->hasil = mysqli_query($this->connection, $sql);

        if($this->hasil){
            $this->message = "Data berhasil diupdate";
        } else {
            $this->message = "Data gagal diupdate: " . mysqli_error($this->connection);
        }
    }

    public function SelectAllEmployeeProject(){
        $sql = "SELECT ep.id, ep.ssn, e.fname, ep.pcode, ep.hours 
                FROM employeeproject ep 
                INNER JOIN employee e ON ep.ssn = e.ssn
                ORDER BY ep.id";

        $result = mysqli_query($this->connection, $sql);
        $arrResult = array();
        $count = 0;

        if(mysqli_num_rows($result) > 0){
            while ($data = mysqli_fetch_array($result)){
                $objEP = new EmployeeProject();
                $objEP->id = $data['id'];
                $objEP->ssn = $data['ssn'];
                $objEP->fname = $data['fname'];
                $objEP->pcode = $data['pcode'];
                $objEP->hours = $data['hours'];
                $arrResult[$count] = $objEP;
                $count++;
            }
        }
        return $arrResult;
    }

    public function SelectOneEmployeeProject(){
        $sql = "SELECT ep.*, e.fname
                FROM employeeproject ep 
                INNER JOIN employee e ON ep.ssn = e.ssn
                WHERE ep.id='$this->id'";

        $resultOne = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($resultOne) == 1){
            $data = mysqli_fetch_array($resultOne);
            $this->ssn = $data['ssn'];
            $this->fname = $data['fname'];
            $this->pcode = $data['pcode'];
            $this->hours = $data['hours'];
        }
    }
}
?>