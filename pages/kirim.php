<?php
    require_once('./class/class.Mail.php');

    $to = "alamatemailyangdituju@gmail.com";
    $name = "Nama yang dituju";
    $subject = "Judul email";
    $message = "Hi, <b>". $name . "</b> apa kabar?";

    Mail::SendMail($to, $name, $subject, $message);

    echo "email berhasil dikirim";

?>