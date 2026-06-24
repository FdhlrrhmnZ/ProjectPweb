<?php
// ── Original register logic — unchanged ─────────
require_once('./class/user.php');

if (isset($_POST['btnSubmit'])) {
    $inputemail = $_POST["email"];
    $objUser    = new User();
    $objUser->ValidateEmail($inputemail);
    if ($objUser->hasil) {
        echo "<script>alert('Email sudah terdaftar');</script>";
    } else {
        $objUser->email    = $_POST["email"];
        $password          = $_POST['password'];
        $objUser->password = password_hash($password, PASSWORD_DEFAULT);
        $objUser->name     = $_POST["name"];
        $objUser->role     = 'customer';
        $objUser->AddUser();
        if ($objUser->hasil) {
            echo "<script>alert('Registrasi berhasil');</script>";
            echo '<script>window.location="index.php?page=login";</script>';
        }
    }
}
?>

<!-- Pavana-styled register form — logic above is original -->
<div class="pv-auth-wrap">
    <div class="pv-auth-box">
        <h2 class="pv-auth-title">Register</h2>
        <p class="pv-auth-sub">Buat akun Pavana baru.</p>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="30" required placeholder="Nama kamu">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" maxlength="30" required placeholder="hello@email.com">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" maxlength="30" required placeholder="••••••••">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="btnSubmit" class="pv-btn" style="flex:1;justify-content:center;">
                    <i class="ti ti-user-plus"></i> Register
                </button>
                <a href="index.php" class="pv-btn-outline">Batal</a>
            </div>
        </form>

        <p style="font-size:12px;color:var(--pv-fg2);margin-top:1.5rem;text-align:center;">
            Sudah punya akun? <a href="index.php?page=login" style="color:var(--pv-gold);">Login di sini</a>
        </p>
    </div>
</div>
