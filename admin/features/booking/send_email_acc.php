<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../../config/db.php';

if (!isset($_GET['id_booking']))
    return;

$id_booking = $_GET['id_booking'];

$q = mysqli_query($conn, "
    SELECT a.nama, a.email, b.judul_buku
    FROM booking bk
    JOIN anggota a ON a.id_anggota = bk.id_anggota
    JOIN buku b ON b.id_buku = bk.id_buku
    WHERE bk.id='$id_booking'
");

$data = mysqli_fetch_assoc($q);
if (!$data)
    return;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kzrblazmoker121@gmail.com';
    $mail->Password = 'sqzv uhkn qywr dpoe';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan');
    $mail->addAddress($data['email'], $data['nama']);

    $mail->isHTML(true);
    $mail->Subject = "Booking Buku Disetujui";
    $mail->Body = "
        <h3>Halo {$data['nama']}</h3>
        <p>Booking buku kamu telah <b>DISETUJUI</b>.</p>
        <p><b>Judul Buku:</b> {$data['judul_buku']}</p>
        <p>Silakan ambil buku di perpustakaan.</p>
    ";

    $mail->send();
} catch (Exception $e) {
}