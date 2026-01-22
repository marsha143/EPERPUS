<?php
if (isset($_POST['simpan'])) {
  $id_buku = $_POST['id_buku'];
  $id_anggota = $_POST['id_anggota'];
  $tanggal_pinjam = $_POST['tanggal_pinjam'];
  $tanggal_kembali = $_POST['tanggal_kembali'];


  // [GANTI] CEK STOK DARI stok_buku

  $cekStok = mysqli_query($conn, "
    SELECT id_stok, kode_buku_takumi 
    FROM stok_buku
    WHERE id_buku = '$id_buku'
      AND id_kondisi = 2
    LIMIT 1
  ");

  if (mysqli_num_rows($cekStok) == 0) {
    echo "
      <script>
        alert('Stok buku tidak tersedia!');
        window.location.href = 'app?page=peminjaman&view=tambah';
      </script>";
    exit;
  }

  $stok = mysqli_fetch_assoc($cekStok);
  $id_stok = $stok['id_stok'];
  $kode_buku_takumi = $stok['kode_buku_takumi'];


  // [GANTI] SIMPAN PEMINJAMAN

  $query = "INSERT INTO peminjaman 
    (id_buku, id_anggota, id_stok, kode_buku_takumi, tanggal_pinjam, tanggal_kembali)
    VALUES
    ('$id_buku','$id_anggota','$id_stok','$kode_buku_takumi','$tanggal_pinjam','$tanggal_kembali')
  ";

  $result = mysqli_query($conn, $query);

  if ($result) {

  
    // [TAMBAH] UPDATE STATUS STOK
   
    $query = "INSERT INTO peminjaman 
(id_buku, id_anggota, id_stok, kode_buku_takumi, tanggal_pinjam, tanggal_kembali, status)
VALUES
('$id_buku','$id_anggota','$id_stok','$kode_buku_takumi','$tanggal_pinjam','$tanggal_kembali','Dipinjam')
";

    // UPDATE KONDISI BUKU → DIPINJAM (id_kondisi = 3)
    mysqli_query($conn, "
  UPDATE stok_buku
  SET id_kondisi = 3
  WHERE id_stok = '$id_stok'
");

    echo "
      <script>
        alert('Peminjaman berhasil!');
        window.location.href = 'app?page=peminjaman';
      </script>";
    exit;

  } else {
    echo "
      <script>
        alert('Peminjaman gagal!');
      </script>
    ";
  }
}

// DATA DROPDOWN (TETAP)

$buku = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM buku"), MYSQLI_ASSOC);
$anggota = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM anggota"), MYSQLI_ASSOC);
?>

<div class="container mt-4">
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Form Peminjaman Buku</h5>
    </div>

    <div class="card-body">
      <form action="" method="POST">

        <!-- ANGGOTA -->
        <div class="mb-3">
          <label class="form-label">Anggota</label>
          <select name="id_anggota" class="form-select js-example-basic-single" required>
            <option value="" hidden>-- Pilih Anggota --</option>
            <?php foreach ($anggota as $a): ?>
              <option value="<?= $a['id_anggota'] ?>">
                <?= $a['nim_nidn'] ?> - <?= $a['nama'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- BUKU -->
        <div class="mb-3">
          <label class="form-label">Buku</label>
          <select name="id_buku" class="form-select js-example-basic-single" required>
            <option value="" hidden>-- Pilih Buku --</option>
            <?php foreach ($buku as $b): ?>
              <option value="<?= $b['id_buku'] ?>">
                <?= $b['judul_buku'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- TANGGAL -->
        <div class="row g-3 mb-3">
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

        <!-- BUTTON -->
        <div class="d-flex gap-2">
          <button type="submit" name="simpan" class="btn btn-primary">
            Simpan
          </button>
          <a href="app?page=peminjaman" class="btn btn-outline-secondary">
            Batal
          </a>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function () {
    $('.js-example-basic-single').select2({
      width: '100%'
    });
  });
</script>