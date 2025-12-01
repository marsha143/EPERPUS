<?php
if (isset($_POST['simpan'])) {
    $jenis_genre = $_POST['jenis_genre'];

    $query = "INSERT INTO genre (jenis_genre) VALUES ('$jenis_genre')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
        <script>
            alert('Genre berhasil disimpan');
            window.location.href = 'app?page=genre'
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Genre gagal disimpan');
        </script>
        ";
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Genre</h3>
        </div>

        <form action="" method="POST">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nama Genre</label>
                    <input type="text" name="jenis_genre" class="form-control" placeholder="Masukkan nama genre"
                        required>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i> Simpan
                </button>

                <a href="app?page=genre" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>