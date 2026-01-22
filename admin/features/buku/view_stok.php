<?php
$id_buku = (int) $_GET['id_buku'];

$q_buku = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku=$id_buku");
$buku = mysqli_fetch_assoc($q_buku);

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

    mysqli_query($conn, "DELETE FROM stok_buku WHERE id_stok=$id_stok");

    echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=buku&view=view_stok&id_buku=$id_buku';
    </script>";
    exit;
}
// Ubah kondisi stok
if (isset($_POST['ubah_kondisi'])) {
    $id_stok = (int) $_POST['id_stok'];
    $kondisi_baru = (int) $_POST['kondisi_baru'];

    mysqli_query(
        $conn,
        "UPDATE stok_buku 
         SET id_kondisi = $kondisi_baru 
         WHERE id_stok = $id_stok"
    );

    echo "<script>
        alert('Kondisi stok berhasil diubah');
        window.location.href='app?page=buku&view=view_stok&id_buku=$id_buku';
    </script>";
    exit;
}
?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Stok Buku: <?= $buku['judul_buku'] ?></h5>
            <a href="app?page=buku&view=addstok&id_buku=<?= $id_buku ?>" class="btn btn-success btn-sm">
                + Tambah Stok
            </a>
            <a href="app?page=buku&view=index" class="btn btn-danger btn-sm">
                <- Kembali Ke Daftar Buku </a>
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
                                <span class="badge <?= $s['id_kondisi'] == 2 ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $s['jenis_kondisi'] ?>
                                </span>
                            </td>
                            <td>
                                <!-- Ubah kondisi -->
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id_stok" value="<?= $s['id_stok'] ?>">
                                    <input type="hidden" name="kondisi_baru" value="<?= $s['id_kondisi'] == 2 ? 1 : 2 ?>">
                                    <button class="btn btn-warning btn-sm" name="ubah_kondisi"
                                        onclick="return confirm('Ubah kondisi buku ini?')">
                                        Ubah
                                    </button>
                                </form>

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