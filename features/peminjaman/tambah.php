<?php
if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query = "INSERT INTO `peminjaman`(`id_buku`, `id_anggota`, `tanggal_pinjam`, `tanggal_kembali`) VALUES ('$id_buku','$id_anggota','$tanggal_pinjam','$tanggal_kembali')";
    $result = mysqli_query($conn, $query);
    if ($result) {

        echo "
        <script>
        alert('data  berhasil disimpan');
        window.location.href = 'app?page=peminjaman'
        </script>
        ";
    } else {
        echo "
         <script>
        alert('data tidak berhasil disimpan');
        </script>
        ";
    }
}

$data = mysqli_query($conn, "SELECT * FROM buku");
$buku = mysqli_fetch_all($data, MYSQLI_ASSOC);

$data = mysqli_query($conn, "SELECT * FROM anggota");
$anggota = mysqli_fetch_all($data, MYSQLI_ASSOC);
?>
<div class="container mt-4">
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Form Peminjaman</h5>
    </div>
    <div class="card-body">
      <form action="" method="POST">
        <div class="mb-3">
          <label class="form-label">Anggota</label>
          <select name="id_anggota" class="form-select js-example-basic-single" required>
            <option value="" hidden>-- Pilih Anggota --</option>
            <?php foreach ($anggota as $a): ?>
              <option value="<?= $a['id_anggota'] ?>"><?= $a['nim_nidn'] ?> - <?= $a['nama'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Buku</label>
          <select name="id_buku" class="form-select js-example-basic-single" required>
            <option value="" hidden>-- Pilih Buku --</option>
            <?php foreach ($buku as $b): ?>
              <option value="<?= $b['id_buku'] ?>"><?= $b['kode_buku'] ?> - <?= $b['judul_buku'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tanggal Kembali (Jatuh Tempo)</label>
            <input type="date" name="tanggal_kembali" class="form-control"
              value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
          <a href="app?page=peminjaman" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>