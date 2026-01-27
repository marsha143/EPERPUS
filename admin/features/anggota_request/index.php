<?php

// ================================
// SEARCH REQUEST UPDATE PROFILE
// ================================
if (isset($_POST['cari']) && $_POST['cari'] !== '') {

    $keyword = mysqli_real_escape_string($conn, $_POST['cari']);

    $query = "
        SELECT 
            r.id_request,
            r.id_anggota,
            r.alamat_baru,
            r.no_hp_baru,
            r.status,
            r.tanggal_request,
            a.nama,
            a.nim_nidn,
            a.program_studi,
            a.alamat,
            a.noHP
        FROM request_update_anggota r
        JOIN anggota a ON r.id_anggota = a.id_anggota
        WHERE 
            a.nama LIKE '%$keyword%' OR
            a.nim_nidn LIKE '%$keyword%' OR
            a.program_studi LIKE '%$keyword%' OR
            a.noHP LIKE '%$keyword%'
        ORDER BY r.tanggal_request DESC
    ";

    $qReq = mysqli_query($conn, $query);

    if (!$qReq) {
        die("Query error (SEARCH): " . mysqli_error($conn));
    }

    $requests = mysqli_fetch_all($qReq, MYSQLI_ASSOC);
}


// ================================
// AMBIL SEMUA REQUEST (JIKA TIDAK SEARCH)
// ================================
if (!isset($_POST['cari']) || $_POST['cari'] === '') {

    $qReq = mysqli_query($conn, "
        SELECT 
            r.id_request,
            r.id_anggota,
            r.alamat_baru,
            r.no_hp_baru,
            r.status,
            r.tanggal_request,
            a.nama,
            a.nim_nidn,
            a.program_studi,
            a.alamat,
            a.noHP
        FROM request_update_anggota r
        JOIN anggota a ON r.id_anggota = a.id_anggota
        ORDER BY r.tanggal_request DESC
    ");

    if (!$qReq) {
        die("Query error (ALL): " . mysqli_error($conn));
    }

    $requests = mysqli_fetch_all($qReq, MYSQLI_ASSOC);
}


// ================================
// ACC PROFILE
// ================================
if (isset($_POST['acc_profile'])) {

    $idRequest = (int)$_POST['id_request'];
    $idAnggota = (int)$_POST['id_anggota'];

    $req = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT alamat_baru, no_hp_baru 
        FROM request_update_anggota 
        WHERE id_request = $idRequest
    "));

    mysqli_query($conn, "
        UPDATE anggota SET
            alamat = '{$req['alamat_baru']}',
            noHP  = '{$req['no_hp_baru']}'
        WHERE id_anggota = $idAnggota
    ");

    mysqli_query($conn, "
        UPDATE request_update_anggota 
        SET status = 'Disetujui'
        WHERE id_request = $idRequest
    ");

    echo "<script>
        alert('Perubahan profile DISETUJUI');
        window.location.href='app?page=anggota';
    </script>";
    exit;
}


// ================================
// TOLAK PROFILE
// ================================
if (isset($_POST['tolak_profile'])) {

    $idRequest = (int)$_POST['id_request'];

    mysqli_query($conn, "
        UPDATE request_update_anggota 
        SET status = 'Ditolak'
        WHERE id_request = $idRequest
    ");

    echo "<script>
        alert('Perubahan profile DITOLAK');
        window.location.href='app?page=anggota';
    </script>";
    exit;
}

?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Permintaan Perubahan Profile Anggota</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <form class=" align-items-center" role="search" method="POST">
                            <div class="ms-md-auto pe-md-3 align-items-center">
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" type="search" name="cari"
                                        placeholder="Search" aria-label="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="text-end">
                            <a href="./app?page=buku&view=addbuku" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-plus"></i>Tambah</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIM / NIDN</th>
                                <th>Program Studi</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (count($requests) == 0): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada permintaan perubahan
                                </td>
                            </tr>
                            <?php endif; ?>

                            <?php foreach ($requests as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['nama']) ?></td>
                                <td><?= htmlspecialchars($r['nim_nidn']) ?></td>
                                <td><?= htmlspecialchars($r['program_studi']) ?></td>

                                <td>
                                    <small class="text-muted">Lama:</small><br>
                                    <?= htmlspecialchars($r['alamat']) ?><br><br>
                                    <small class="text-success">Baru:</small><br>
                                    <?= htmlspecialchars($r['alamat_baru']) ?>
                                </td>

                                <td>
                                    <small class="text-muted">Lama:</small><br>
                                    <?= htmlspecialchars($r['noHP']) ?><br><br>
                                    <small class="text-success">Baru:</small><br>
                                    <?= htmlspecialchars($r['no_hp_baru']) ?>
                                </td>

                                <td>
                                    <?php if ($r['status'] == 'Disetujui'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                    <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($r['status'] == 'Menunggu'): ?>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id_request" value="<?= $r['id_request'] ?>">
                                        <input type="hidden" name="id_anggota" value="<?= $r['id_anggota'] ?>">
                                        <button name="acc_profile" class="btn btn-success btn-sm"
                                            onclick="return confirm('Setujui perubahan ini?')">
                                            ACC
                                        </button>
                                    </form>

                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id_request" value="<?= $r['id_request'] ?>">
                                        <button name="tolak_profile" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tolak perubahan ini?')">
                                            Tolak
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <small class="text-muted">Selesai</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>