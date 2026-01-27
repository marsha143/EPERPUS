<?php
// Ambil setting denda
$q = mysqli_query($conn, "SELECT * FROM pengaturan_denda WHERE nama_setting='denda_harian'");
$data = mysqli_fetch_assoc($q);
$denda_harian = $data['nilai'] ?? 0;

// Simpan perubahan
if (isset($_POST['simpan'])) {
    $denda = intval($_POST['denda']);

    mysqli_query($conn, "
        UPDATE pengaturan_denda 
        SET nilai='$denda' 
        WHERE nama_setting='denda_harian'
    ");

    echo "<script>
        alert('Pengaturan denda berhasil disimpan');
        window.location.href='app?page=pengaturan_denda';
    </script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pengaturan Denda</h5>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label class="form-label">
                                Denda Keterlambatan (per hari)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input 
                                    type="number" 
                                    name="denda" 
                                    class="form-control"
                                    value="<?= $denda_harian ?>"
                                    min="0"
                                    required
                                >
                            </div>
                            <small class="text-muted">
                                Denda akan dikalikan dengan jumlah hari keterlambatan
                            </small>
                        </div>

                        <button type="submit" name="simpan" class="btn btn-outline-primary">
                            Simpan Pengaturan
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>