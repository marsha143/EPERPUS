<?php
$querydata = "
SELECT 
    buku.*,
    penulis.nama_penulis,
    genre.jenis_genre,
    COUNT(stok_buku.id_stok) AS Qty
FROM buku
LEFT JOIN penulis ON penulis.id = buku.id_penulis
LEFT JOIN genre ON genre.id = buku.id_genre
LEFT JOIN stok_buku 
    ON stok_buku.id_buku = buku.id_buku
    AND stok_buku.id_kondisi = 2
GROUP BY buku.id_buku
";
$data = mysqli_query($conn, $querydata);
$buku = mysqli_fetch_all($data, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];
    $data = mysqli_query($conn, "SELECT *, penulis.nama_penulis, genre.jenis_genre FROM buku LEFT JOIN penulis ON penulis.id = buku.id_penulis LEFT JOIN genre ON genre.id = buku.id_genre WHERE buku.judul_buku LIKE '%$keyword%'");
    $buku = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id_buku']; // atau dari POST

        $cek = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE id_buku = '$id'
");

        $data = mysqli_fetch_assoc($cek);

        if ($data['total'] > 0) {
            echo "<script>
        alert('Buku tidak bisa dihapus karena sedang dipinjam');
        window.location.href='app?page=buku';
    </script>";
            exit;
        }

        // HAPUS
        mysqli_query($conn, "DELETE FROM buku WHERE id_buku='$id'");

        echo "<script>
    alert('Buku berhasil dihapus');
    window.location.href='app?page=buku';
</script>";
        exit;
    }
}
if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    $hasil = mysqli_query($conn, $query_qty);
    $data_qty = mysqli_fetch_assoc($hasil);
    if (!$data_qty) {
        header("Location: app");
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Data Buku</h3>
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
                        <div class="text-end">
                            <a href="app?page=stok" class="btn btn-outline-success btn-sm">
                                Lihat Semua Stok Buku
                            </a>
                            <a href="./app?page=buku&view=addbuku" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-plus"></i>Tambah Informasi Buku</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>cover</th>
                                    <th>judul buku</th>
                                    <th>genre buku</th>
                                    <th>isbn</th>
                                    <th>nama penulis</th>
                                    <th>tahun terbit</th>
                                    <th>penerbit</th>
                                    <th>Quantity</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($buku as $no => $b): ?>
                                    <tr>
                                        <td><img src="<?= $b['cover'] ?>" alt="cover" style="height:48px"></td>
                                        <td><?= $b['judul_buku'] ?></td>
                                        <td><?= $b['jenis_genre'] ?></td>
                                        <td><?= $b['isbn'] ?></td>
                                        <td><?= $b['nama_penulis'] ?></td>
                                        <td><?= $b['tahun_terbit'] ?></td>
                                        <td><?= $b['penerbit'] ?></td>
                                        <form action="" method="POST" style="display:inline;">
                                            <td><?= $b['Qty'] ?> Pcs <input type="hidden" name="id_buku"
                                                    value="<?= $b['id_buku'] ?>">
                                                <a href="app?page=buku&view=view_stok&id_buku=<?= $b['id_buku'] ?>"
                                                    class="btn btn-outline-success btn-sm">
                                                    Lihat Stok
                                                </a>
                                            </td>
                                        </form>
                                        <td><a href="app?page=buku&view=editbuku&id_buku=<?= $b['id_buku'] ?>"
                                                class="btn btn-outline-warning btn-sm ms-3"><i
                                                    class="fa-solid fa-pen-to-square"></i> edit</a>
                                            <form action="" method="POST" style="display: inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                                                <button class="btn btn-outline-danger btn-sm " name="delete"><i
                                                        class="fa-solid fa-trash"></i> hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>