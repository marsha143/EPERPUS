<?php
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../config/db.php';

if (!isset($_POST['id_booking'], $_POST['alasan'])) {
    return;
}

$id = $_POST['id_booking'];
$alasan = $_POST['alasan'];

$q = mysqli_query($conn, "
    SELECT a.nama, a.email, b.judul_buku
    FROM booking bk
    JOIN anggota a ON a.id_anggota = bk.id_anggota
    JOIN buku b ON b.id_buku = bk.id_buku
    WHERE bk.id='$id'
");

$data = mysqli_fetch_assoc($q);
if (!$data) return;

$mail = new PHPMailer(true);
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
$mail->Subject = "Booking Buku Ditolak";
$mail->Body = "
    <h3>Halo {$data['nama']}</h3>
    <p>Booking buku <b>{$data['judul_buku']}</b> <b>DITOLAK</b>.</p>
    <p><b>Alasan:</b><br>$alasan</p>
";

$mail->send();