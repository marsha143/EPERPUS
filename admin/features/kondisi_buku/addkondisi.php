<?php
if (isset($_POST['simpan'])) {
    $jenis_kondisi = $_POST['jenis_kondisi'];

    $query = "INSERT INTO kondisi_buku (jenis_kondisi) VALUES ('$jenis_kondisi')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
        <script>
            alert('kondisi_buku berhasil disimpan');
            window.location.href = 'app?page=kondisi_buku'
        </script>
        ";
    } else {
        echo "
        <script>
            alert('kondisi_buku gagal disimpan');
        </script>
        ";
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Tambah kondisi buku</h3>
        </div>

        <form action="" method="POST">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nama kondisi buku</label>
                    <input type="text" name="jenis_kondisi" class="form-control" placeholder="Masukkan nama kondisi_buku"
                        required>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i> Simpan
                </button>

                <a href="app?page=kondisi_buku" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>