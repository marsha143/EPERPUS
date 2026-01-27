<?php
$data = mysqli_query($conn, "SELECT * FROM penulis WHERE deleted_at IS NULL");
$penulis = mysqli_fetch_all($data, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];
    $data = mysqli_query($conn, "SELECT * FROM penulis WHERE nama_penulis LIKE '%$keyword%'");
    $penulis = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id_penulis = (int) $_POST['id_penulis'];

        mysqli_query($conn, "
        UPDATE penulis 
        SET deleted_at = CURRENT_TIMESTAMP 
        WHERE id = $id_penulis
    ");


        echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=penulis';
    </script>";
        exit;
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Data Penulis</h3>
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
                            <a href="./app?page=penulis&view=addpenulis" class="btn btn-primary btn-sm"><i
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
                                    <th>Nama Penulis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penulis as $no => $p): ?>
                                    <tr>
                                        <td><?= $p['nama_penulis'] ?></td>
                                        <td>
                                            <a href="app?page=penulis&view=editpenulis&id_penulis=<?= $p['id'] ?>"
                                                class="btn btn-warning btn-sm ms-3">
                                                <i class="fa-solid fa-pen-to-square"></i>edit
                                            </a>
                                            <form action="" method="POST" style="display: inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                <input type="hidden" name="id_penulis" value="<?= $p['id'] ?>">
                                                <button class="btn btn-danger btn-sm" name="delete">
                                                    <i class="fa-solid fa-trash"></i>hapus
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
        </div>
    </div>