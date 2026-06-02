<?php
require_once('./class/user.php');

if (isset($_POST['btnLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $objUser = new User();
    $objUser->hasil = true;
    $objUser->ValidateEmail($email);
    if ($objUser->hasil) {
        $ismatch = password_verify($password, $objUser->password);
        if ($ismatch) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION["userid"] = $objUser->userid;
            $_SESSION["role"] = $objUser->role;
            $_SESSION["name"] = $objUser->name;
            $_SESSION["email"] = $objUser->email;
            echo "<script>alert('Login sukses');</script>";
            if ($objUser->role == 'employee')
                echo '<script>window.location = "dashboardemployee.php";</script>';
            else if ($objUser->role == 'manager')
                echo '<script>window.location = "dashboardmanager.php";</script>';
            else if ($objUser->role == 'admin')
                echo '<script>window.location = "dashboardadmin.php";</script>';
        } else {
            echo "<script>alert('Password tidak match');</script>";
        }
    } else {
        echo "<script>alert('Email tidak terdaftar');</script>";
    }
}
?>

<h4 class="title"><span class="text"><strong>Login</strong></span></h4>
<form action="" method="post">
    <table class="table" border="0">
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>
                <input type="email" name="email" id="email" class="form-control" maxlength="30" required>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td>
                <input type="password" name="password" id="password" class="form-control" maxlength="30" required>
        </tr>
        <td></td>
        <td></td>
        <td><input type="submit" class="btn btn-success" value="Login" name="btnLogin">
            <a href="index.php" class="btn btn-danger">Cancel</a>
        </td>
        </tr>
    </table>
</form>