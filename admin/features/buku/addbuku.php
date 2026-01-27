<?php
$data = mysqli_query($conn, "SELECT id, nama_penulis FROM penulis");
$penulis = mysqli_fetch_all($data, MYSQLI_ASSOC);

$data2 = mysqli_query($conn, "SELECT id, jenis_genre FROM genre");
$genre = mysqli_fetch_all($data2, MYSQLI_ASSOC);

if (isset($_POST['simpan'])) {
    $cover = $_POST['cover'];
    $judul_buku = $_POST['judul_buku'];
    $isbn = $_POST['isbn'];
    $id_penulis = isset($_POST['id_penulis']) ? (int) $_POST['id_penulis'] : 0;
    $id_genre = isset($_POST['id_genre']) ? (int) $_POST['id_genre'] : 0;
    $tahun_terbit = $_POST['tahun_terbit'];
    $penerbit = $_POST['penerbit'];
    $deskripsi = $_POST['deskripsi'];
    $query = "
        INSERT INTO buku
            (`cover`,`judul_buku`, `isbn`, `id_penulis`, `id_genre`,`tahun_terbit`, `penerbit`, `deskripsi`)
        VALUES
            ('$cover','$judul_buku','$isbn',$id_penulis, '$id_genre','$tahun_terbit','$penerbit','$deskripsi')
    ";
$cekISBN = mysqli_query(
    $conn,
    "SELECT id_buku FROM buku 
     WHERE isbn = '$isbn'"
);

if (mysqli_num_rows($cekISBN) > 0) {
    echo "
        <script>
            alert('ISBN buku sudah digunakan, silakan gunakan ISBN lain.');
            history.back();
        </script>
    ";
    exit;
}
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "
        <script>
            alert('data  berhasil disimpan');
            window.location.href = 'app?page=buku'
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
?>

<form action="" method="POST">

    <body style="background-color: linen;">
        <div class="d-flex justify-content-center mt-5">


            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>TAMBAH BUKU</h2>
                            </div>
                                <strong>penambahan ini hanya berupa detail buku dan belum termasuk stok ⚠️</strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <form>
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="cover" class="form-label">cover buku</label>
                                            <input type="text" class="form-control" id="cover" name="cover"
                                                placeholder="masukkan cover buku" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="judul_buku" class="form-label">judul buku</label>
                                            <input type="text" class="form-control" id="judul_buku" name="judul_buku"
                                                placeholder="masukkan judul buku" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="isbn" class="form-label">isbn</label>
                                            <input type="number" class="form-control" id="isbn" name="isbn"
                                                placeholder="masukkan isbn" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">penulis</label>
                                            <select name="id_penulis" class="form-select js-example-basic-single"
                                                required>
                                                <option value="" hidden>-- Pilih penulis --</option>
                                                <?php foreach ($penulis as $p): ?>
                                                    <option value="<?= $p['id'] ?>">
                                                        <?= $p['nama_penulis'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Genre</label>
                                            <select name="id_genre" class="form-select js-example-basic-single"
                                                required>
                                                <option value="" hidden>-- Pilih genre --</option>
                                                <?php foreach ($genre as $g): ?>
                                                    <option value="<?= $g['id'] ?>">
                                                        <?= $g['jenis_genre'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tahun teribt</label>
                                            <input type="date" name="tahun_terbit" class="form-control"
                                                value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="penerbit" class="form-label">penerbit</label>
                                            <input type="int" class="form-control" id="penerbit" name="penerbit"
                                                placeholder="masukkan penerbit" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="deskripsi" class="form-label">deskripsi</label>
                                            <input type="int" class="form-control" id="deskripsi" name="deskripsi"
                                                placeholder="masukkan deskripsi" required>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" name="simpan" class="btn btn-primary">
                            <i class="fa-solid fa-download"></i>Simpan
                        </button>
                        <a href="app?page=buku" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i>kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>
</body>

</html>