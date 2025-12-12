<?php

function rupiah($angka) {
  return 'Rp. ' . number_format((int)$angka, 0, ',', '.');
}

$e = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM peminjaman WHERE status='Dipinjam'");
$o = mysqli_fetch_assoc($e) ?: ['jumlah' => 0];
$jumlah_peminjaman = (int)$o['jumlah'];

$a = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM booking WHERE status='Dibooking'");
$b = mysqli_fetch_assoc($a) ?: ['jumlah' => 0];
$jumlah_pemesanan = (int)$b['jumlah'];

$labelsKunjungan = [];
$dataKunjungan   = [];
$start = new DateTime(date('Y-m-d', strtotime('-29 days')));
$map = [];
for ($i = 0; $i < 30; $i++) {
  $d = (clone $start)->modify("+$i day")->format('Y-m-d');
  $map[$d] = 0;
}

$sqlKunj = "
  SELECT DATE(created_at) AS tgl, COUNT(*) AS jumlah
  FROM kunjungan
  WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
  GROUP BY DATE(created_at)
  ORDER BY tgl
";
if ($res = mysqli_query($conn, $sqlKunj)) {
  while ($row = mysqli_fetch_assoc($res)) {
    $map[$row['tgl']] = (int)$row['jumlah'];
  }
}
foreach ($map as $tgl => $jumlah) {
  $labelsKunjungan[] = date('d M', strtotime($tgl));
  $dataKunjungan[]   = $jumlah;
}

$sqlTelat = "
  SELECT 
    p.id,
    a.nama        AS nama_anggota,
    a.nim_nidn    AS nim_nidn,
    b.judul_buku  AS judul_buku,
    b.kode_buku   AS kode_buku,
    p.tanggal_kembali AS jatuh_tempo,
    GREATEST(DATEDIFF(CURDATE(), p.tanggal_kembali), 0) * 500 AS denda_berjalan
  FROM peminjaman p
  JOIN anggota a ON a.id_anggota = p.id_anggota
  JOIN buku    b ON b.id_buku    = p.id_buku
  WHERE p.status='Dipinjam'
    AND p.tanggal_kembali < CURDATE()
  ORDER BY p.tanggal_kembali ASC, p.id ASC
";
$result = mysqli_query($conn, $sqlTelat);
$peminjaman = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
?>

<main class="main-content max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row p-4">
            <div class="col-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Grafik Kunjungan (30 Hari Terakhir)</h6>
                    </div>
                    <div class="card-body" style="min-height:240px;">
                        <canvas id="chartKunjungan" style="min-height:240px;"></canvas>
                    </div>
                    <div class="card-footer">
                        <p class="mb-0">Kunjungan perpustakaan</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Peminjaman aktif</p>
                            <h1 class="text-gradient text-primary"><?=$jumlah_peminjaman?>+</h1>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p class="mb-0">Buku yang sedang dipinjam</p>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Pemesanan buku</p>
                            <h1 class="text-gradient text-primary"><?=$jumlah_pemesanan?>+</h1>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p class="mb-0">Pemesanan yang harus ditindaklanjuti</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4 p-4">
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Pinjaman melebihi batas pengembalian</h6>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM/NIDN</th>
                                        <th>Judul Buku</th>
                                        <th>Kode Buku</th>
                                        <th>Denda</th>
                                        <th>Jatuh Tempo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($peminjaman)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tidak ada pinjaman yang melewati
                                            jatuh tempo 🎉</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach ($peminjaman as $i => $p): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($p['nama_anggota']) ?></td>
                                        <td><?= htmlspecialchars($p['nim_nidn']) ?></td>
                                        <td><?= htmlspecialchars($p['judul_buku']) ?></td>
                                        <td><?= htmlspecialchars($p['kode_buku']) ?></td>
                                        <td><strong class="text-danger"><?= rupiah($p['denda_berjalan']) ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($p['jatuh_tempo']) ?></td>
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
</main>
<?php include('./admin/layouts/footer.php'); ?>