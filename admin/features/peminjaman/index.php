<?php

$filter = $_GET['filter'] ?? 'all';
$where = '';

if ($filter == 'dipinjam') {
  $where = "WHERE p.status='Dipinjam'";
} elseif ($filter == 'dikembalikan') {
  $where = "WHERE p.status='Dikembalikan'";
}

$sql = "SELECT p.*, 
        a.nama AS nama_anggota, 
        a.nim_nidn AS nim_nidn, 
        b.judul_buku AS judul_buku,
        b.kode_buku AS kode_buku
        FROM peminjaman p
        JOIN anggota a ON a.id_anggota = p.id_anggota
        JOIN buku b ON b.id_buku = p.id_buku
        $where
        ORDER BY p.id DESC";

$result = mysqli_query($conn, $sql);
$peminjaman = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
  
  $keyword = $_POST['cari'];
  $data = mysqli_query($conn, "
    SELECT 
    p.*,
      a.nama AS nama_anggota,
      a.nim_nidn AS nim_nidn,
      b.judul_buku AS judul_buku,
      b.kode_buku AS kode_buku
    FROM peminjaman p
    JOIN anggota a ON a.id_anggota = p.id_anggota
    JOIN buku b ON b.id_buku = p.id_buku
    WHERE 
      a.nama LIKE '%$keyword%'
      OR a.nim_nidn LIKE '%$keyword%' 
      OR b.judul_buku LIKE '%$keyword%'
      OR b.kode_buku LIKE '%$keyword%' 
  ");
  $peminjaman = mysqli_fetch_all($data, MYSQLI_ASSOC);

}

if (isset($_POST['kembalikan'])) {
    $id = $_POST['id'];

    $data = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id='$id'");
    $p = mysqli_fetch_assoc($data);

    $id_buku = $p['id_buku'];   // <-- penting

    // ========= HITUNG DENDA ==========
    $jatuh_tempo = $p['tanggal_kembali'];
    $hari_ini = date('Y-m-d');
    $terlambat = (strtotime($hari_ini) - strtotime($jatuh_tempo)) / 86400;
    if ($terlambat < 0) $terlambat = 0;

    $denda = $terlambat * 500;

    // ========= UPDATE PEMINJAMAN ==========
    mysqli_query($conn, "
        UPDATE peminjaman SET 
        status='Dikembalikan',
        tanggal_dikembalikan='$hari_ini',
        denda='$denda'
        WHERE id='$id'
    "); 

    // ========= TAMBAHKAN STOK ==========
    mysqli_query($conn, "UPDATE buku SET Qty = Qty + 1 WHERE id_buku='$id_buku'");

    echo "<script>
            alert('Buku berhasil dikembalikan! Denda: Rp $denda');
            window.location.href='app?page=peminjaman';
          </script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Peminjaman</h5>
            <div>
                <a href="app?page=peminjaman&view=tambah" class="btn btn-primary btn-sm">+ Pinjam Buku</a>
                <a href="app?page=peminjaman&filter=all" class="btn btn-secondary btn-sm">Semua</a>
                <a href="app?page=peminjaman&filter=dipinjam" class="btn btn-warning btn-sm">Dipinjam</a>
                <a href="app?page=peminjaman&filter=dikembalikan" class="btn btn-success btn-sm">Dikembalikan</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 px-4">
                <form class=" align-items-center" action="" role="search" method="POST">
                    <div class="ms-md-auto pe-md-3 align-items-center">
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" type="search" name="cari" placeholder="Search"
                                aria-label="Search">
                        </div>
                    </div>
                </form>
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
                            <th>Kode Buku</th>
                            <th>Denda</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Dikembalikan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peminjaman as $no => $p): ?>
                        <tr>
                            <td><?= $no + 1 ?></td>
                            <td><?= htmlspecialchars($p['nama_anggota']) ?></td>
                            <td><?= htmlspecialchars($p['nim_nidn']) ?></td>
                            <td><?= htmlspecialchars($p['judul_buku']) ?></td>
                            <td><?= htmlspecialchars($p['kode_buku']) ?></td>
                            <td>Rp.
                                <?php
                  $denda_harian = 500;

                  if ($p['status'] == 'Dipinjam') {
                    $jatuh_tempo = $p['tanggal_kembali'];
                    $hari_ini = date('Y-m-d');

                    $terlambat = (strtotime($hari_ini) - strtotime($jatuh_tempo)) / 86400;
                    if ($terlambat < 0)
                      $terlambat = 0;

                    $denda_berjalan = $terlambat * $denda_harian;
                  } else {
                    $denda_berjalan = $p['denda'];
                  }
                  echo $denda_berjalan;
                  ?>
                            </td>
                            <td><?= $p['tanggal_pinjam'] ?></td>
                            <td><?= $p['tanggal_kembali'] ?></td>
                            <td><?= $p['tanggal_dikembalikan'] ?: '-' ?></td>
                            <td>
                                <span
                                    class="btn btn-sm <?= $p['status'] == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success text-white' ?>"
                                    disabled>
                                    <?= $p['status'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($p['status'] == 'Dipinjam'): ?>
                                <form method="post" onsubmit="return confirm('Kembalikan buku ini?');">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button class="btn btn-success btn-sm" name="kembalikan">Kembalikan</button>
                                </form>
                                <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Sudah kembali</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>