<?php
if (isset($_POST['simpan'])) {
    $jenis_kondisi = trim($_POST['jenis_kondisi']);

    if ($jenis_kondisi == '') {
        echo "
        <script>
            alert('Nama jenis kondisi tidak boleh kosong');
            history.back();
        </script>";
        exit;
    }

    mysqli_query($conn, "
        INSERT INTO kondisi_buku (jenis_kondisi)
        VALUES ('$jenis_kondisi')
    ");

    echo "
    <script>
        alert('Jenis kondisi berhasil ditambahkan');
        window.location.href='app?page=kondisi_buku';
    </script>";
    exit;
}
?>


<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Tambah Jenis Kondisi Buku</h3>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Jenis Kondisi</label>
                    <div class="input-group input-group-outline">
                    <input type="text"
                           name="jenis_kondisi"
                           class="form-control"
                           placeholder="Contoh: Baik, Rusak Ringan, Rusak Berat"
                           required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" 
                            name="simpan" 
                            class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="app?page=kondisi_buku" 
                       class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>