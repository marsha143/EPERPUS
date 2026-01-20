<?php
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../config/db.php';

if (!isset($email, $nama, $judul, $alasan)) {
    return;
}

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kzrblazmoker121@gmail.com';
$mail->Password = 'sqzv uhkn qywr dpoe';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan');
$mail->addAddress($email, $nama);

$mail->isHTML(true);
$mail->Subject = "Booking Buku Ditolak";
$mail->Body = "
    <h3>Halo $nama</h3>
    <p>Booking buku <b>$judul</b> <b>DITOLAK</b>.</p>
    <p><b>Alasan:</b><br>$alasan</p>
";

$mail->send();