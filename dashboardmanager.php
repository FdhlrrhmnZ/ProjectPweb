<?php
if (!isset($_SESSION)) {
    session_start();
}
require "inc.koneksi.php";

$strwelcome = "Welcome, <b>". $_SESSION["name"]."</b><br>";
$strwelcrole = "Anda login sebagai, <b>". $_SESSION["role"]."</b>";
?>

<div id="navbar3" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li><a href="dashboardmanager.php">Home</a></li>
        <li><a href="dashboardmanager.php?page=profile">View Profile</a></li>
        <li><a href="dashboardmanager.php?page=viewsubordinate">View Subordinate</a></li>
        <li><a href="dashboardmanager.php?page=assignproject">Assign Project</a></li>
        <li><a href="dashboardmanager.php?page=logout">Log Out</a></li>

    </ul>
</div>