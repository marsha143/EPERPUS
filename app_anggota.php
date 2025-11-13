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
    <a class="navbar-brand  text-white " href="" rel="tooltip" title="Designed and Coded by Creative Tim"
      data-placement="bottom" target="_blank">
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
                <td><img src="<?= $b['cover'] ?>" alt="cover" style="height:48px"></td>
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
<div class="container py-7">
  <div class="row mt-5">
    <div class="col-sm-3 col-6 mx-auto">
      <!-- Button trigger modal -->
      <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Your modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Society has put up so many boundaries, so many limitations on what’s right and wrong that it’s almost
              impossible to get a pure thought out.
              <br><br>
              It’s like a little kid, a little boy, looking at colors, and no one told him what colors are good, before
              somebody tells you you shouldn’t like pink because that’s for girls, or you’d instantly become a gay
              two-year-old.
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn bg-gradient-primary mb-0">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('./layouts/footer.php'); ?>