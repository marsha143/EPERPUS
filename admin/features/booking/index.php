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
    $_GET['id_booking'] = $id_booking;
    include "send_email_acc.php";
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
if (isset($_POST['kirim_tolak'])) {
    $id_booking = $_POST['id_booking'];
    $alasan = $_POST['alasan'];

    // kirim email
    $_POST['id_booking'] = $id_booking;
    $_POST['alasan'] = $alasan;
    include "send_email_tolak.php";

    // hapus booking
    mysqli_query($conn, "DELETE FROM booking WHERE id='$id_booking'");

    echo "<script>
        alert('Booking ditolak & email terkirim');
        window.location.href='app?page=booking';
    </script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="card">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pemesanan Buku</h5>
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

    modalTolak.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');

        modalTolak.querySelector('#tolak_id').value = id;
    });
</script>