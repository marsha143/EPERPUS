<?php
// Hapus booking yang lebih dari 24 jam

// ambil email admin
$qAdmin = mysqli_query($conn, "SELECT email FROM admin LIMIT 1");
$admin = mysqli_fetch_assoc($qAdmin);
$email_admin = $admin['email'];

if (isset($_POST['cari']) && $_POST['cari'] !== '') {

    $keyword = mysqli_real_escape_string($conn, $_POST['cari']);

    $query = "
        SELECT b.*, 
               a.nama AS nama_anggota, 
               a.nim_nidn,
               bk.judul_buku
        FROM booking b
        JOIN anggota a ON a.id_anggota = b.id_anggota
        JOIN buku bk ON b.id_buku = bk.id_buku
        WHERE b.status = 'Dibooking'
          AND bk.judul_buku LIKE '%$keyword%'
        ORDER BY b.id DESC
    ";

    $data = mysqli_query($conn, $query);
    $booking = mysqli_fetch_all($data, MYSQLI_ASSOC);
}


// ambil booking expired
$qExpired = mysqli_query($conn, "
    SELECT 
        b.id,
        a.nama AS nama_anggota,
        bk.judul_buku,
        b.waktu_booking
    FROM booking b
    JOIN anggota a ON a.id_anggota = b.id_anggota
    JOIN buku bk ON bk.id_buku = b.id_buku
    WHERE b.status = 'Dibooking'
    AND b.waktu_booking < NOW() - INTERVAL 24 HOUR
");

if (mysqli_num_rows($qExpired) > 0) {

    include "send_email_expired_admin.php";

    mysqli_query($conn, "
        UPDATE booking
        SET status = 'Expired'
        WHERE status = 'Dibooking'
        AND waktu_booking < NOW() - INTERVAL 24 HOUR
    ");
}
// Ambil semua request booking
if (!isset($_POST['cari']) || $_POST['cari'] === '') {

    $sql = "
        SELECT b.*, 
               a.nama AS nama_anggota, 
               a.nim_nidn,
               bk.judul_buku
        FROM booking b
        JOIN anggota a ON a.id_anggota = b.id_anggota
        JOIN buku bk ON bk.id_buku = b.id_buku
        WHERE b.status = 'Dibooking'
        ORDER BY b.id DESC
    ";

    $data = mysqli_query($conn, $sql);
    $booking = mysqli_fetch_all($data, MYSQLI_ASSOC);
}


// ACC BOOKING → MASUK PEMINJAMAN
if (isset($_POST['acc_booking'])) {
    $id_booking = $_POST['id'];
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];


    // CARI STOK BUKU YANG LAYAK PAKAI

    $cekStok = mysqli_query($conn, "
        SELECT id_stok, kode_buku_takumi
        FROM stok_buku
        WHERE id_buku = '$id_buku'
          AND id_kondisi = 2
        LIMIT 1
    ");

    if (mysqli_num_rows($cekStok) == 0) {
        echo "<script>
            alert('Stok buku tidak tersedia!');
            window.location.href='app?page=booking';
        </script>";
        exit;
    }

    $stok = mysqli_fetch_assoc($cekStok);
    $id_stok = $stok['id_stok'];
    $kode_buku_takumi = $stok['kode_buku_takumi'];

    // ===== AMBIL DATA EMAIL SEBELUM BOOKING DIHAPUS =====
    $qEmail = mysqli_query($conn, "
    SELECT 
        a.email,
        a.nama,
        bk.judul_buku
    FROM booking b
    JOIN anggota a ON a.id_anggota = b.id_anggota
    JOIN buku bk ON bk.id_buku = b.id_buku
    WHERE b.id = '$id_booking'
");

    $emailData = mysqli_fetch_assoc($qEmail);

    // MASUK PEMINJAMAN

    $today = date('Y-m-d');
    $jatuh_tempo = date('Y-m-d', strtotime('+7 days'));

    mysqli_query($conn, "
        INSERT INTO peminjaman (
            id_buku,
            id_anggota,
            id_stok,
            kode_buku_takumi,
            tanggal_pinjam,
            tanggal_kembali,
            status
        ) VALUES (
            '$id_buku',
            '$id_anggota',
            '$id_stok',
            '$kode_buku_takumi',
            '$today',
            '$jatuh_tempo',
            'Dipinjam'
        )
    ");


    // UPDATE KONDISI STOK → DIPINJAM

    mysqli_query($conn, "
        UPDATE stok_buku
        SET id_kondisi = 3
        WHERE id_stok = '$id_stok'
    ");


    // HAPUS BOOKING

    mysqli_query($conn, "DELETE FROM booking WHERE id='$id_booking'");


    // KIRIM EMAIL ACC
    $email = $emailData['email'];
    $nama = $emailData['nama'];
    $judul = $emailData['judul_buku'];

    include "send_email_acc.php";

    echo "<script>
        alert('Booking berhasil di-ACC dan masuk ke peminjaman');
        window.location.href='app?page=booking';
    </script>";
    exit;
}
if (isset($_POST['kirim_tolak'])) {
    $id_booking = $_POST['id_booking'];
    $alasan = $_POST['alasan'];

    // === AMBIL DATA EMAIL SEBELUM DIHAPUS ===
    $qEmail = mysqli_query($conn, "
        SELECT 
            a.email,
            a.nama,
            bk.judul_buku
        FROM booking b
        JOIN anggota a ON a.id_anggota = b.id_anggota
        JOIN buku bk ON bk.id_buku = b.id_buku
        WHERE b.id = '$id_booking'
    ");

    $emailData = mysqli_fetch_assoc($qEmail);

    if (!$emailData) {
        echo "<script>
            alert('Data booking tidak ditemukan!');
            window.location.href='app?page=booking';
        </script>";
        exit;
    }

    // === SIAPKAN DATA EMAIL ===
    $email = $emailData['email'];
    $nama  = $emailData['nama'];
    $judul = $emailData['judul_buku'];

    // === KIRIM EMAIL TOLAK ===
    include "send_email_tolak.php";

    // === HAPUS BOOKING ===
    mysqli_query($conn, "DELETE FROM booking WHERE id='$id_booking'");

    echo "<script>
        alert('Booking berhasil ditolak & email terkirim');
        window.location.href='app?page=booking';
    </script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Pemesanan Buku</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <form class=" align-items-center" role="search" method="POST">
                            <div class="ms-md-auto pe-md-3 align-items-center">
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" type="search" name="cari"
                                        placeholder="Search" aria-label="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="text-end">
                            <a href="./app?page=buku&view=addbuku" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-plus"></i>Tambah</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Anggota</th>
                                <th>NIM/NIDN</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Permintaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($booking as $no => $b): ?>
                            <tr>
                                <td><?= $no + 1 ?></td>
                                <td><?= htmlspecialchars($b['nama_anggota']) ?></td>
                                <td><?= htmlspecialchars($b['nim_nidn']) ?></td>
                                <td><?= htmlspecialchars($b['judul_buku']) ?></td>
                                <td><?= $b['waktu_booking'] ?></td>

                                <td class="d-flex gap-1">

                                    <!-- ACC -->
                                    <form method="post" action="" onsubmit="return confirm('ACC booking ini?');">
                                        <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                        <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                                        <input type="hidden" name="id_anggota" value="<?= $b['id_anggota'] ?>">

                                        <button class="btn btn-success btn-sm" name="acc_booking">
                                            Terima
                                        </button>
                                    </form>
                                    <!-- TOLAK -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalTolak" data-id="<?= $b['id'] ?>"
                                        data-nama="<?= htmlspecialchars($b['nama_anggota']) ?>">
                                        Tolak
                                    </button>

                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="modal fade" id="modalTolak" tabindex="-1">
                <div class="modal-dialog">
                    <form method="post" action="app?page=booking">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Booking</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="id_booking" id="tolak_id">

                                <div class="mb-2">
                                    <label>Alasan Penolakan</label>
                                    <textarea name="alasan" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" name="kirim_tolak">
                                    Kirim Penolakan
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const modalTolak = document.getElementById('modalTolak');

    modalTolak.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');

        modalTolak.querySelector('#tolak_id').value = id;
    });
    </script>