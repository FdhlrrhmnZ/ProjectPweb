<?php
require_once('./class/class.user.php');
$objUser = new User();
if (isset($_POST['btnSubmit'])) {
    $objUser->userid     = $_POST['userid'];
    $objUser->name   = $_POST['name'];
    $objUser->email  = $_POST['email'];
    $objUser->password = $_POST['password'];
    $objUser->role = $_POST['role'];
    if (isset($_GET['userid'])) {
        $objUser->userid = $_GET['userid'];
        $objUser->UpdateUser();
    } else {
        $objUser->AddUser();
    }
    echo "<script>alert('".$objUser->message."');</script>";
    if ($objUser->hasil) {
        echo "<script>window.location='dashboardadmin.php?page=userlist';</script>";
    }
} else if (isset($_GET['userid'])) {
    $objUser->userid = $_GET['userid'];
    $objUser->SelectOneUser();
}
?>
<div class="pv-page-wrap" style="max-width:540px;">
    <h1 class="pv-page-title">Form <span>User</span></h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">ID</label>
            <input type="text" class="form-control" name="userid" value="<?= $objUser->userid ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" value="<?= $objUser->nama ?>">
        </div>
        <div class="mb-4">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" name="email" value="<?= $objUser->email ?>">
        </div>
        <div class="mb-5">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" value="<?= $objUser->password ?>">
        </div>
        <div class="mb-6">
            <label class="form-label">Role</label>
            <input type="text" class="form-control" name="role" value="<?= $objUser->role ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="btnSubmit" class="pv-btn"><i class="ti ti-device-floppy"></i> Simpan</button>
            <a href="dashboardadmin.php?page=userlist" class="pv-btn-outline">Batal</a>
        </div>
    </form>
</div>
