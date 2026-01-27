<?php
if (isset($_POST['cari']) && $_POST['cari'] !== '') {

    $keyword = mysqli_real_escape_string($conn, $_POST['cari']);

    $query = "
        SELECT *
        FROM anggota_request
        WHERE status = 'Pending'
          AND (
                nama LIKE '%$keyword%' OR
                nim_nidn LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                username LIKE '%$keyword%'
              )
        ORDER BY id_request DESC
    ";

    $data = mysqli_query($conn, $query);
    $anggota = mysqli_fetch_all($data, MYSQLI_ASSOC);
}
if (isset($_POST['acc_request'])) {

    $idRequest = (int)$_POST['id_request'];

    $req = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT * FROM anggota_request
        WHERE id_request = $idRequest
        AND status = 'Pending'
        LIMIT 1
    "));

    if ($req) {
        mysqli_query($conn, "
            INSERT INTO anggota (
                username,
                password,
                nama,
                nim_nidn,
                program_studi,
                alamat,
                noHP,
                jenis_kelamin,
                email,
                role
            ) VALUES (
                '{$req['username']}',
                '{$req['password']}',
                '{$req['nama']}',
                '{$req['nim_nidn']}',
                '{$req['program_studi']}',
                '{$req['alamat']}',
                '{$req['noHP']}',
                '{$req['jenis_kelamin']}',
                '{$req['email']}',
                'anggota'
            )
        ");

        mysqli_query($conn, "
            UPDATE anggota_request
            SET status = 'Disetujui'
            WHERE id_request = $idRequest
        ");

        echo "<script>
            alert('Pendaftaran anggota BERHASIL DISETUJUI');
            window.location.href='app?page=anggota';
        </script>";
        exit;
    }
}
if (isset($_POST['tolak_request'])) {

    $idRequest = (int)$_POST['id_request'];

    mysqli_query($conn, "
        UPDATE anggota_request
        SET status = 'Ditolak'
        WHERE id_request = $idRequest
    ");

    echo "<script>
        alert('Pendaftaran anggota DITOLAK');
        window.location.href='app?page=anggota';
    </script>";
    exit;
}

$qReq = mysqli_query($conn, "
    SELECT 
        id_request,
        username,
        nama,
        nim_nidn,
        program_studi,
        alamat,
        noHP,
        jenis_kelamin,
        email,
        status,
        waktu_request
    FROM anggota_request
    ORDER BY waktu_request DESC
");

$requests = mysqli_fetch_all($qReq, MYSQLI_ASSOC);
?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Data Anggota</h3>
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
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (count($requests) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada permohonan pendaftaran
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($requests as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['nama']) ?></td>
                            <td><?= htmlspecialchars($r['nim_nidn']) ?></td>
                            <td><?= htmlspecialchars($r['program_studi']) ?></td>
                            <td><?= htmlspecialchars($r['noHP']) ?></td>
                            <td><?= htmlspecialchars($r['email']) ?></td>

                            <td>
                                <?php if ($r['status'] == 'Pending'): ?>
                                    <span class="badge border border-warning text-warning">Pending</span>
                                <?php elseif ($r['status'] == 'Disetujui'): ?>
                                    <span class="badge border border-success text-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge border border-danger text-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($r['status'] == 'Pending'): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_request" value="<?= $r['id_request'] ?>">
                                    <button name="acc_request" class="btn btn-success btn-sm"
                                        onclick="return confirm('Setujui pendaftaran ini?')">
                                        ACC
                                    </button>
                                </form>

                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_request" value="<?= $r['id_request'] ?>">
                                    <button name="tolak_request" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tolak pendaftaran ini?')">
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

