<?php
require_once ('./class/class.user.php');

if(isset($_GET['userid'])){
    $objUser = new User();
    $objUser->userid = $_GET['userid'];
    $objUser->DeleteUser();

    echo "<script>alert('.$objUser->message.'); </script>";
    echo "<script>window.location='dashboardadmin.php?page=userlist'; </script>";
    
} else {
    echo "<script>window.history.back(); </script>";
}
?>