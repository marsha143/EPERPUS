<?php
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
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Search Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="search_buku.php" method="GET">
                <div class="modal-body">

                    <!-- Judul Buku -->
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku">
                    </div>

                    <!-- ISBN -->
                    <div class="mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Masukkan ISBN">
                    </div>

                    <!-- Penulis -->
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control" placeholder="Masukkan nama penulis">
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun" min="0" class="form-control" placeholder="Contoh: 2020">
                    </div>

                    <!-- Penerbit -->
                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control" placeholder="Masukkan penerbit">
                    </div>

                    <!-- Kode Buku -->
                    <div class="mb-3">
                        <label class="form-label">Kode Buku</label>
                        <input type="number" name="kode_buku" class="form-control" placeholder="Masukkan kode buku">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php include('./layouts/footer.php'); ?>