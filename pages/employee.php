<?php
require_once('./class/class.employee.php');
$objEmployee = new Employee();
if (isset($_POST['btnSubmit'])) {
    $objEmployee->ssn     = $_POST['ssn'];
    $objEmployee->fname   = $_POST['fname'];
    $objEmployee->address = $_POST['address'];
    if (isset($_GET['ssn'])) {
        $objEmployee->ssn = $_GET['ssn'];
        $objEmployee->UpdateEmployee();
    } else {
        $objEmployee->AddEmployee();
    }
    echo "<script>alert('".$objEmployee->message."');</script>";
    if ($objEmployee->hasil) {
        echo "<script>window.location='index.php?page=employeelist';</script>";
    }
} else if (isset($_GET['ssn'])) {
    $objEmployee->ssn = $_GET['ssn'];
    $objEmployee->SelectOneEmployee();
}
?>
<div class="pv-page-wrap" style="max-width:540px;">
    <h1 class="pv-page-title">Form <span>Karyawan</span></h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">SSN</label>
            <input type="text" class="form-control" name="ssn" value="<?= $objEmployee->ssn ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="fname" value="<?= $objEmployee->fname ?>">
        </div>
        <div class="mb-4">
            <label class="form-label">Alamat</label>
            <input type="text" class="form-control" name="address" value="<?= $objEmployee->address ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="btnSubmit" class="pv-btn"><i class="ti ti-device-floppy"></i> Simpan</button>
            <a href="index.php?page=employeelist" class="pv-btn-outline">Batal</a>
        </div>
    </form>
</div>
