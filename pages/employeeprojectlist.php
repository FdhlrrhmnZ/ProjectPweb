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
    require_once('./class/class.EmployeeProject.php');
    $objEP = new EmployeeProject();
    $arrayResult = $objEP->SelectAllEmployeeProject();
    if (count($arrayResult) == 0) {
        echo '<tr><td colspan="6">Tidak ada data!</td></tr>';
    } else {
        $no = 1;
        foreach ($arrayResult as $dataEP) {
            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $dataEP->ssn . '</td>';
            echo '<td>' . $dataEP->fname . '</td>';
            echo '<td>' . $dataEP->pcode . '</td>';
            echo '<td>' . $dataEP->hours . '</td>';
            echo '<td>
<a class="btn btn-warning"
href="index.php?p=employeeproject&id=' . $dataEP->id . '"> Edit </a> |
<a class="btn btn-danger"
href="index.php?p=deleteemployeeproject&id=' . $dataEP->id . '" onclick="return
confirm(\'Apakah anda yakin ingin menghapus?\')"> Delete </a>
</td>';
            echo '</tr>';
            $no++;
        }
    }
    ?>
</table>