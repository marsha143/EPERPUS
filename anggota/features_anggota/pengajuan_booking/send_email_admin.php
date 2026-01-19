<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../../config/db.php';

$mail = new PHPMailer(true);

try {
    // SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kzrblazmoker121@gmail.com';
    $mail->Password   = 'sqzv uhkn qywr dpoe';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan kampus');
    $mail->isHTML(true);
    $mail->Subject = 'Notifikasi Booking Buku Baru';

    // TAMBAH SEMUA EMAIL ADMIN
    while ($admin = mysqli_fetch_assoc($admin_result)) {
        $mail->addAddress($admin['email']);
    }

    $mail->Body = "
        <h3>Booking Buku Masuk</h3>
        <p><b>Nama Anggota:</b> $nama_anggota</p>
        <p><b>NIM/NIDN:</b> $nim_nidn</p>
        <p><b>Buku:</b> $judul_buku</p>
        <p><b>Waktu Booking:</b> $waktu_booking</p>
    ";

    $mail->send();

} catch (Exception $e) {
    // email gagal → booking tetap sukses
}