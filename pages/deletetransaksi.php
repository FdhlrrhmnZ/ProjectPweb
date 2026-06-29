<?php
require_once ('./class/class.product.php');

if(isset($_GET['idProduk'])){
    $product = new User();
    $product->userid = $_GET['userid'];
    $product->DeleteProduct();

    echo "<script>alert('.$objUser->message.'); </script>";
    echo "<script>window.location='dashboardadmin.php?page=userlist'; </script>";
    
} else {
    echo "<script>window.history.back(); </script>";
}
?>