<?php
$q_kondisi = mysqli_query($conn, "SELECT * FROM kondisi_buku");
$kondisi = mysqli_fetch_all($q_kondisi, MYSQLI_ASSOC);

  if (isset($_POST['delete'])) {
        $id = (int) $_POST['id'];

        mysqli_query($conn, "
        UPDATE genre
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
            <h5>Data Kondisi Buku (Seluruh Stok)</h5>
            <a href="app?page=kondisi_buku&view=add_jenis_kondisi" class="btn btn-success btn-sm">
                + Tambah jenis kondisi
            </a>
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
                                    <button class="btn btn-danger btn-sm" name="hapus">
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