<?php

/* =====================================================
   ACC PENDAFTARAN ANGGOTA
===================================================== */
if (isset($_POST['acc_request'])) {

    $idRequest = (int)$_POST['id_request'];

    // Ambil data request
    $req = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT * FROM anggota_request
        WHERE id_request = $idRequest
        AND status = 'Pending'
        LIMIT 1
    "));

    if ($req) {

        // Masukkan ke tabel anggota
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

        // Update status request
        mysqli_query($conn, "
            UPDATE anggota_request
            SET status = 'Disetujui'
            WHERE id_request = $idRequest
        ");

        echo "<script>
            alert('Pendaftaran anggota BERHASIL DISETUJUI');
            window.location.href='anggota.php';
        </script>";
        exit;
    }
}


/* =====================================================
   TOLAK PENDAFTARAN ANGGOTA
===================================================== */
if (isset($_POST['tolak_request'])) {

    $idRequest = (int)$_POST['id_request'];

    mysqli_query($conn, "
        UPDATE anggota_request
        SET status = 'Ditolak'
        WHERE id_request = $idRequest
    ");

    echo "<script>
        alert('Pendaftaran anggota DITOLAK');
        window.location.href='anggota_request.php';
    </script>";
    exit;
}


/* =====================================================
   AMBIL DATA REQUEST
===================================================== */
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
    <div class="card shadow">
        <div class="card-header">
            <h4>Permohonan Pendaftaran Anggota</h4>
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
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($r['status'] == 'Disetujui'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
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

