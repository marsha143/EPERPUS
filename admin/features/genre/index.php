<?php
// Ambil semua genre
$data = mysqli_query($conn, "SELECT * FROM genre WHERE deleted_at IS NULL");
$genre = mysqli_fetch_all($data, MYSQLI_ASSOC);

// Fungsi Search
if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];

    $data = mysqli_query($conn, "SELECT * FROM genre WHERE jenis_genre LIKE '%$keyword%' AND deleted_at IS NULL");
    $genre = mysqli_fetch_all($data, MYSQLI_ASSOC);
}

// Fungsi Delete
 if (isset($_POST['delete'])) {
        $id = (int) $_POST['id'];

        mysqli_query($conn, "
        UPDATE genre 
        SET deleted_at = CURRENT_TIMESTAMP 
        WHERE id = $id
    ");


        echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=genre';
    </script>";
        exit;
 }
?>

<div class="container mt-5">
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Data Genre</h3>
                </div>

                <div class="row">

                    <!-- Search -->
                    <div class="col-md-4">
                        <form role="search" method="POST">
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="cari" placeholder="Cari genre...">
                            </div>
                        </form>
                    </div>

                    <!-- Tambah -->
                    <div class="col-md-8">
                        <div class="text-end">
                            <a href="./app?page=genre&view=addgenre" class="btn btn-outline-primary btn-sm">
                               + Tambah
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
                            <th>Jenis Genre</th>
                            <th width="180px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($genre as $g): ?>
                            <tr>
                                <td><?= $g['jenis_genre'] ?></td>

                                <td>
                                    <!-- EDIT -->
                                    <a href="app?page=genre&view=editgenre&id=<?= $g['id'] ?>"
                                        class="btn btn-outline-warning btn-sm ms-2">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form action="" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus genre ini?')">
                                        <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                        <button class="btn btn-outline-danger btn-sm" name="delete">
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