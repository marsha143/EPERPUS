<?php
$idAnggota = ($_SESSION['user']['id'] ?? 0);

$sql = "
SELECT 
    bk.id,
    b.cover,
    b.kode_buku,
    b.judul_buku,
    bk.waktu_booking 
FROM booking bk
JOIN buku b ON bk.id_buku = b.id_buku
WHERE bk.id_anggota = $idAnggota
ORDER BY bk.waktu_booking DESC
";

$data = mysqli_query($conn, $sql);
$booking = mysqli_fetch_all($data, MYSQLI_ASSOC);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Pengajuan Booking</h4>
        <a href="app_anggota?page=pengajuan_booking&view=addbooking" class="btn btn-primary btn-sm">+ Tambah Booking</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>Cover</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th style="min-width:150px">Tanggal Pengajuan</th>
                            <th style="min-width:140px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($booking)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada pengajuan booking.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($booking as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src="<?= $row['cover'] ?>" alt="cover" style="height:48px"></td>
                                    <td><?= htmlspecialchars($row['kode_buku']) ?></td>
                                    <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                    <td><?= htmlspecialchars($row['waktu_booking']) ?></td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Proses Pengajuan</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>