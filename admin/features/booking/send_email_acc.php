<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
    
if (!isset($email, $nama, $judul)) {
    return;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kzrblazmoker121@gmail.com';
    $mail->Password   = 'sqzv uhkn qywr dpoe';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan');
    $mail->addAddress($email, $nama);

    $mail->isHTML(true);
    $mail->Subject = "Booking Buku Disetujui";
    $mail->Body = "
        <h3>Halo $nama</h3>
        <p>Booking buku kamu telah <b>DISETUJUI</b>.</p>
        <p><b>Judul Buku:</b> $judul</p>
        <p>Silakan ambil buku di perpustakaan.</p>
    ";

    $mail->send();
} catch (Exception $e) {
    // optional: log error
}