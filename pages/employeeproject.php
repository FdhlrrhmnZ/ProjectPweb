<?php
require_once('./class/class.Employee.php');
require_once('./class/class.EmployeeProject.php');

$objEP = new EmployeeProject();
if (isset($_POST['btnSubmit'])) {
    $objEP->ssn = $_POST['ssn'];
    $objEP->pcode = $_POST['pcode'];
    $objEP->hours = $_POST['hours'];

    if (isset($_GET['id'])) {
        $objEP->id = $_GET['id'];
        $objEP->UpdateEmployeeProject();
    } else {
        $objEP->AddEmployeeProject();
    }
    echo "<script>alert('" . $objEP->message . "'); </script>";
    if ($objEP->hasil) {
        echo "<script>window.location='index.php?page=employeeprojectlist'; </script>";
    }
} else if (isset($_GET['id'])) {
    $objEP->id = $_GET['id'];
    $objEP->SelectOneEmployeeProject();
}

$objEmployee = new Employee();
$arrEmployee = $objEP->SelectAllEmployeeProject();
?>

<h4 class="title"><span class="text"><strong>Employee Project</strong></span></h4>
<form action="" method="post">
        <table class="table">
            <tr>
                <td>Employee</td>
                <td>:</td>
                <td>
                    <select class="form-control" name="ssn">
                        <option value="">-- Pilih Employee --</option>
                        <?php foreach ($arrEmployee as $emp) { ?>
                            <option value="<?php echo $emp->ssn; ?>"
                            <?php if ($objEP->ssn == $emp->ssn) echo 'selected'; ?>>
                            <?php echo $emp->fname; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
            <tr><td>Project Code</td>
            <td>:</td>
            <td><input type="text" class="form-control" name="pcode"
                       value="<?php echo $objEP->pcode; ?>"></td>
            </tr>
            <tr><td>Hours</td>
            <td>:</td>
            <td><input type="number" step="0.01" class="form-control" name="hours"
                       value="<?php echo $objEP->hours; ?>"></td>
        </tr>
        <tr><td colspan="2"></td>
            <td><input type="submit" class="btn btn-success" value="Save"
                       name="btnSubmit">
            <a href="index.php?p=employeeprojectlist" class="btn btn-
               warning">Cancel</a>
            </td>
        </tr>
    </table>
</form>