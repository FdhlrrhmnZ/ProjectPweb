<?php
require_once('./class/class.Employee.php');
require_once('./class/class.EmployeeProject.php');

$objEP = new EmployeeProject();
if (isset($_POST['btnSubmit'])) {
    $objEP->ssn   = $_POST['ssn'];
    $objEP->pcode = $_POST['pcode'];
    $objEP->hours = $_POST['hours'];
    if (isset($_GET['id'])) {
        $objEP->id = $_GET['id'];
        $objEP->UpdateEmployeeProject();
    } else {
        $objEP->AddEmployeeProject();
    }
    echo "<script>alert('".$objEP->message."');</script>";
    if ($objEP->hasil) {
        echo "<script>window.location='index.php?page=employeeprojectlist';</script>";
    }
} else if (isset($_GET['id'])) {
    $objEP->id = $_GET['id'];
    $objEP->SelectOneEmployeeProject();
}
$objEmployee = new Employee();
$arrEmployee = $objEmployee->SelectAllEmployee();
?>
<div class="pv-page-wrap" style="max-width:540px;">
    <h1 class="pv-page-title">Form <span>Employee Project</span></h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Employee</label>
            <select class="form-control" name="ssn">
                <option value="">-- Pilih Employee --</option>
                <?php foreach ($arrEmployee as $emp): ?>
                <option value="<?= $emp->ssn ?>" <?= ($objEP->ssn == $emp->ssn) ? 'selected' : '' ?>>
                    <?= $emp->fname ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Project Code</label>
            <input type="text" class="form-control" name="pcode" value="<?= $objEP->pcode ?>">
        </div>
        <div class="mb-4">
            <label class="form-label">Hours</label>
            <input type="number" step="0.01" class="form-control" name="hours" value="<?= $objEP->hours ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="btnSubmit" class="pv-btn"><i class="ti ti-device-floppy"></i> Simpan</button>
            <a href="index.php?page=employeeprojectlist" class="pv-btn-outline">Batal</a>
        </div>
    </form>
</div>
