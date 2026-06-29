<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Original login logic — unchanged ────────────
require_once('./class/class.user.php');

if (isset($_POST['btnLogin'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $objUser  = new User();
    $objUser->hasil = true;
    $objUser->ValidateEmail($email);
    if ($objUser->hasil) {
        $ismatch = password_verify($password, $objUser->password);
        if ($ismatch) {
            $_SESSION["userid"] = $objUser->userid;
            $_SESSION["role"]   = $objUser->role;
            $_SESSION["name"]   = $objUser->name;
            $_SESSION["email"]  = $objUser->email;
            echo "<script>alert('Login sukses');</script>";
            if ($objUser->role == 'employee')
                echo '<script>window.location="dashboardemployee.php";</script>';
            else if ($objUser->role == 'manager')
                echo '<script>window.location="dashboardmanager.php";</script>';
            else if ($objUser->role == 'admin')
                echo '<script>window.location="dashboardadmin.php?page=adminhome";</script>';
            else if ($objUser->role == 'customer')
                echo '<script>window.location="index.php?page=home";</script>';
        } else {
            echo "<script>alert('Password tidak match');</script>";
        }
    } else {
        echo "<script>alert('Email tidak terdaftar');</script>";
    }
}
?>

<!-- Pavana-styled login form — logic above is original -->
<div class="pv-auth-wrap">
    <div class="pv-auth-box">
        <h2 class="pv-auth-title">Login</h2>
        <p class="pv-auth-sub">Masuk ke akun Pavana kamu.</p>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" maxlength="30" required placeholder="hello@email.com">
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" maxlength="30" required placeholder="••••••••">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="btnLogin" class="pv-btn" style="flex:1;justify-content:center;">
                    <i class="ti ti-login"></i> Login
                </button>
                <a href="index.php" class="pv-btn-outline">Batal</a>
            </div>
        </form>

        <p style="font-size:12px;color:var(--pv-fg2);margin-top:1.5rem;text-align:center;">
            Belum punya akun? <a href="index.php?page=register" style="color:var(--pv-gold);">Register di sini</a>
        </p>
    </div>
</div>
