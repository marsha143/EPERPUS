<?php
$data = mysqli_query($conn, "
    SELECT 
        bk.id_kerusakan,
        b.judul_buku,
        kb.jenis_kondisi,
        bk.created_at
    FROM buku_kondisi bk
    JOIN buku b ON bk.id_buku = b.id_buku
    JOIN kondisi_buku kb ON bk.id_kondisi = kb.id
    ORDER BY bk.created_at DESC
");

$kondisiBuku = mysqli_fetch_all($data, MYSQLI_ASSOC);

if (isset($_POST['delete'])) {
    $id = $_POST['id_kerusakan'];

    $query = "DELETE FROM buku_kondisi WHERE id_kerusakan = $id";
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

        <!-- HEADER -->
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3>Data Kondisi Buku</h3>
                </div>

                <div class="col-md-6 text-end">
                    <a href="app?page=kondisi_buku&view=addbukukondisi"
                       class="btn btn-success btn-sm">
                        <i class="fa-solid fa-book-medical"></i> Kondisikan Buku
                    </a>

                    <a href="app?page=kondisi_buku&view=addkondisi"
                       class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Kondisi
                    </a>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul buku</th>
                            <th>Kondisi</th>
                            <th>Tanggal</th>
                            <th width="140px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (count($kondisiBuku) == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Belum ada data kondisi buku
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($kondisiBuku as $k): ?>
                            <tr>
                                <td><?= $k['judul_buku'] ?></td>
                                <td>
                                    <span class="badge 
                                        <?= strtolower($k['jenis_kondisi']) == 'rusak' ? 'bg-danger' : 'bg-success' ?>">
                                        <?= ucfirst($k['jenis_kondisi']) ?>
                                    </span>
                                </td>
                                <td><?= date('d-m-Y H:i', strtotime($k['created_at'])) ?></td>
                                <td>
                                    <form method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <input type="hidden" name="id_kerusakan" value="<?= $k['id_kerusakan'] ?>">
                                        <button name="delete" class="btn btn-danger btn-sm">
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