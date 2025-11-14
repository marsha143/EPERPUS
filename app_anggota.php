<?php 
include("./config/db.php"); 
include('./layouts/header.php'); 
$data = mysqli_query($conn, "
  SELECT 
    b.*, 
    CASE 
      WHEN p.status = 'Dipinjam' THEN 'Dipinjam'
      ELSE 'Tersedia'
    END AS status_buku
  FROM buku b
  LEFT JOIN peminjaman p 
    ON b.id_buku = p.id_buku 
    AND p.status = 'Dipinjam'
  
");
$buku = mysqli_fetch_all($data, MYSQLI_ASSOC);

?>
<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent ">
    <div class="container">
        <div class="container">
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon mt-2">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
                <ul class="navbar-nav navbar-nav-hover ms-auto">
                    <li class="nav-item dropdown dropdown-hover mx-2 ms-lg-6">
                        <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
                            Pages
                            <img src="./assets/img/down-arrow-white.svg" alt="down-arrow"
                                class="arrow ms-auto ms-md-2 d-lg-block d-none">
                            <img src="./assets/img/down-arrow-dark.svg" alt="down-arrow"
                                class="arrow ms-auto ms-md-2 d-lg-none d-block">
                        </a>
                    </li>

                    <li class="nav-item dropdown dropdown-hover mx-2">
                        <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuBlocks"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons opacity-6 me-2 text-md">view_day</i>
                            Sections
                            <img src="./assets/img/down-arrow-white.svg" alt="down-arrow"
                                class="arrow ms-auto ms-md-2 d-lg-block d-none">
                            <img src="./assets/img/down-arrow-dark.svg" alt="down-arrow"
                                class="arrow ms-auto ms-md-2 d-lg-none d-block">
                        </a>
                    </li>

                    <li class="nav-item my-auto ms-3 ms-lg-0">
                        <a href="logout" class="btn btn-sm  bg-white  mb-0 me-1 mt-2 mt-md-0">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
        </div>
    </div>
</nav>
<header class="bg-gradient-dark">
    <div class="page-header min-vh-10" style="background-image: url('./assets/img/bg9.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 text-center mx-auto my-auto">
                    <h1 class="text-white">EPERPUS</h1>
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
            <h5 class="mb-3">Daftar Buku</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Cover</th>
                            <th>Judul Buku</th>
                            <th>Kode Buku</th>
                            <th>ISBN</th>
                            <th>Nama Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>Penerbit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buku as $b): ?>
                        <tr>
                            <td><img src="<?= $b['cover']?>" alt="cover" style="height:48px"></td>
                            <td><?= $b['judul_buku'] ?></td>
                            <td><?= $b['kode_buku'] ?></td>
                            <td><?= $b['isbn'] ?></td>
                            <td><?= $b['nama_penulis'] ?></td>
                            <td><?= $b['tahun_terbit'] ?></td>
                            <td><?= $b['penerbit'] ?></td>
                            <td>
                                <?php if ($b['status_buku'] == 'Dipinjam'): ?>
                                <span class="badge bg-danger">Dipinjam</span>
                                <?php else: ?>
                                <span class="badge bg-success">Tersedia</span>
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
</div>
</div>

<?php include('./layouts/footer.php'); ?>