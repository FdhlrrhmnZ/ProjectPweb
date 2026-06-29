<?php
// Pastikan file class sudah di-require di index.php atau di sini
require_once 'class/class.user.php';

$userObj = new User();
$listUser = $userObj->SelectAllUser();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen <span class="text-primary">User</span></h2>
        <a href="dashboardadmin.php?page=user" class="btn btn-primary shadow-sm">
            <i class="ti ti-plus"></i> Tambah User
        </a>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listUser)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada data user.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listUser as $row): ?>
                            <tr>
                                <td class="ps-3"><?= $row['userid'] ?></td>
                                <td class="fw-medium"><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['role'] == 'admin' ? 'danger' : 'info' ?>">
                                        <?= ucfirst($row['role']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="dashboardadmin.php?page=user&id=<?= $row['userid'] ?>" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <a href="dashboardadmin.php?page=deleteuser&id=<?= $row['userid'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>