<?php
$data = mysqli_query($conn, "SELECT * FROM penulis");
$penulis = mysqli_fetch_all($data, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];
    $data = mysqli_query($conn, "SELECT * FROM penulis WHERE nama_penulis LIKE '%$keyword%'");
    $penulis = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id_penulis'];

        $query = "DELETE FROM `penulis` WHERE id_penulis = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {

            echo "
        <script>
        alert('data  berhasil dihapus');
        window.location.href = 'app?page=penulis'
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
                            <a href="./app?page=penulis&view=addpenulis" class="btn btn-outline-primary btn-sm">
                                + Tambah</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Penulis</th>
                                <th width="180px">Aksi</th>
                            </tr>
                        </thead>
                        <?php foreach ($penulis as $no => $p): ?>
                        <tr>
                            <td><?= $p['nama_penulis'] ?></td>
                            <td>
                                <a href="app?page=penulis&view=editpenulis&id_penulis=<?= $p ?>"
                                    class="btn btn-outline-warning btn-sm ms-3">
                                    <i class="fa-solid fa-pen-to-square"></i>edit
                                </a>
                                <form action="" method="POST" style="display: inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    <input type="hidden" name="id_penulis" value="<?= $p ?>">
                                    <button class="btn btn-outline-danger btn-sm" name="delete">
                                        <i class="fa-solid fa-trash"></i>hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>