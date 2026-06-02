<?php
if (!isset($_SESSION)) {
    session_start();
}
require "inc.koneksi.php";

echo "Welcome, <b>". $_SESSION["name"]."</b><br>";
echo "Anda login sebagai, <b>". $_SESSION["role"]."</b>";
?>

<div id="navbar3" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li><a href="dashboardemployee.php">Home</a></li>
        <li><a href="dashboardemployee.php?page=profile">View Profile</a></li>
        <li><a href="dashboardemployee.php?page=viewproject">View Project</a></li>
        <li><a href="dashboardemployee.php?page=logout">Log Out</a></li>

    </ul>
</div>