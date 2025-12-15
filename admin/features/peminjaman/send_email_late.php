<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../../config/db.php';

$query = "
    SELECT p.id, p.tanggal_kembali,
           a.nama, a.email,
           b.judul_buku,
           b.cover
    FROM peminjaman p
    JOIN anggota a ON a.id_anggota = p.id_anggota
    JOIN buku b ON b.id_buku = p.id_buku
    WHERE p.status = 'Dipinjam'
      AND p.tanggal_kembali < CURDATE()
      AND (
          p.last_notif_late IS NULL
          OR p.last_notif_late < DATE_SUB(NOW(), INTERVAL 7 DAY)
      )
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>
        alert('Tidak ada peminjaman terlambat yang perlu dikirimi notifikasi.');
        window.location.href='app?page=peminjaman';
    </script>";
    exit;
}

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kzrblazmoker121@gmail.com';
$mail->Password = 'sqzv uhkn qywr dpoe';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan Kampus');
$mail->isHTML(true);

$jumlah_email = 0;

while ($row = mysqli_fetch_assoc($result)) {

    $mail->clearAddresses();

    $email = $row['email'];
    $nama = $row['nama'];
    $judul = $row['judul_buku'];
    $jatuh_tempo = $row['tanggal_kembali'];
    $cover = $row['cover'];

    $hari_ini = date('Y-m-d');
    $terlambat = (strtotime($hari_ini) - strtotime($jatuh_tempo)) / 86400;
    if ($terlambat < 0)
        $terlambat = 0;

    $denda = $terlambat * 500;

    try {
        $mail->addAddress($email, $nama);
        $mail->Subject = "Peringatan Pengembalian Buku Terlambat";
        $mail->Body = "
            <h3>Halo $nama,</h3>
            
            <p>Anda terlambat mengembalikan buku.</p>

            <img src='$cover'
                    width='150'
                    style='border-radius:6px;margin-bottom:10px'><br>

            <p>
                <b>Judul:</b> $judul <br>
                <b>Jatuh Tempo:</b> $jatuh_tempo <br>
                <b>Denda Saat Ini:</b> Rp $denda
            </p>
            <p>Gapapa ga usah di kembaliin, tunggu denda nya 50.000 Rp dlu baru kembaliin yaah (>w<). </p>
        ";

        $mail->send();

        // UPDATE WAKTU TERAKHIR KIRIM NOTIF
        mysqli_query($conn, "
            UPDATE peminjaman
            SET last_notif_late = NOW()
            WHERE id = '{$row['id']}'
        ");

        $jumlah_email++;

    } catch (Exception $e) {
        // skip kalau gagal kirim satu email
        continue;
    }
}

echo "<script>
alert('Notifikasi berhasil dikirim ke $jumlah_email peminjaman terlambat.');
window.location.href='app?page=peminjaman';
</script>";
exit;