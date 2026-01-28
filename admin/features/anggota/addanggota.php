<?php
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $nim_nidn = $_POST['nim_nidn'];
    $program_studi = $_POST['program_studi'];
    $waktu_bergabung = $_POST['waktu_bergabung'];
    $alamat = $_POST['alamat'];
    $noHP = $_POST['noHP'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email_anggota = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT id_anggota FROM anggota WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan'); window.history.back();</script>";
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id_anggota FROM anggota WHERE nim_nidn='$nim_nidn'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIM/NIDN sudah terdaftar'); window.history.back();</script>";
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id_anggota FROM anggota WHERE email='$email_anggota'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar'); window.history.back();</script>";
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id_anggota FROM anggota WHERE noHP='$noHP'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('No HP sudah terdaftar'); window.history.back();</script>";
        exit;
    }

    $cek = mysqli_query($conn, "SELECT id_anggota FROM anggota WHERE nama='$nama'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Nama sudah terdaftar'); window.history.back();</script>";
        exit;
    }

    $query = "
        INSERT INTO anggota 
        (nama, nim_nidn, program_studi, waktu_bergabung, alamat, noHP, jenis_kelamin, username, email, password)
        VALUES
        ('$nama','$nim_nidn','$program_studi','$waktu_bergabung','$alamat','$noHP','$jenis_kelamin','$username','$email_anggota','$password')
    ";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil disimpan'); window.location.href='app?page=anggota';</script>";
    } else {
        echo "<script>alert('Data gagal disimpan');</script>";
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
                                <h2>TAMBAH ANGGOTA</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <form>
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="masukkan username" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nama" class="form-label">nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                placeholder="masukkan nama" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">password</label>
                                            <input type="text" class="form-control" id="password" name="password"
                                                placeholder="masukkan password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nim_nidn" class="form-label">nim/nidn</label>
                                            <input type="text" class="form-control" id="nim_nidn" name="nim_nidn"
                                                placeholder="masukkan nim/nidn" required>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-6">
                                                <label>Program Studi</label>
                                                <select type="text" class="form-control" id="program_studi"
                                                    name="program_studi" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Teknologi Informasi">Teknologi Informasi</option>
                                                    <option value="Bisnis Digital">Bisnis Digital</option>
                                                    <option value="Bahasa Jepang">Bahasa Jepang</option>
                                                    <option value="Mekatronika">Mekatronika</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="label" class="form-label">waktu bergabung</label>
                                            <input type="date" class="form-control" id="waktu_bergabung"
                                                name="waktu_bergabung" placeholder="masukkan waktu bergabung" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="alamat" class="form-label">alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat"
                                                placeholder="masukkan alamat" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="noHP" class="form-label">noHP</label>
                                            <input type="int" class="form-control" id="noHP" name="noHP"
                                                placeholder="masukkan noHP" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jenis Kelamin</label>
                                            <select type="text" class="form-control" id="jenis_kelamin"
                                                name="jenis_kelamin" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="Laki-Laki">Laki-Laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">email</label>
                                            <input type="text" class="form-control" id="emai" name="email"
                                                placeholder="masukkan email" required>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" name="simpan" class="btn btn-primary"><i
                                class="fa-solid fa-download"></i>Simpan</button>
                        <a href="app?page=anggota" class="btn btn-secondary"><i
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