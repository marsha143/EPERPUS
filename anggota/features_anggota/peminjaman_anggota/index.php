<?php
$idAnggota = ($_SESSION['user']['id'] ?? 0);

$sql = "
  SELECT 
    p.id,
    b.cover,
    b.judul_buku,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    p.tanggal_dikembalikan,
    p.status,
    p.denda
  FROM peminjaman p
  JOIN buku b ON p.id_buku = b.id_buku
  WHERE p.id_anggota = $idAnggota
  ORDER BY p.tanggal_pinjam DESC
";

$data = mysqli_query($conn, $sql);
$peminjaman = mysqli_fetch_all($data, MYSQLI_ASSOC);
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>cover</th>
                            <th style="min-width:200px">Judul Buku</th>
                            <th style="min-width:120px">Tgl Pinjam</th>
                            <th style="min-width:120px">Jatuh Tempo</th>
                            <th style="min-width:140px">Status</th>
                            <th style="min-width:140px">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($peminjaman)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data peminjaman.</td>
                        </tr>
                        <?php else: ?>
                        <?php $no=1; foreach ($peminjaman as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><img src="<?= $row['cover']?>" alt="cover" style="height:48px"></td>
                            <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_kembali']) ?></td>
                            <td>
                                <?php if ($row['status'] === 'Dipinjam'): ?>
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                                <?php else: ?>
                                <span class="badge bg-success">Dikembalikan</span>
                                <?php endif; ?>
                                <?php if (!empty($row['tanggal_dikembalikan'])): ?>
                                <small class="text-muted d-block">Kembali:
                                    <?= htmlspecialchars($row['tanggal_dikembalikan']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>Rp. <?= htmlspecialchars($row['denda']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>