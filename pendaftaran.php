<?php
include("./config/db.php");
include('./admin/layouts/header.php');

$nim_auto = $_GET['nim_nidn'] ?? '';

if (isset($_POST['simpan'])) {

    $nama          = trim($_POST['nama']);
    $nim_nidn      = trim($_POST['nim_nidn']);
    $program_studi = trim($_POST['program_studi']);
    $alamat        = trim($_POST['alamat']);
    $noHP          = trim($_POST['noHP']);
    $jenis_kelamin = trim($_POST['jenis_kelamin']);
    $email         = trim($_POST['email']);
    $username      = trim($_POST['username']);
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_prepare($conn,
        "SELECT 1 FROM anggota WHERE nim_nidn = ?
         UNION
         SELECT 1 FROM anggota_request WHERE nim_nidn = ? AND status = 'Pending'"
    );
    mysqli_stmt_bind_param($cek, "ss", $nim_nidn, $nim_nidn);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        echo "<script>
            alert('NIM / NIDN sudah terdaftar');
            window.location.href='data_tamu';
        </script>";
        exit;
    }
    mysqli_stmt_close($cek);

    $cek = mysqli_prepare($conn,
        "SELECT 1 FROM anggota WHERE username = ?
         UNION
         SELECT 1 FROM anggota_request WHERE username = ?"
    );
    mysqli_stmt_bind_param($cek, "ss", $username, $username);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        echo "<script>
            alert('Username sudah digunakan');
            window.history.back();
        </script>";
        exit;
    }
    mysqli_stmt_close($cek);

    $cek = mysqli_prepare($conn,
        "SELECT 1 FROM anggota WHERE email = ?
         UNION
         SELECT 1 FROM anggota_request WHERE email = ?"
    );
    mysqli_stmt_bind_param($cek, "ss", $email, $email);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        echo "<script>
            alert('Email sudah terdaftar');
            window.history.back();
        </script>";
        exit;
    }
    mysqli_stmt_close($cek);

    $cek = mysqli_prepare($conn,
        "SELECT 1 FROM anggota WHERE noHP = ?
         UNION
         SELECT 1 FROM anggota_request WHERE noHP = ?"
    );
    mysqli_stmt_bind_param($cek, "ss", $noHP, $noHP);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        echo "<script>
            alert('Nomor HP sudah terdaftar');
            window.history.back();
        </script>";
        exit;
    }
    mysqli_stmt_close($cek);


    $stmt = mysqli_prepare($conn, "
        INSERT INTO anggota_request
        (nama, nim_nidn, program_studi, alamat, noHP, jenis_kelamin, email, username, password, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssss",
        $nama,
        $nim_nidn,
        $program_studi,
        $alamat,
        $noHP,
        $jenis_kelamin,
        $email,
        $username,
        $password
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<script>
        alert('Pendaftaran berhasil. Silakan tunggu persetujuan admin.');
        window.location.href='data_tamu';
    </script>";
}
?>

<form method="POST">
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Pendaftaran Anggota (Request)</h3>
        </div>

        <div class="card-body row g-3">

            <div class="col-md-6">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>NIM / NIDN</label>
                <input type="text" name="nim_nidn"
                       value="<?= htmlspecialchars($nim_auto) ?>"
                       class="form-control" readonly required>
            </div>

            <div class="col-md-6">
                <label>Program Studi</label>
                <input type="text" name="program_studi" class="form-control">
            </div>

            <div class="col-md-6">
                <label>No HP</label>
                <input type="text" name="noHP" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-12">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control">
            </div>

        </div>

        <div class="card-footer text-end">
            <button type="submit" name="simpan" class="btn btn-primary">
                Kirim Request
            </button>
        </div>
    </div>
</div>
</form>
