<?php
$data = mysqli_query($conn, "SELECT * FROM penulis");
$penulis = mysqli_fetch_all($data, MYSQLI_ASSOC);
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];
    $query = " SELECT * FROM buku WHERE id_buku = $id_buku ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data) {
        header("Location: app");
    }
}
if (isset($_POST['update'])) {
    $cover = $_POST['cover'];
    $judul_buku = $_POST['judul_buku'];
    $kode_buku = $_POST['kode_buku'];
    $isbn = $_POST['isbn'];
    $nama_penulis = $_POST['nama_penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penerbit = $_POST['penerbit'];
    $deskripsi = $_POST['deskripsi'];
    $query = "UPDATE buku SET `cover`='$cover',`judul_buku`='$judul_buku', `kode_buku`='$kode_buku',`isbn`='$isbn',`nama_penulis`='$nama_penulis',`tahun_terbit`='$tahun_terbit',`deskripsi`='$deskripsi', `updated_at`=NOW() WHERE `id_buku`='$id_buku'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "
            <script> 
                alert('data berhasil diubah.');
                window.location.href = 'app?page=buku';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('data gagal diubah.');
            </script>
            ";
    }
}

?>

<div class="d-flex justify-content-center mt-5">

    <body style="background-color: linen;">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>EDIT BUKU</h2>
                        </div>
                    </div>
                </div>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="cover" class="form-label">cover</label>
                                        <input type="text" class="form-control" id="cover" name="cover"
                                            placeholder="masukkan cover buku" value="<?= $data['cover'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="judul_buku" class="form-label">judul buku</label>
                                        <input type="int" class="form-control" id="judul_buku" name="judul_buku"
                                            placeholder="masukkan keterangan" value="<?= $data['judul_buku'] ?>"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="kode_buku" class="form-label">kode buku</label>
                                        <input type="text" class="form-control" id="kode_buku" name="kode_buku"
                                            placeholder="masukkan kode_buku" value="<?= $data['kode_buku'] ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="isbn" class="form-label">isbn</label>
                                        <input type="int" class="form-control" id="isbn" name="isbn"
                                            placeholder="masukkan keterangan" value="<?= $data['isbn'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">penulis</label>
                                        <select name="nama_penulis" class="form-select js-example-basic-single"
                                            required>
                                            <option value="" hidden>-- Pilih penulis --</option>
                                            <?php foreach ($penulis as $p): ?>
                                            <?php 
            $selected = ($data['nama_penulis'] == $p['nama_penulis']) ? 'selected' : '';
                                            ?>
                                            <option value="<?= $p['nama_penulis'] ?>" <?= $selected ?>>
                                                <?= $p['nama_penulis'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit"
                                            placeholder="masukkan keterangan"
                                            value="<?= $data['tahun_terbit'] ?><?= date('Y-m-d') ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="penerbit" class="form-label">penerbit</label>
                                        <input type="text" class="form-control" id="penerbit" name="penerbit"
                                            placeholder="masukkan penerbit" value="<?= $data['penerbit'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="deskripsi" class="form-label">deskripsi</label>
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                            placeholder="masukkan deskripsi" value="<?= $data['deskripsi'] ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                        <button type="submit" name="update" class="btn btn-primary"><i
                                class="fa-solid fa-download"></i>Simpan</button>
                        <a href="app?page=buku" class="btn btn-secondary"><i
                                class="fa-solid fa-arrow-left"></i>kembali</a>
                    </div>
                </form>
            </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
</body>

</html>