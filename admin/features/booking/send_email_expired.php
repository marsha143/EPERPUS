<?php
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__.'/../../../PHPMailer/src/PHPMailer.php';
require __DIR__.'/../../../PHPMailer/src/SMTP.php';
require __DIR__.'/../../../PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

// ambil email admin
$admins = mysqli_query($conn, "SELECT email FROM admin");

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kzrblazmoker121@gmail.com';
$mail->Password = 'sqzv uhkn qywr dpoe';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('kzrblazmoker121@gmail.com', 'E-Perpus');
$mail->isHTML(true);
$mail->Subject = 'Booking Terlewat (Expired)';

while ($a = mysqli_fetch_assoc($admins)) {
    $mail->addAddress($a['email']);
}

$mail->Body = $body;
$mail->send();