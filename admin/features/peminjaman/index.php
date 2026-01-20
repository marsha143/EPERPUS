<?php
$q = mysqli_query($conn, "
    SELECT nilai 
    FROM pengaturan_denda 
    WHERE nama_setting='denda_harian'
");
$setting = mysqli_fetch_assoc($q);
$denda_harian = $setting['nilai'] ?? 0;
if (isset($_GET['send_email_late'])) {
    require 'send_email_late.php';
    exit;
}

$filter = $_GET['filter'] ?? 'all';
$where = '';

if ($filter == 'dipinjam') {
    $where = "WHERE p.status='Dipinjam'";
} elseif ($filter == 'dikembalikan') {
    $where = "WHERE p.status='Dikembalikan'";
}

$sql = "SELECT 
        p.*, 
        a.nama AS nama_anggota, 
        a.nim_nidn, 
        b.judul_buku,
        b.kode_buku, 
        sb.no_buku_kampus,
        a.email
    FROM peminjaman p
    JOIN anggota a ON a.id_anggota = p.id_anggota
    JOIN stok_buku sb ON sb.id_stok = p.id_stok
    JOIN buku b ON b.id_buku = sb.id_buku
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
        a.nim_nidn,
        b.judul_buku,
        b.kode_buku,
        sb.no_buku_kampus,
        a.email
    FROM peminjaman p
    JOIN anggota a ON a.id_anggota = p.id_anggota
    JOIN stok_buku sb ON sb.id_stok = p.id_stok
    JOIN buku b ON b.id_buku = sb.id_buku
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

    if (!$p) {
        die('Data peminjaman tidak ditemukan');
    }

    // ========= HITUNG DENDA ==========
    $jatuh_tempo = $p['tanggal_kembali'];
    $hari_ini = date('Y-m-d');

    $terlambat = (strtotime($hari_ini) - strtotime($jatuh_tempo)) / 86400;
    if ($terlambat < 0) $terlambat = 0;

    $denda = $terlambat * $denda_harian;

    $id_stok = $p['id_stok'];

    // ========= UPDATE PEMINJAMAN (INI YANG HILANG) ==========
    mysqli_query($conn, "
        UPDATE peminjaman SET
            status = 'Dikembalikan',
            tanggal_dikembalikan = '$hari_ini',
            denda = '$denda'
        WHERE id = '$id'
    ");

    // ========= UPDATE KONDISI BUKU ==========
    mysqli_query($conn, "
        UPDATE stok_buku
        SET id_kondisi = 2
        WHERE id_stok = '$id_stok'
    ");

    // OPTIONAL: refresh halaman
    echo "<script>window.location.href='app?page=peminjaman';</script>";
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Peminjaman</h5>
            <div>
                <a href="app?page=peminjaman&send_email_late=1"
                    onclick="return confirm('Kirim notifikasi ke semua peminjaman terlambat?')"
                    class="btn btn-danger btn-sm">
                    Kirim Notifikasi Terlambat
                </a>
                <a href="app?page=peminjaman&view=export_exel" class="btn btn-primary">Export Excel</a>
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
                            <th>no_buku_kampus</th>
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
                                <td><?= htmlspecialchars($p['no_buku_kampus']) ?></td>
                                <td>Rp.
                                    <?php
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

                                    <?php
                                    $jatuh_tempo = $p['tanggal_kembali'];
                                    $hari_ini = date('Y-m-d');
                                    $terlambat = (strtotime($hari_ini) - strtotime($jatuh_tempo)) / 86400;
                                    $telat = $terlambat > 0;
                                    ?>
                                    <?php if ($p['status'] == 'Dipinjam'): ?>

                                        <!-- Tombol Kembalikan -->
                                        <form method="post" style="display:inline;"
                                            onsubmit="return confirm('Kembalikan buku ini? Denda: Rp <?= number_format($denda_berjalan) ?>');">
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