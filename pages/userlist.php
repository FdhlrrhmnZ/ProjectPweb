<?php
require_once('./class/user.php');
$objUser = new User();
if (isset($_POST['btnSubmit'])) {
    $objUser->ssn     = $_POST['ssn'];
    $objUser->fname   = $_POST['fname'];
    $objUser->address = $_POST['address'];
    if (isset($_GET['ssn'])) {
        $objUser->ssn = $_GET['ssn'];
        $objUser->UpdateEmployee();
    } else {
        $objUser->AddEmployee();
    }
    echo "<script>alert('".$objUser->message."');</script>";
    if ($objUser->hasil) {
        echo "<script>window.location='index.php?page=userlist';</script>";
    }
} else if (isset($_GET['ssn'])) {
    $objUser->ssn = $_GET['ssn'];
    $objUser->SelectOneEmployee();
}
?>
<div class="pv-page-wrap" style="max-width:540px;">
    <h1 class="pv-page-title">Form <span>Karyawan</span></h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">SSN</label>
            <input type="text" class="form-control" name="ssn" value="<?= $objUser->ssn ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="fname" value="<?= $objUser->fname ?>">
        </div>
        <div class="mb-4">
            <label class="form-label">Alamat</label>
            <input type="text" class="form-control" name="address" value="<?= $objUser->address ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="btnSubmit" class="pv-btn"><i class="ti ti-device-floppy"></i> Simpan</button>
            <a href="index.php?page=employeelist" class="pv-btn-outline">Batal</a>
        </div>
    </form>
</div>
