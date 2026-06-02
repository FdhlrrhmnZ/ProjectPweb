<?php
if (!isset($_SESSION)) {
    session_start();
}
require "inc.koneksi.php";

echo "Welcome, <b>". $_SESSION["name"]."</b><br>";
echo "Anda login sebagai, <b>". $_SESSION["role"]."</b>";
?>