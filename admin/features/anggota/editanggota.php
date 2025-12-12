<?php

if (isset($_GET['id_anggota'])) {
    $id_anggota = $_GET['id_anggota'];
    $query = " SELECT * FROM anggota WHERE id_anggota = $id_anggota ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    if (!$data) {
        header("Location: app");
    }
}
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $nim_nidn = $_POST['nim_nidn'];
    $program_studi = $_POST['program_studi'];
    $waktu_bergabung = $_POST['waktu_bergabung'];
    $alamat = $_POST['alamat'];
    $noHP = $_POST['noHP'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email_anggota = $_POST['email'];
    $query = "UPDATE anggota SET `nama`='$nama', `nim_nidn`='$nim_nidn', `program_studi`='$program_studi',`waktu_bergabung`='$waktu_bergabung',`alamat`='$alamat',`noHP`='$noHP',`jenis_kelamin`='$jenis_kelamin',`email`='$email_anggota',`updated_at`=NOW() WHERE `id_anggota`='$id_anggota'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "
            <script> 
                alert('data berhasil diubah.');
                window.location.href = 'app?page=anggota';
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
                            <h2>EDIT ANGGOTA</h2>
                        </div>
                    </div>
                </div>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="masukkan nama anggota" value="<?= $data['nama'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nim_nidn" class="form-label">nim/nidn</label>
                                        <input type="int" class="form-control" id="nim_nidn" name="nim_nidn"
                                            placeholder="masukkan nim/nidn" value="<?= $data['nim_nidn'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="program_studi" class="form-label">program studi</label>
                                        <input type="text" class="form-control" id="program_studi" name="program_studi"
                                            placeholder="masukkan program_studi" value="<?= $data['program_studi'] ?>"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="label" class="form-label">waktu bergabung</label>
                                        <input type="date" class="form-control" id="waktu_bergabung"
                                            name="waktu_bergabung" placeholder="masukkan keterangan"
                                            value="<?= $data['waktu_bergabung'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="alamat" class="form-label">alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            placeholder="masukkan alamat" value="<?= $data['alamat'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="noHP" class="form-label">noHP</label>
                                        <input type="int" class="form-control" id="noHP" name="noHP"
                                            placeholder="masukkan keterangan" value="<?= $data['noHP'] ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">jenis kelamin</label>
                                        <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                            placeholder="masukkan jenis_kelamin" value="<?= $data['jenis_kelamin'] ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="masukkan email anggota" value="<?= $data['email'] ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="hidden" name="id_anggota" value="<?= $data['id_anggota'] ?>">
                            <button type="submit" name="update" class="btn btn-primary"><i
                                    class="fa-solid fa-download"></i>Simpan</button>
                            <a href="app?page=anggota" class="btn btn-secondary"><i
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