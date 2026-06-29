<?php
require_once ('./class/class.product.php');

if(isset($_GET['idProduk'])){
    $product = new Product();
    $product->userid = $_GET['userid'];
    $product->DeleteProduct();

    echo "<script>alert('.$product->message.'); </script>";
    echo "<script>window.location='dashboardadmin.php?page=admincatalog'; </script>";
    
} else {
    echo "<script>window.history.back(); </script>";
}
?>