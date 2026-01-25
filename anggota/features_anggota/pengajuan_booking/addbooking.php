<?php

// ambil id anggota dari session login
$id_anggota = $_SESSION['user']['id'] ?? 0;

if ($id_anggota == 0) {
    die("User tidak terdeteksi (belum login).");
}

if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];

    $query = "
        INSERT INTO booking (id_buku, id_anggota, waktu_booking, status)
        VALUES ('$id_buku', '$id_anggota', NOW(), 'Dibooking')
    ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // ambil data anggota + buku
        $data_email = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT 
            a.nama,
            a.nim_nidn,
            a.email,
            b.judul_buku
        FROM anggota a
        JOIN buku b ON b.id_buku = '$id_buku'
        WHERE a.id_anggota = '$id_anggota'
    "));

        $nama_anggota = $data_email['nama'];
        $nim_nidn = $data_email['nim_nidn'];
        $judul_buku = $data_email['judul_buku'];
        $waktu_booking = date('Y-m-d H:i:s');

        $admin_result = mysqli_query($conn, "SELECT email FROM admin");

        include "send_email_admin.php";

        echo "
    <script>
        alert('Booking berhasil dibuat (berlaku 24 jam)');
        window.location.href = 'app_anggota?page=pengajuan_booking'
    </script>
    ";
    } else {
        echo "
        <script>
        alert('Booking gagal disimpan');
        </script>
        ";
    }
    
}

// ambil daftar buku
$buku = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM buku"), MYSQLI_ASSOC);
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Form Booking Buku</h5>
        </div>

        <div class="card-body">
            <form action="" method="POST">

                <input type="hidden" name="id_anggota" value="<?= $id_anggota ?>">

                <div class="mb-3">
                    <label class="form-label">Pilih Buku</label>
                    <select name="id_buku" class="form-select js-example-basic-single" required>
                        <option value="" hidden>-- Pilih Buku --</option>
                        <?php foreach ($buku as $b): ?>
                            <option value="<?= $b['id_buku'] ?>">
                                <?= $b['id_buku'] ?> - <?= $b['judul_buku'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                    <a href="app_anggota?page=pengajuan_booking" class="btn btn-outline-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>