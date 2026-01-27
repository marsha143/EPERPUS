<?php
$id_buku = (int) $_GET['id_buku'];

$q_buku = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku=$id_buku");
$buku = mysqli_fetch_assoc($q_buku);
$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$q_list = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);
$q_stok = mysqli_query($conn, "
    SELECT 
        stok_buku.id_stok,
        stok_buku.kode_buku_takumi,
        stok_buku.id_kondisi,
        kondisi_buku.jenis_kondisi
    FROM stok_buku
    JOIN kondisi_buku ON kondisi_buku.id = stok_buku.id_kondisi
    WHERE stok_buku.id_buku = $id_buku
");
$stok = mysqli_fetch_all($q_stok, MYSQLI_ASSOC);
// hapus stok
if (isset($_POST['hapus'])) {
    $id_stok = (int) $_POST['id_stok'];
    $cek = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE id_stok = '$id_stok'
");
    $data = mysqli_fetch_assoc($cek);

    if ($data['total'] > 0) {
        echo "<script>
        alert('Stok tidak bisa dihapus karena pernah dipinjam');
        window.location.href='app?page=buku&view=view_stok&id_buku=$id_buku';
    </script>";
        exit;
    }

    mysqli_query($conn, "DELETE FROM stok_buku WHERE id_stok=$id_stok");

    echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=buku&view=view_stok&id_buku=$id_buku';
    </script>";
    exit;
}
// Ubah kondisi stok
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
        window.location.href='app?page=buku&view=view_stok&id_buku=$id_buku';
    </script>";
    exit;
}
?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Stok Buku: <?= $buku['judul_buku'] ?></h3>
            <div class="text-end">
                <a href="app?page=buku&view=addstok&id_buku=<?= $id_buku ?>" class="btn btn-outline-success btn-sm">
                    + Tambah Stok
                </a>

                <a href="app?page=buku&view=index" class="btn btn-outline-danger btn-sm">
                    <- Kembali Ke Daftar Buku </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No Buku Kampus</th>
                        <th>Kondisi</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stok as $s): ?>
                        <tr>
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

                                <!-- Hapus stok -->
                                <form method="post" style="display:inline;" onsubmit="return confirm('Hapus stok ini?')">
                                    <input type="hidden" name="id_stok" value="<?= $s['id_stok'] ?>">
                                    <button class="btn btn-danger btn-sm" name="hapus">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>