<?php

$idAnggota = $_SESSION['user']['id'] ?? 0;

$sql  = "SELECT * FROM anggota WHERE id_anggota = $idAnggota";
$res  = mysqli_query($conn, $sql);
$dataUser = mysqli_fetch_assoc($res);

?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 p-4">
        <div class="text-center mb-4">
          <img src="./assets/img/default-profile.jpg"
               alt="Foto Profil"
               class="rounded-circle shadow"
               width="120" height="120"
               style="object-fit: cover;">
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
            <input type="text" class="form-control" value="<?= htmlspecialchars($dataUser['nim_nidn']) ?>" disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Program Studi</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($dataUser['program_studi']) ?>" disabled>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Nomor HP</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($dataUser['noHP']) ?>" disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Jenis Kelamin</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($dataUser['jenis_kelamin']) ?>" disabled>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Alamat</label>
          <textarea class="form-control" rows="2" disabled><?= htmlspecialchars($dataUser['alamat']) ?></textarea>
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