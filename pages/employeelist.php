<div class="pv-page-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
        <h1 class="pv-page-title mb-0">Daftar <span>Karyawan</span></h1>
        <a class="pv-btn" href="index.php?page=employee"><i class="ti ti-plus"></i> Tambah</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr><th>No.</th><th>SSN</th><th>Name</th><th>Address</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php
        require_once('./class/class.Employee.php');
        $objEmployee  = new Employee();
        $arrayResult  = $objEmployee->SelectAllEmployee();
        if (count($arrayResult) == 0) {
            echo '<tr><td colspan="5" style="text-align:center;color:var(--pv-fg3);">Tidak ada data.</td></tr>';
        } else {
            $no = 1;
            foreach ($arrayResult as $d) {
                echo '<tr>';
                echo '<td>'.$no.'</td>';
                echo '<td>'.$d->ssn.'</td>';
                echo '<td>'.$d->fname.'</td>';
                echo '<td>'.$d->address.'</td>';
                echo '<td style="display:flex;gap:6px;">
                    <a class="btn btn-warning btn-sm" href="index.php?page=employee&ssn='.$d->ssn.'">Edit</a>
                    <a class="btn btn-danger btn-sm" href="index.php?page=deleteemployee&ssn='.$d->ssn.'"
                       onclick="return confirm(\'Hapus karyawan ini?\')">Delete</a>
                </td>';
                echo '</tr>';
                $no++;
            }
        }
        ?>
        </tbody>
    </table>
</div>
