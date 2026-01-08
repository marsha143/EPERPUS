<?php
// Ambil semua kondisi
$data = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$kondisi = mysqli_fetch_all($data, MYSQLI_ASSOC);

// Fungsi Search
if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];

    $data = mysqli_query($conn, "SELECT * FROM kondisi_buku WHERE jenis_kondisi LIKE '%$keyword%'");
    $kondisi = mysqli_fetch_all($data, MYSQLI_ASSOC);
}

// Fungsi Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM kondisi_buku WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
        <script>
        alert('Data berhasil dihapus');
        window.location.href = 'app?page=kondisi_buku';
        </script>
        ";
    } else {
        echo "<script>alert('Data gagal dihapus');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Data kondisi</h3>
                </div>

                <div class="row">

                    <!-- Search -->
                    <div class="col-md-4">
                        <form role="search" method="POST">
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="cari" placeholder="Cari kondisi...">
                            </div>
                        </form>
                    </div>

                    <!-- Tambah -->
                    <div class="col-md-8">
                        <div class="text-end">
                            <a href="./app?page=kondisi_buku&view=addkondisi" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis kondisi</th>
                            <th width="180px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($kondisi as $g): ?>
                            <tr>
                                <td><?= $g['jenis_kondisi'] ?></td>

                                <td>
                                    <!-- EDIT -->
                                    <a href="app?page=kondisi_buku&view=editkondisi&id=<?= $g['id'] ?>"
                                        class="btn btn-warning btn-sm ms-2">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form action="" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus kondisi ini?')">
                                        <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                        <button class="btn btn-danger btn-sm" name="delete">
                                            <i class="fa-solid fa-trash"></i> Hapus
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