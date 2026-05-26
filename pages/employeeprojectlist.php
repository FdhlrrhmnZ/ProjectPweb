<h4 class='title'>
    <span class="text">
        <strong>Employee Project List</strong>
    </span>
</h4>
<a class="btn btn-primary" href="index.php?page=employeeproject">Add</a>
<table class="table table-bordered">
    <tr>
        <th>No.</th>
        <th>SSN</th>
        <th>Name</th>
        <th>Project Code</th>
        <th>Hours</th>
        <th>Action</th>
    </tr>

<?php
require_once "class/class.EmployeeProject.php";
$objEP = new EmployeeProject();
$arrayresult = $objEP->SelectAllEmployeeProject();

if(count($arrayresult) == 0){
    echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
} else {
    $no = 1;
    foreach($arrayresult as $dataEP){
        echo "<tr>
                <td>$no</td>
                <td>$dataEP->ssn</td>
                <td>$dataEP->fname</td>
                <td>$dataEP->pcode</td>
                <td>$dataEP->hours</td>
                <td>
                    <a class="btn btn-warning" href="index.php?page=employeeproject&id='.$dataEP->id.'"> Edit </a>
                    <a class="btn btn-danger" href="index.php?page=employeeprojectdelete&id='.$data->id.'" onclick="return confirm(\'Are you sure you want to delete this record?'\)"> Delete </a>
                </td>
              </tr>";
        $no++;
    }
}
?>
</table>