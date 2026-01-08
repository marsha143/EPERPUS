<?php
// Ambil ID kondisi dari URL
$id_kondisi = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Jika id tidak valid
if ($id_kondisi <= 0) {
    echo "
        <script>
            alert('ID kondisi tidak valid!');
            window.location.href = 'app?page=kondisi_buku';
        </script>
    ";
    exit;
}

// Ambil data kondisi berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM kondisi WHERE id = $id_kondisi");
$kondisi = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$kondisi) {
    echo "
        <script>
            alert('Data kondisi tidak ditemukan!');
            window.location.href = 'app?page=kondisi_buku';
        </script>
    ";
    exit;
}

// Proses update
if (isset($_POST['simpan'])) {
    $jenis_kondisi = $_POST['jenis_kondisi'];

    $update = "UPDATE kondisi SET jenis_kondisi = '$jenis_kondisi' WHERE id = $id_kondisi";

    $result = mysqli_query($conn, $update);

    if ($result) {
        echo "
        <script>
            alert('kondisi berhasil diperbarui');
            window.location.href = 'app?page=kondisi_buku';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('kondisi gagal diperbarui');
        </script>
        ";
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Edit kondisi</h3>
        </div>

        <form action="" method="POST">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Jenis kondisi</label>
                    <input type="text" name="jenis_kondisi" class="form-control" value="<?= $kondisi['jenis_kondisi'] ?>"
                        required>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>

                <a href="app?page=kondisi_buku" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>