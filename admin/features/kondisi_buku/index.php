<?php
$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$q_list = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);
$q_stok = mysqli_query($conn, "
    SELECT
        stok_buku.id_stok,
        stok_buku.no_buku_kampus,
        stok_buku.id_kondisi,
        kondisi_buku.jenis_kondisi,
        buku.id_buku,
        buku.judul_buku
    FROM stok_buku
    JOIN buku ON buku.id_buku = stok_buku.id_buku
    JOIN kondisi_buku ON kondisi_buku.id = stok_buku.id_kondisi
    ORDER BY buku.judul_buku ASC
");
$stok = mysqli_fetch_all($q_stok, MYSQLI_ASSOC);

if (isset($_POST['update_kondisi'])) {
    $id_stok = (int) $_POST['id_stok'];
    $id_kondisi = (int) $_POST['id_kondisi'];

    mysqli_query($conn, "
        UPDATE stok_buku 
        SET id_kondisi = $id_kondisi 
        WHERE id_stok = $id_stok
    ");

    echo "<script>
        alert('Kondisi buku berhasil diperbarui');
        window.location.href='app?page=kondisi_buku';
    </script>";
    exit;
}

if (isset($_POST['hapus'])) {
    $id_stok = (int) $_POST['id_stok'];

    mysqli_query($conn, "DELETE FROM stok_buku WHERE id_stok=$id_stok");

    echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=kondisi_buku';
    </script>";
    exit;
}
?>


<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Data Kondisi Buku (Seluruh Stok)</h5>
            <a href="app?page=kondisi_buku&view=addkondisi" class="btn btn-success btn-sm">
                + Tambah kondisi
            </a>
            <a href="app?page=kondisi_buku&view=add_jenis_kondisi" class="btn btn-success btn-sm">
                + Tambah jenis kondisi
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>No Buku Kampus</th>
                        <th>Kondisi</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stok as $s): ?>
                        <tr>
                            <td>
                                <a href="app?page=buku&view=view_stok&id_buku=<?= $s['id_buku'] ?>">
                                    <?= $s['judul_buku'] ?>
                                </a>
                            </td>
                            <td><?= $s['no_buku_kampus'] ?></td>
                            <td>
                                <!-- Ubah kondisi -->
                                <form method="post">
                                    <input type="hidden" name="id_stok" value="<?= $s['id_stok'] ?>">

                                    <select name="id_kondisi" class="form-select form-select-sm"
                                        onchange="this.form.submit()">

                                        <?php foreach ($q_list as $k): ?>
                                            <option value="<?= $k['id'] ?>" <?= $k['id'] == $s['id_kondisi'] ? 'selected' : '' ?>>
                                                <?= $k['jenis_kondisi'] ?>
                                            </option>
                                        <?php endforeach ?>

                                    </select>

                                    <input type="hidden" name="update_kondisi">
                                </form>
                            </td>
                            <td>
                                <!-- Hapus -->
                                <form method="post" style="display:inline;" onsubmit="return confirm('Hapus stok ini?')">
                                    <input type="hidden" name="id_stok" value="<?= $s['id_stok'] ?>">
                                    <button class="btn btn-danger btn-sm" name="hapus">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>