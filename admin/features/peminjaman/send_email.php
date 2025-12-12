<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__. '/../../../PHPMailer/src/Exception.php';
require __DIR__. '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__. '/../../../PHPMailer/src/SMTP.php';

function kirimNotifikasiTerlambat($email_penerima, $nama_penerima, $judul_buku, $jatuh_tempo, $denda_sekarang)
{
    $mail = new PHPMailer(true);

    try {
        // =============== SMTP CONFIG ===================
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;

        // EMAIL PENGIRIM (EMAIL KAMU)
        $mail->Username = 'kzrblazmoker121@gmail.com';
        $mail->Password = 'sqzv uhkn qywr dpoe';

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // =============== EMAIL PENGIRIM =================
        $mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan Kampus');

        // =============== EMAIL PENERIMA =================
        $mail->addAddress($email_penerima, $nama_penerima);

        // =============== ISI PESAN ======================
        $mail->isHTML(true);
        $mail->Subject = "Peringatan Pengembalian Buku Terlambat";

        $mail->Body = "
            <h3>Halo $nama_penerima,</h3>
            <p>Anda memiliki buku yang sudah <b>terlambat dikembalikan</b>.</p>
            <p>
                <b>Judul Buku:</b> $judul_buku<br>
                <b>Jatuh Tempo:</b> $jatuh_tempo<br>
                <b>Denda Saat Ini:</b> Rp $denda_sekarang
            </p>
            <p>Mohon segera mengembalikan buku ke perpustakaan.</p>
            <br>
            <p>Terima kasih.</p>
            <p><b>Perpustakaan Kampus</b></p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
?>