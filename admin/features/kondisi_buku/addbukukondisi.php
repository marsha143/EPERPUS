<?php
// Ambil data buku
$buku = mysqli_query($conn, "SELECT id_buku, judul_buku, qty FROM buku WHERE qty > 0");

// Ambil data kondisi
$kondisi = mysqli_query($conn, "SELECT id, jenis_kondisi FROM kondisi_buku");

if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_kondisi = $_POST['id_kondisi'];

    // ambil kondisi
    $q = mysqli_query($conn, "
        SELECT jenis_kondisi 
        FROM kondisi_buku 
        WHERE id = '$id_kondisi'
    ");
    $k = mysqli_fetch_assoc($q);

    // simpan kondisi buku
    mysqli_query($conn, "
        INSERT INTO buku_kondisi (id_buku, id_kondisi)
        VALUES ('$id_buku', '$id_kondisi')
    ");

    // jika rusak → kurangi qty
    if (strtolower($k['jenis_kondisi']) == 'rusak') {
        mysqli_query($conn, "
            UPDATE buku 
            SET qty = qty - 1 
            WHERE id_buku = '$id_buku'
        ");
    }

    echo "
    <script>
        alert('Kondisi buku berhasil disimpan');
        window.location.href = 'app?page=kondisi_buku';
    </script>
    ";
}
?>

<div class="container mt-5">
    <div class="card">

        <!-- HEADER -->
        <div class="card-header">
            <h3>Kondisikan Buku</h3>
        </div>

        <!-- FORM -->
        <form method="POST">
            <div class="card-body">

                <!-- PILIH BUKU -->
                <div class="mb-3">
                    <label class="form-label">Pilih Buku</label>
                    <select name="id_buku" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        <?php while ($b = mysqli_fetch_assoc($buku)): ?>
                            <option value="<?= $b['id_buku'] ?>">
                                <?= $b['judul_buku'] ?> (stok: <?= $b['qty'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- PILIH KONDISI -->
                <div class="mb-3">
                    <label class="form-label">Kondisi Buku</label>
                    <select name="id_kondisi" class="form-select" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <?php while ($k = mysqli_fetch_assoc($kondisi)): ?>
                            <option value="<?= $k['id'] ?>">
                                <?= ucfirst($k['jenis_kondisi']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer text-end">
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="app?page=kondisi_buku" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>

    </div>
</div>