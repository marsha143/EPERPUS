<?php

$idAnggota = $_SESSION['user']['id'] ?? 0;

$sql  = "SELECT * FROM anggota WHERE id_anggota = $idAnggota";
$res  = mysqli_query($conn, $sql);
$dataUser = mysqli_fetch_assoc($res);


$foto = $dataUser['image'] ?? "default.png";
if (isset($_POST['upload'])) {
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $ext      = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $allowed  = ['jpg','jpeg','png'];

        if (!in_array($ext, $allowed)) {
            echo "<script>alert('Format harus JPG / PNG');</script>";
        } else {
            $namaBaru    = "anggota_".$idAnggota."_".time().".".$ext;
            $target_file = $target_dir . $namaBaru;
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                mysqli_query(
                    $conn,
                    "UPDATE anggota SET image='$namaBaru' WHERE id_anggota=$idAnggota"
                );
                echo "<script>
                        alert('Upload berhasil');
window.location.href = 'app_anggota?page=profile_anggota'
                      </script>";
                exit;
            } else {
                echo "<script>alert('Upload gagal');</script>";
            }
        }
    }
}
if (isset($_POST['gantiPassword'])) {

    $passLama = $_POST['password_lama'];
    $passBaru = $_POST['password_baru'];
    $passKonf = $_POST['password_konfirmasi'];

    $cek = mysqli_query($conn, "SELECT password FROM anggota WHERE id_anggota=$idAnggota");
    $row = mysqli_fetch_assoc($cek);

    if (!password_verify($passLama, $row['password'])) {
        echo "<script>alert('Password lama salah!');</script>";
    } 
    elseif ($passBaru != $passKonf) {
        echo "<script>alert('Konfirmasi password baru tidak cocok!');</script>";
    } 
    else {
        $hash = password_hash($passBaru, PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE anggota SET password='$hash' WHERE id_anggota=$idAnggota");

        echo "<script>
                alert('Password berhasil diperbarui!');
                window.location.href='app_anggota?page=profile_anggota';
              </script>";
        exit;
    }
}
if (isset($_POST['ajukan_perubahan'])) {
    $alamatBaru = mysqli_real_escape_string($conn, $_POST['alamat']);
    $noHpBaru   = mysqli_real_escape_string($conn, $_POST['noHP']);

    $cek = mysqli_query($conn, "
        SELECT * FROM request_update_anggota 
        WHERE id_anggota=$idAnggota AND status='Menunggu'
    ");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Masih ada permintaan menunggu ACC admin');</script>";
    } else {
        mysqli_query($conn, "
            INSERT INTO request_update_anggota (id_anggota, alamat_baru, no_hp_baru)
            VALUES ($idAnggota, '$alamatBaru', '$noHpBaru')
        ");
        echo "<script>alert('Perubahan diajukan, menunggu persetujuan admin');location.href='app_anggota?page=profile_anggota';</script>";
        exit;
    }
}

$qHistori = mysqli_query($conn, "
    SELECT * FROM request_update_anggota
    WHERE id_anggota = $idAnggota
    ORDER BY tanggal_request DESC
");
$histori = [];
while ($row = mysqli_fetch_assoc($qHistori)) {
    $histori[] = $row;
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <div class="text-center mb-4">
                    <?php
$fotoPath = "uploads/" . (!empty($dataUser['image']) ? $dataUser['image'] : "default.png");
?>
                    <div class="profile-photo text-center mb-4">
                        <div class="avatar-wrapper mb-2">
                            <img src="<?= $fotoPath ?>" alt="Foto Profil" class="avatar-profile">
                            <label for="fileToUpload" class="avatar-upload-btn" title="Ganti foto profil">
                                <i class="material-icons" style="font-size:18px;">photo_camera</i>
                            </label>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" id="fileToUpload" name="fileToUpload" class="d-none" accept="image/*">
                            <button type="submit" name="upload" class="simpan btn mt-2">
                                Simpan Foto
                            </button>
                        </form>
                    </div>
                    <h4 class="mt-3 mb-0">
                        <?= htmlspecialchars($dataUser['nama'] ?? $dataUser['username']) ?>
                    </h4>
                    <p class="text-muted mb-0">
                        <?= htmlspecialchars($dataUser['program_studi'] ?? '-') ?>
                    </p>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIM / NIDN</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($dataUser['nim_nidn']) ?>"
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Program Studi</label>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($dataUser['program_studi']) ?>" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Waktu Bergabung</label>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($dataUser['waktu_bergabung']) ?>" disabled>
                    </div>
                </div>
                <form method="POST">
                    <label class="form-label fw-bold">No HP</label>
                    <div class="mb-3 edit">
                        <input type="text" name="noHP" class="form-control"
                            value="<?= htmlspecialchars($dataUser['noHP']) ?>">
                    </div>
                    <label class="form-label fw-bold">Alamat</label>
                    <div class="mb-3 edit">
                        <input type="text" name="alamat" class="form-control"
                            value="<?= htmlspecialchars($dataUser['alamat']) ?>">
                    </div>
                    <button type="submit" name="ajukan_perubahan" class="btn btn-warning">
                        Ajukan Perubahan
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalPassword">
                        Ganti Kata Sandi
                    </button>
                    <?php if (!empty($histori)): ?>
                    <?php foreach ($histori as $h): ?>
                    <div class="mb-2 p-3 border rounded">
                        <div><strong>No HP Baru:</strong> <?= htmlspecialchars($h['no_hp_baru']) ?></div>
                        <div><strong>Alamat Baru:</strong> <?= htmlspecialchars($h['alamat_baru']) ?></div>
                        <div>
                            <strong>Status:</strong>
                            <?php if ($h['status'] === 'Menunggu'): ?>
                            <span class="badge bg-warning text-dark">Menunggu</span>
                            <?php elseif ($h['status'] === 'Disetujui'): ?>
                            <span class="badge bg-success">Disetujui</span>
                            <?php else: ?>
                            <span class="badge bg-danger">Ditolak</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-muted">Belum ada histori perubahan data.</p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPassword" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Kata Sandi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_konfirmasi" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="gantiPassword" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('./anggota/layouts_anggota/footer.php'); ?>