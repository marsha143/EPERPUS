<?php
$data = mysqli_query($conn, "SELECT * FROM buku");
$buku = mysqli_fetch_all($data, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];
    $data = mysqli_query($conn, "SELECT * FROM buku WHERE judul_buku LIKE '%$keyword%'");
    $buku = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id_buku'];

        $query = "DELETE FROM `buku` WHERE id_buku = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {

            echo "
        <script>
        alert('data  berhasil dihapus');
        window.location.href = 'app?page=buku'
        </script>
        ";
        } else {
            echo "
         <script>
        alert('data tidak berhasil dihapus');
        </script>
        ";
        }
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
                            <a href="./app?page=buku&view=addbuku" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-plus"></i>Tambah</a>
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
                                    <th>kode buku</th>
                                    <th>isbn</th>
                                    <th>nama penulis</th>
                                    <th>tahun terbit</th>
                                    <th>penerbit</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($buku as $no => $b): ?>
                                <tr>
                                    <td><img src="<?= $b['cover']?>" alt="cover" style="height:48px"></td>
                                    <td><?= $b['judul_buku'] ?></td>
                                    <td><?= $b['kode_buku'] ?></td>
                                    <td><?= $b['isbn'] ?></td>
                                    <td><?= $b['nama_penulis'] ?></td>
                                    <td><?= $b['tahun_terbit'] ?></td>
                                    <td><?= $b['penerbit'] ?></td>
                                    <td><a href="app?page=buku&view=editbuku&id_buku=<?= $b['id_buku'] ?>"
                                            class="btn btn-warning btn-sm ms-3"><i
                                                class="fa-solid fa-pen-to-square"></i>edit</a>
                                        <form action="" method="POST" style="display: inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                                            <button class="btn btn-danger btn-sm " name="delete"><i
                                                    class="fa-solid fa-trash"></i>hapus</button>
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