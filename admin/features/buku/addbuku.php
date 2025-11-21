<?php

if (isset($_POST['simpan'])) {
    $cover = $_POST['cover'];
    $judul_buku = $_POST['judul_buku'];
    $kode_buku = $_POST['kode_buku'];
    $isbn = $_POST['isbn'];
    $nama_penulis = $_POST['nama_penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penerbit = $_POST['penerbit'];
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO `buku`(`cover`,`judul_buku`, `kode_buku`, `isbn`, `nama_penulis`, `tahun_terbit`, `penerbit`, `deskripsi`) VALUES ('$cover','$judul_buku','$kode_buku','$isbn','$nama_penulis','$tahun_terbit','$penerbit','$deskripsi')";
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
    <div class="d-flex justify-content-center mt-5">

        <body style="background-color: linen;">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>TAMBAH BUKU</h2>
                            </div>
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
                                            <label for="kode_buku" class="form-label">kode buku</label>
                                            <input type="int" class="form-control" id="kode_buku" name="kode_buku"
                                                placeholder="masukkan kode buku" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="isbn" class="form-label">isbn</label>
                                            <input type="int" class="form-control" id="isbn" name="isbn"
                                                placeholder="masukkan isbn" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nama_penulis" class="form-label">nama penulis</label>
                                            <input type="int" class="form-control" id="nama_penulis" name="nama_penulis"
                                                placeholder="masukkan nama penulis" required>
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
                        <button type="submit" name="simpan" class="btn btn-primary"><i
                                class="fa-solid fa-download"></i>Simpan</button>
                        <a href="app?page=buku" class="btn btn-secondary"><i
                                class="fa-solid fa-arrow-left"></i>kembali</a>
                    </div>
                </div>
            </div>
    </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
</body>