<?php
if (!isset($_GET['id_buku'])) {
    echo "<script>alert('ID buku tidak ditemukan'); window.location.href='app?page=buku';</script>";
    exit;
}

$id_buku = (int) $_GET['id_buku'];

// Ambil data buku
$q_buku = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id_buku");
$buku = mysqli_fetch_assoc($q_buku);

if (!$buku) {
    echo "<script>alert('Data buku tidak ditemukan'); window.location.href='app?page=buku';</script>";
    exit;
}

// Ambil kondisi buku
$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$kondisi = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);

// Simpan stok
if (isset($_POST['simpan'])) {
    $no_buku = mysqli_real_escape_string($conn, $_POST['no_buku']);
    $id_kondisi = (int) $_POST['id_kondisi'];

    // Cek nomor buku kampus unik
    $cek = mysqli_query($conn, "SELECT id_stok FROM stok_buku WHERE kode_buku_takumi='$no_buku'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Nomor buku kampus sudah digunakan');</script>";
    } else {

        // Insert stok
        mysqli_query($conn, "
            INSERT INTO stok_buku (id_buku, kode_buku_takumi, id_kondisi, created_at)
            VALUES ('$id_buku', '$no_buku', '$id_kondisi', NOW())
        ");

        // Update Qty
        mysqli_query($conn, "
            UPDATE buku SET Qty = Qty + 1 WHERE id_buku = '$id_buku'
        ");

        echo "<script>
            alert('Stok buku berhasil ditambahkan');
            window.location.href='app?page=buku&view=view_stok&id_buku=$id_buku';
        </script>";
        exit;
    }
}
?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Stok Buku</h4>
        </div>

        <div class="card-body">
            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" value="<?= $buku['judul_buku'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Buku Kampus</label>
                    <input type="text" name="no_buku" class="form-control" maxlength="8" pattern="\d{1,8}" placeholder="Maksimal 8 digit angka" required
                        placeholder="Contoh: 00123">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kondisi Buku</label>
                    <select name="id_kondisi" class="form-select" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <?php foreach ($kondisi as $k): ?>
                            <option value="<?= $k['id'] ?>">
                                <?= $k['jenis_kondisi'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="text-end">
                    <a href="app?page=buku&view=view_stok&id_buku=<?= $buku['id_buku']?>" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" name="simpan" class="btn btn-primary">
                        Simpan Stok
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>