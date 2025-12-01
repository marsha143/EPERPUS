<?php
// Ambil ID genre dari URL
$id_genre = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Jika id tidak valid
if ($id_genre <= 0) {
    echo "
        <script>
            alert('ID genre tidak valid!');
            window.location.href = 'app?page=genre';
        </script>
    ";
    exit;
}

// Ambil data genre berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM genre WHERE id = $id_genre");
$genre = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$genre) {
    echo "
        <script>
            alert('Data genre tidak ditemukan!');
            window.location.href = 'app?page=genre';
        </script>
    ";
    exit;
}

// Proses update
if (isset($_POST['simpan'])) {
    $jenis_genre = $_POST['jenis_genre'];

    $update = "UPDATE genre SET jenis_genre = '$jenis_genre' WHERE id = $id_genre";

    $result = mysqli_query($conn, $update);

    if ($result) {
        echo "
        <script>
            alert('Genre berhasil diperbarui');
            window.location.href = 'app?page=genre';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Genre gagal diperbarui');
        </script>
        ";
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Edit Genre</h3>
        </div>

        <form action="" method="POST">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Jenis Genre</label>
                    <input type="text" name="jenis_genre" class="form-control" value="<?= $genre['jenis_genre'] ?>"
                        required>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>

                <a href="app?page=genre" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>