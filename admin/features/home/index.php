<?php
$range = $_GET['range'] ?? 'harian';
$startDate = $_GET['start'] ?? null;
$endDate = $_GET['end'] ?? null;

/* DEFAULT JIKA GA PILIH TANGGAL */
if (!$startDate || !$endDate) {
    $startDate = date('Y-m-d', strtotime('-29 days'));
    $endDate = date('Y-m-d');
}

$whereTanggal = "created_at BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'";

$sql = match ($range) {
    'mingguan' => "
        SELECT YEARWEEK(created_at,1) label, COUNT(*) total
        FROM kunjungan
        WHERE $whereTanggal
        GROUP BY label
        ORDER BY label
    ",
    'bulanan' => "
        SELECT DATE_FORMAT(created_at,'%Y-%m') label, COUNT(*) total
        FROM kunjungan
        WHERE $whereTanggal
        GROUP BY label
        ORDER BY label
    ",
    default => "
        SELECT DATE(created_at) label, COUNT(*) total
        FROM kunjungan
        WHERE $whereTanggal
        GROUP BY label
        ORDER BY label
    "
};

$labels = [];
$data = [];

$res = mysqli_query($conn, $sql);
while ($r = mysqli_fetch_assoc($res)) {

    if ($range === 'harian') {
        $labels[] = date('d M', strtotime($r['label']));
    } elseif ($range === 'mingguan') {
        $labels[] = 'Minggu ' . substr($r['label'], -2);
    } else {
        $labels[] = date('M Y', strtotime($r['label'] . '-01'));
    }

    $data[] = (int) $r['total'];
}


function rupiah($angka)
{
    return 'Rp. ' . number_format((int) $angka, 0, ',', '.');
}

$e = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM peminjaman WHERE status='Dipinjam'");
$o = mysqli_fetch_assoc($e) ?: ['jumlah' => 0];
$jumlah_peminjaman = (int) $o['jumlah'];

$a = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM booking WHERE status='Dibooking'");
$b = mysqli_fetch_assoc($a) ?: ['jumlah' => 0];
$jumlah_pemesanan = (int) $b['jumlah'];

$sqlTelat = "
  SELECT 
    p.id,
    a.nama        AS nama_anggota,
    a.nim_nidn    AS nim_nidn,
    b.judul_buku  AS judul_buku,
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
                        <h6 class="mb-0">
                            Grafik Kunjungan
                            (
                            <?= date('d M Y', strtotime($startDate)) ?> –
                            <?= date('d M Y', strtotime($endDate)) ?>)
                        </h6>
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-success"
                                href="?range=harian&start=<?= $startDate ?>&end=<?= $endDate ?>">Harian</a>
                            <a class="btn btn-outline-primary"
                                href="?range=mingguan&start=<?= $startDate ?>&end=<?= $endDate ?>">Mingguan</a>
                            <a class="btn btn-outline-primary"
                                href="?range=bulanan&start=<?= $startDate ?>&end=<?= $endDate ?>">Bulanan</a>
                        </div>
                        <form method="GET" class="d-flex align-items-center gap-2">

                            <!-- RANGE -->
                            <input type="hidden" name="range" value="<?= $range ?>">

                            <input type="date" name="start" value="<?= $_GET['start'] ?? '' ?>"
                                class="form-control form-control-sm">

                            <span>–</span>

                            <input type="date" name="end" value="<?= $_GET['end'] ?? '' ?>"
                                class="form-control form-control-sm">
                            <div class="filter-tanggal">
                                <button class="btn btn-sm btn-outline-primary">
                                    Apply
                                </button>
                            </div>
                        </form>

                    </div>
                    <div class="card-body" style="min-height:240px;">
                        <canvas id="chartKunjungan" style="min-height:240px;"></canvas>
                    </div>
                    <script>
                        window.chartLabels = <?= json_encode($labels) ?>;
                        window.chartData = <?= json_encode($data) ?>;
                    </script>
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
                            <h1 class="text-gradient text-primary"><?= $jumlah_peminjaman ?>+</h1>
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
                            <h1 class="text-gradient text-primary"><?= $jumlah_pemesanan ?>+</h1>
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