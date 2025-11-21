<?php
$data = mysqli_query($conn, "SELECT * FROM anggota");
$anggota = mysqli_fetch_all($data, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];
    $data = mysqli_query($conn, "SELECT * FROM anggota WHERE nama LIKE '%$keyword%'");
    $anggota = mysqli_fetch_all($data, MYSQLI_ASSOC);
} else {
    if (isset($_POST['delete'])) {
        $id = $_POST['id_anggota'];

        $query = "DELETE FROM `anggota` WHERE id_anggota = $id ";
        $result = mysqli_query($conn, $query);
        if ($result) {

            echo "
        <script>
        alert('data  berhasil dihapus');
        window.location.href = 'app?page=anggota'
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
                    <h3>Data Anggota</h3>
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
                            <a href="./app?page=anggota&view=addanggota" class="btn btn-primary btn-sm"><i
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
                                    <th>nama</th>
                                    <th>nim/nidn</th>
                                    <th>program studi</th>
                                    <th>tahun bergabung</th>
                                    <th>alamat</th>
                                    <th>no hp</th>
                                    <th>jenis kelamin</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($anggota as $no => $a): ?>
                                <tr>
                                    <td><?= $a['nama']?>
                                    <td><?= $a['nim_nidn'] ?></td>
                                    <td><?= $a['program_studi'] ?></td>
                                    <td><?= $a['waktu_bergabung'] ?></td>
                                    <td><?= $a['alamat'] ?></td>
                                    <td><?= $a['noHP'] ?></td>
                                    <td><?= $a['jenis_kelamin'] ?></td>
                                    <td><a href="app?page=anggota&view=editanggota&id_anggota=<?= $a['id_anggota']?>"
                                            class="btn btn-warning btn-sm ms-3"><i
                                                class="fa-solid fa-pen-to-square"></i>edit</a>


                                        <form action="" method="POST" style="display: inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            <input type="hidden" name="id_anggota" value="<?= $a['id_anggota'] ?>">
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