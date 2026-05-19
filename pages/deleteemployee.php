<?php
require_once ('./class/class.employee.php');

if(isset($_GET['ssn'])){
    $objEmployee = new Employee();
    $objEmployee->ssn = $_GET['ssn'];
    $objEmployee->DeleteEmployee();

    echo "<script>alert('.$objEmployee->message.'); </script>";
    echo "<script>window.location='index.php?p=employeelist'; </script>";
    
} else {
    echo "<script>window.history.back(); </script>";
}
?>