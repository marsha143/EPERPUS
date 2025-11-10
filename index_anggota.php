<?php include("./config/db.php"); ?>
<?php include('./layouts/header.php'); ?>
<?php

$idAnggota = isset($_GET['id_anggota']) ? (int) $_GET['id_anggota'] : 0;

$sql = "
  SELECT 
    p.id,
    b.cover,
    b.kode_buku,
    b.judul_buku,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    p.tanggal_dikembalikan,
    p.status
  FROM peminjaman p
  JOIN buku b ON b.id_buku = p.id_buku
  WHERE p.id_anggota = $idAnggota
";

$sql .= " ORDER BY p.id DESC";

$res = mysqli_query($conn, $sql);
$peminjaman = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
?>

<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent ">
    <div class="container">
        <a class="navbar-brand  text-white " href=""
            rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
            EPERPUS
        </a>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
            <ul class="navbar-nav navbar-nav-hover ms-auto">
                <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center"
                    id="dropdownMenuPages8" data-bs-toggle="dropdown" aria-expanded="false">
                    <li class="nav-item my-auto ms-3 ms-lg-0">
                        <a href="logout" class="btn btn-sm  bg-white  mb-0 me-1 mt-2 mt-md-0">Logout</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>
<header class="bg-gradient-dark">
    <div class="page-header min-vh-10" style="background-image: url('./assets/img/bg9.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mx-auto my-auto">
                    <h1 class="text-white">Selamat datang</h1>
                    <p class="lead mb-4 text-white opacity-8"></p>
                    <h6 class="text-white mb-2 mt-5"></h6>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px">No</th>
                            <th>cover</th>
                            <th style="min-width:110px">Kode Buku</th>
                            <th style="min-width:200px">Judul Buku</th>
                            <th style="min-width:120px">Tgl Pinjam</th>
                            <th style="min-width:120px">Jatuh Tempo</th>
                            <th style="min-width:140px">Status</th>
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
                            <td><?= htmlspecialchars($row['kode_buku']) ?></td>
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

<?php include('./layouts/footer.php'); ?>