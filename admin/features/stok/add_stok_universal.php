<?php
$q_buku = mysqli_query($conn, "SELECT id_buku, judul_buku FROM buku ORDER BY judul_buku");
$buku = mysqli_fetch_all($q_buku, MYSQLI_ASSOC);

$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$kondisi = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);

if (isset($_POST['simpan'])) {
    $id_buku = (int) $_POST['id_buku'];
    $no_buku = (int) $_POST['kode_buku_takumi'];
    $id_kondisi = (int) $_POST['id_kondisi'];

    mysqli_query($conn, "
        INSERT INTO stok_buku (id_buku, kode_buku_takumi, id_kondisi)
        VALUES ($id_buku, '$no_buku', $id_kondisi)
    ");

    echo "<script>
        alert('Stok buku berhasil ditambahkan');
        window.location.href='app?page=stok';
    </script>";
    exit;
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Tambah Kondisi Buku</h5>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label>Judul Buku</label>
                    <select name="id_buku" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        <?php foreach ($buku as $b): ?>
                            <option value="<?= $b['id_buku'] ?>">
                                <?= $b['judul_buku'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>No Buku Kampus</label>
                    <input type="text" name="kode_buku_takumi" class="form-control" maxlength="8" pattern="\d{1,8}" placeholder="Maksimal 8 digit angka" required>
                </div>

                <div class="mb-3">
                    <label>Kondisi Buku</label>
                    <select name="id_kondisi" class="form-select" required>
                        <?php foreach ($kondisi as $k): ?>
                            <option value="<?= $k['id'] ?>">
                                <?= $k['jenis_kondisi'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <button class="btn btn-primary" name="simpan">Simpan</button>
                <a href="app?page=stok" class="btn btn-outline-secondary">
                    Batal
                </a>
            </form>
        </div>
    </div>
</div>