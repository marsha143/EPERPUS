<?php include("./config/db.php"); ?>
<?php include('./layouts/header.php'); ?>
<?php

if (isset($_POST['simpan'])) {
    $nim_nidn = trim($_POST['nim_nidn'] ?? '');


    $cek = mysqli_prepare($conn, "SELECT 1 FROM anggota WHERE nim_nidn = ? LIMIT 1");
    mysqli_stmt_bind_param($cek, "s", $nim_nidn);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) === 0) {
        echo "<script>alert('NIM/NIDN tidak terdaftar sebagai anggota.');window.location.href='data_tamu';</script>";
        exit;
    }


    $ins = mysqli_prepare($conn, "INSERT INTO kunjungan (nim_nidn) VALUES (?)");
    mysqli_stmt_bind_param($ins, "s", $nim_nidn);

    if (mysqli_stmt_execute($ins)) {
        echo "<script>alert('Terima kasih, kunjungan Anda dicatat.');window.location.href='data_tamu';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan: ".mysqli_error($conn)."');</script>";
    }
}
?>

<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                    <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                        style="background-image: url('./assets/img/Gedung-Takumi-AI.jpg'); background-size: cover;"
                        loading="lazy"></div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                    <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mt-8 mb-5">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg p-3">
                                <h3 class="text-white text-primary mb-0">Data Tamu Perpustakaan</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="pb-3">
                                Selamat datang di Perpustakaan Politeknik Takumi. Silahkan isi data kehadiran tamu.
                            </p>
                            <form method="POST" action="" class="text-start">
                                <div class="card-body p-0 my-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static mb-4">
                                                <label>NIM/NIDN</label>
                                                <input type="Nim_nidn" name="nim_nidn" class="form-control"
                                                    placeholder="nim_nidn" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 mt-md-0 mt-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label></label>
                                            <textarea name="message" class="form-control" id="message" rows="6"
                                                ></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-center">
                                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>