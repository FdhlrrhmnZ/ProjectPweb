<div class="pv-page-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
        <h1 class="pv-page-title mb-0">Employee <span>Projects</span></h1>
        <a class="pv-btn" href="index.php?page=employeeproject"><i class="ti ti-plus"></i> Tambah</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr><th>No.</th><th>SSN</th><th>Name</th><th>Project Code</th><th>Hours</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php
        require_once('./class/class.EmployeeProject.php');
        $objEP       = new EmployeeProject();
        $arrayResult = $objEP->SelectAllEmployeeProject();
        if (count($arrayResult) == 0) {
            echo '<tr><td colspan="6" style="text-align:center;color:var(--pv-fg3);">Tidak ada data.</td></tr>';
        } else {
            $no = 1;
            foreach ($arrayResult as $d) {
                echo '<tr>';
                echo '<td>'.$no.'</td><td>'.$d->ssn.'</td><td>'.$d->fname.'</td><td>'.$d->pcode.'</td><td>'.$d->hours.'</td>';
                echo '<td style="display:flex;gap:6px;">
                    <a class="btn btn-warning btn-sm" href="index.php?page=employeeproject&id='.$d->id.'">Edit</a>
                    <a class="btn btn-danger btn-sm" href="index.php?page=deleteemployeeproject&id='.$d->id.'"
                       onclick="return confirm(\'Hapus project ini?\')">Delete</a>
                </td>';
                echo '</tr>';
                $no++;
            }
        }
        ?>
        </tbody>
    </table>
</div>
