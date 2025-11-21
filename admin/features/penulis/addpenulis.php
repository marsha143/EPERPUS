<?php

if (isset($_POST['simpan'])) {
    $nama_penulis = $_POST['nama_penulis'];

    $query = "INSERT INTO `penulis`(`nama_penulis`) VALUES ('$nama_penulis')";
    $result = mysqli_query($conn, $query);
    if ($result) {

        echo "
        <script>
        alert('data  berhasil disimpan');
        window.location.href = 'app?page=penulis'
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
                                            <label for="nama_penulis" class="form-label">nama penulis</label>
                                            <input type="int" class="form-control" id="nama_penulis" name="nama_penulis"
                                                placeholder="masukkan nama_penulis" required>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" name="simpan" class="btn btn-primary"><i
                                class="fa-solid fa-download"></i>Simpan</button>
                        <a href="app?page=penulis" class="btn btn-secondary"><i
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