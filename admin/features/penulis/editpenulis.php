<?php

if (isset($_GET['id_penulis'])) {
    $id_penulis = $_GET['id_penulis'];
    $query = " SELECT * FROM penulis WHERE id = $id_penulis ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data) {
        header("Location: app");
    }
}
if (isset($_POST['update'])) {
    $nama_penulis = $_POST['nama_penulis'];
    $query = "UPDATE penulis SET `nama_penulis`='$nama_penulis' WHERE id = $id_penulis";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "
            <script> 
                alert('data berhasil diubah.');
                window.location.href = 'app?page=penulis';
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
                            <h2>EDIT PENULIS</h2>
                        </div>
                    </div>
                </div>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nama_penulis" class="form-label">Nama Penulis</label>
                                        <input type="int" class="form-control" id="nama_penulis" name="nama_penulis"
                                            placeholder="masukkan keterangan" value="<?= $data['nama_penulis'] ?>"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <input type="hidden" name="id_penulis" value="<?= $data['id'] ?>">
                        <button type="submit" name="update" class="btn btn-primary"><i
                                class="fa-solid fa-download"></i>Simpan</button>
                        <a href="app?page=penulis" class="btn btn-secondary"><i
                                class="fa-solid fa-arrow-left"></i>kembali</a>
                    </div>
                </form>
            </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
</body>

</html>