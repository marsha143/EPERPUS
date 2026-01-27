<?php
$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku WHERE deleted_at IS NULL");
$kondisi = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);

if (isset($_POST['cari'])) {
    $keyword = $_POST['cari'];
    $data = mysqli_query($conn, "SELECT * FROM kondisi_buku WHERE jenis_kondisi LIKE '%$keyword%' AND deleted_at IS NULL");
    $kondisi = mysqli_fetch_all($data, MYSQLI_ASSOC);
} 

if (isset($_POST['delete'])) {
    $id = (int) $_POST['id'];

    mysqli_query($conn, "
        UPDATE kondisi_buku 
        SET deleted_at = CURRENT_TIMESTAMP 
        WHERE id = $id
    ");


    echo "<script>
        alert('Stok berhasil dihapus');
        window.location.href='app?page=kondisi_buku';
    </script>";
    exit;
}
?>


<div class="container mt-5">
    <div class="card">


        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h3>Data Kondisi</h3>
                </div>
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
                        <a href="app?page=kondisi_buku&view=add_jenis_kondisi" class="btn btn-outline-success btn-sm">
                            + Tambah jenis kondisi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kondisi</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kondisi as $k): ?>
                        <tr>

                            <td><?= $k['jenis_kondisi'] ?></td>

                            <td>
                                <!-- Hapus -->
                                <form method="post" style="display:inline;" onsubmit="return confirm('Hapus stok ini?')">
                                    <input type="hidden" name="id" value="<?= $k['id'] ?>">
                                    <button class="btn btn-outline-danger btn-sm" name="delete">
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