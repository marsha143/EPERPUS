<?php
$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$q_list = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);
$q_stok = mysqli_query($conn, "
    SELECT
        stok_buku.id_stok,
        stok_buku.kode_buku_takumi,
        stok_buku.id_kondisi,
        kondisi_buku.jenis_kondisi,
        buku.id_buku,
        buku.judul_buku
    FROM stok_buku   
    JOIN buku ON buku.id_buku = stok_buku.id_buku
    JOIN kondisi_buku ON kondisi_buku.id = stok_buku.id_kondisi
    WHERE stok_buku.deleted_at IS NULL
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
        window.location.href='app?page=stok';
    </script>";
    exit;
}

if (isset($_POST['hapus'])) {
    $id_stok = (int) $_POST['id_stok'];

    mysqli_query($conn, "
        UPDATE stok_buku 
        SET deleted_at = CURRENT_TIMESTAMP 
        WHERE id_stok = $id_stok
    ");


    echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=stok';
    </script>";
    exit;
}
?>


<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="col-md-3">
                <h3>Data Kondisi Buku (Seluruh Stok)</h3>
            </div>
            <div class="text-end">
                <div class="col-md">
                    <a href="app?page=stok&view=add_stok_universal" class="btn btn-outline-success btn-sm">
                        + Tambah stok buku
                    </a>
                    <a href="app?page=buku&view=index" class="btn btn-outline-danger btn-sm">
                        <- Kembali Ke Daftar Buku </a>
                </div>
            </div>
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
                            <td><?= $s['kode_buku_takumi'] ?></td>
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
                                    <button class="btn btn-outline-danger btn-sm" name="hapus">
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