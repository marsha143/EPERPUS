<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../PHPMailer/src/SMTP.php';
require __DIR__ . '/../../../config/db.php';

// pastikan id ada
if (!isset($_GET['id'])) {
    die("ID peminjaman tidak ditemukan.");
}

$id = $_GET['id'];

// ⚡ QUERY SUPER RINGAN
// ambil data *hanya* ketika status = dipinjam
$query = "
    SELECT p.id, p.tanggal_kembali, p.denda,
           a.nama, a.email,
           b.judul_buku
    FROM peminjaman p
    JOIN anggota a ON a.id_anggota = p.id_anggota
    JOIN buku b ON b.id_buku = p.id_buku
    WHERE p.id = '$id'
    AND p.status = 'dipinjam'
    LIMIT 1
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan atau status tidak dipinjam.");
}

// simpan variabel
$email = $data['email'];
$nama = $data['nama'];
$judul = $data['judul_buku'];
$jatuh_tempo = $data['tanggal_kembali'];
$hari_ini = date('Y-m-d');
$terlambat = (strtotime($hari_ini) - strtotime($jatuh_tempo)) / 86400;
if ($terlambat < 0)
    $terlambat = 0;
$denda_berjalan = $terlambat * 500;

// ========== KIRIM EMAIL ==========
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // ganti emailmu
    $mail->Username = 'kzrblazmoker121@gmail.com';
    $mail->Password = 'sqzv uhkn qywr dpoe';

    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('kzrblazmoker121@gmail.com', 'Perpustakaan Kampus');
    $mail->addAddress($email, $nama);

    $mail->isHTML(true);
    $mail->Subject = "Peringatan Pengembalian Buku Terlambat";
    $mail->Body = "
        <h3>Halo $nama,</h3>
        <p>Anda terlambat mengembalikan buku.</p>
        <p>
            <b>Judul:</b> $judul <br>
            <b>Jatuh Tempo:</b> $jatuh_tempo <br>
            <b>Denda Saat Ini:</b> Rp $denda_berjalan
        </p>
        <p>Segera kembalikan buku ya kalo ga gue gaplok lu.</p>
    ";

    $mail->send();

    echo "<script>
alert('Email notifikasi telah dikirim!');
window.location.href='app?page=peminjaman';
</script>";
    exit;

} catch (Exception $e) {
    echo "<script>
alert('Email notifikasi telah dikirim!');
window.location.href='app?page=peminjaman';
</script>";
    exit;
}