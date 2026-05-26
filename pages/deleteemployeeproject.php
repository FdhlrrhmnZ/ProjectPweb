<?php
require_once('./class/class.EmployeeProject.php');
if (isset($_GET['id'])) {
    $objEP = new EmployeeProject();
    $objEP->id = $_GET['id'];
    $objEP->DeleteEmployeeProject();
    echo "<script> alert('$objEP->message'); </script>";
    echo "<script>window.location = 'index.php?p=employeeprojectlist'</script>";
} else {
    echo '<script>window.history.back()</script>';
}
?>