<?php

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
        alert('Perubahan profile DISSETUJUI');
        window.location.href='app?page=anggota';
    </script>";
    exit;
}

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

$requests = mysqli_fetch_all($qReq, MYSQLI_ASSOC);
?>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h4>Permintaan Perubahan Profile Anggota</h4>
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