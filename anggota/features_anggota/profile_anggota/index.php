<?php

$idAnggota = $_SESSION['user']['id'] ?? 0;

$sql  = "SELECT * FROM anggota WHERE id_anggota = $idAnggota";
$res  = mysqli_query($conn, $sql);
$dataUser = mysqli_fetch_assoc($res);


// ambil foto
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
                // simpan nama file ke database 
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
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nomor HP</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($dataUser['noHP']) ?>"
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Kelamin</label>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($dataUser['jenis_kelamin']) ?>" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea class="form-control" rows="2"
                        disabled><?= htmlspecialchars($dataUser['alamat']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Waktu Bergabung</label>
                    <input type="text" class="form-control"
                        value="<?= htmlspecialchars($dataUser['waktu_bergabung']) ?>" disabled>
                </div>
                <button type="submit" class="btn btn-primary">
                    Ganti kata sandi
                </button>
            </div>
        </div>
    </div>
</div>