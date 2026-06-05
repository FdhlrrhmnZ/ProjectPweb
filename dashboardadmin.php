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
        <li><a href="dashboardadmin.php">Home</a></li>
        <li><a href="dashboardadmin.php?page=employeelist">Employee List</a></li>
        <li><a href="dashboardadmin.php?page=departmentlist">Department List</a></li>
        <li><a href="dashboardadmin.php?page=userlist">User List</a></li>
        <li><a href="dashboardadmin.php?page=projectlist">Project List</a></li>
        <li><a href="dashboardadmin.php?page=logout">Log Out</a></li>

    </ul>
</div>