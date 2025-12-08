<?php
// Hapus booking yang lebih dari 24 jam
mysqli_query($conn, "
    DELETE FROM booking 
    WHERE waktu_booking < NOW() - INTERVAL 24 HOUR
");
// Ambil semua request booking
$sql = "
    SELECT b.*, 
           a.nama AS nama_anggota, 
           a.nim_nidn AS nim_nidn,
           bk.judul_buku AS judul_buku,
           bk.kode_buku AS kode_buku
    FROM booking b
    JOIN anggota a ON a.id_anggota = b.id_anggota
    JOIN buku bk ON bk.id_buku = b.id_buku
    ORDER BY b.id DESC
";
$data = mysqli_query($conn, $sql);
$booking = mysqli_fetch_all($data, MYSQLI_ASSOC);


// ACC BOOKING → MASUK PEMINJAMAN
if (isset($_POST['acc_booking'])) {
    $id_booking = $_POST['id'];
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];

    // CEK STOK
    $cek = mysqli_query($conn, "SELECT Qty FROM buku WHERE id_buku='$id_buku'");
    $stok = mysqli_fetch_assoc($cek)['Qty'];

    if ($stok <= 0) {
        echo "<script>
                alert('Stok habis! Buku tidak bisa dipinjam.');
                window.location.href='app?page=booking';
              </script>";
        exit;
    }

    // KURANGI STOK
    mysqli_query($conn, "UPDATE buku SET Qty = Qty - 1 WHERE id_buku='$id_buku'");

    // MASUK PEMINJAMAN
    $today = date('Y-m-d');
    $jatuh_tempo = date('Y-m-d', strtotime('+7 days'));

    mysqli_query($conn, "
        INSERT INTO peminjaman (id_buku, id_anggota, tanggal_pinjam, tanggal_kembali, status)
        VALUES ('$id_buku', '$id_anggota', '$today', '$jatuh_tempo', 'Dipinjam')
    ");

    // HAPUS BOOKING
    mysqli_query($conn, "DELETE FROM booking WHERE id='$id_booking'");

    echo "<script>
            alert('Booking di-ACC & stok dikurangi!');
            window.location.href='app?page=booking';
          </script>";
    exit;
}


// TOLAK BOOKING
if (isset($_POST['tolak_booking'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM booking WHERE id='$id'");

    echo "<script>
            alert('Booking ditolak!');
            window.location.href='app?page=booking';
        </script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="card">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Permintaan Booking</h5>
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
                            <th>Kode Buku</th>
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
                                <td><?= htmlspecialchars($b['kode_buku']) ?></td>
                                <td><?= $b['waktu_booking'] ?></td>

                                <td class="d-flex gap-1">

                                    <!-- ACC -->
                                    <form method="post" action="" onsubmit="return confirm('ACC booking ini?');">
                                        <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                        <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                                        <input type="hidden" name="id_anggota" value="<?= $b['id_anggota'] ?>">

                                        <button class="btn btn-success btn-sm" name="acc_booking">
                                            ACC
                                        </button>
                                    </form>

                                    <!-- TOLAK -->
                                    <form method="post" action="" onsubmit="return confirm('Tolak booking ini?');">
                                        <input type="hidden" name="id" value="<?= $b['id'] ?>">

                                        <button class="btn btn-danger btn-sm" name="tolak_booking">
                                            Tolak
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>