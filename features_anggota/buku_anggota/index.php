<?php

$where = [];

if (!empty($_GET['judul'])) {
    $where[] = "b.judul_buku LIKE '%" . $_GET['judul'] . "%'";
}
if (!empty($_GET['isbn'])) {
    $where[] = "b.isbn LIKE '%" . $_GET['isbn'] . "%'";
}
if (!empty($_GET['penulis'])) {
    $where[] = "b.nama_penulis LIKE '%" . $_GET['penulis'] . "%'";
}
if (!empty($_GET['penerbit'])) {
    $where[] = "b.penerbit LIKE '%" . $_GET['penerbit'] . "%'";
}
if (!empty($_GET['tahun'])) {
    $where[] = "b.tahun_terbit = '" . $_GET['tahun'] . "'";
}
if (!empty($_GET['kode_buku'])) {
    $where[] = "b.kode_buku LIKE '%" . $_GET['kode_buku'] . "%'";
}

$whereSQL = '';
if (count($where) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $where);
}

$sql = "
  SELECT 
    b.*, 
    CASE 
      WHEN p.status = 'Dipinjam' THEN 'Dipinjam'
      ELSE 'Tersedia'
    END AS status_buku
  FROM buku b
  LEFT JOIN peminjaman p 
    ON b.id_buku = p.id_buku 
    AND p.status = 'Dipinjam'
  $whereSQL
";
$data = mysqli_query($conn, $sql);
$buku = mysqli_fetch_all($data, MYSQLI_ASSOC);

$sqlRekom = "
  SELECT 
    b.*, 
    CASE 
      WHEN p.status = 'Dipinjam' THEN 'Dipinjam'
      ELSE 'Tersedia'
    END AS status_buku
  FROM buku b
  LEFT JOIN peminjaman p 
    ON b.id_buku = p.id_buku 
    AND p.status = 'Dipinjam'
  ORDER BY
    CAST(SUBSTRING_INDEX(b.tahun_terbit, ' ', -1) AS UNSIGNED) DESC,
    FIELD(
      SUBSTRING_INDEX(SUBSTRING_INDEX(b.tahun_terbit, ' ', 2), ' ', -1),
      'Januari','Februari','Maret','April','Mei','Juni',
      'Juli','Agustus','September','Oktober','November','Desember'
    ) DESC,
    CAST(SUBSTRING_INDEX(b.tahun_terbit, ' ', 1) AS UNSIGNED) DESC,
    b.id_buku DESC
  LIMIT 5
";
$dataRekom = mysqli_query($conn, $sqlRekom);
$rekom = mysqli_fetch_all($dataRekom, MYSQLI_ASSOC);

?>


<div class="container book-grid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Rekomendasi Buku Terbaru</h5>
        <span class="rekom-top-label text-muted" style="font-size: 13px;">
            Top 5 berdasarkan tanggal input terbaru
        </span>
    </div>

    <div class="card rekom-wrapper">
        <div class="card-body">

            <?php if (count($rekom) > 0): ?>
                <div id="rekomCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">

                        <?php
                        $chunks = array_chunk($rekom, 3);
                        foreach ($chunks as $index => $chunk):
                            ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row justify-content-center">

                                    <?php foreach ($chunk as $r): ?>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="card book-card mb-3 rekom-slider-card" onclick="openDetailBuku(this)"
                                                data-cover="<?= $r['cover'] ?>"
                                                data-judul="<?= htmlspecialchars($r['judul_buku']) ?>"
                                                data-kode="<?= htmlspecialchars($r['kode_buku']) ?>"
                                                data-isbn="<?= htmlspecialchars($r['isbn']) ?>"
                                                data-penulis="<?= htmlspecialchars($r['nama_penulis']) ?>"
                                                data-tahun="<?= htmlspecialchars($r['tahun_terbit']) ?>"
                                                data-penerbit="<?= htmlspecialchars($r['penerbit']) ?>"
                                                data-status="<?= htmlspecialchars($r['status_buku']) ?>"
                                                data-deskripsi="<?= htmlspecialchars($r['deskripsi'] ?? 'Belum ada deskripsi buku.') ?>">

                                                <img src="<?= $r['cover'] ?>" alt="cover">

                                                <div class="card-body text-center">
                                                    <div class="book-title"><?= $r['judul_buku'] ?></div>
                                                    <div class="book-author"><?= $r['nama_penulis'] ?></div>

                                                    <div class="mt-2">
                                                        <?php if ($r['status_buku'] == 'Dipinjam'): ?>
                                                            <span class="badge-status bg-danger text-white">DIPINJAM</span>
                                                        <?php else: ?>
                                                            <span class="badge-status bg-success text-white">TERSEDIA</span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mt-2 rekom-caption-date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#rekomCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#rekomCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

            <?php else: ?>
                <p class="text-muted mb-0">Belum ada data buku.</p>
            <?php endif; ?>

        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Buku</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchModal">
            Search Buku
        </button>
    </div>

    <div class="row">
        <?php foreach ($buku as $b): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card book-card" onclick="openDetailBuku(this)" data-cover="<?= $b['cover'] ?>"
                    data-judul="<?= htmlspecialchars($b['judul_buku']) ?>"
                    data-kode="<?= htmlspecialchars($b['kode_buku']) ?>" data-isbn="<?= htmlspecialchars($b['isbn']) ?>"
                    data-penulis="<?= htmlspecialchars($b['nama_penulis']) ?>"
                    data-tahun="<?= htmlspecialchars($b['tahun_terbit']) ?>"
                    data-penerbit="<?= htmlspecialchars($b['penerbit']) ?>"
                    data-status="<?= htmlspecialchars($b['status_buku']) ?>"
                    data-deskripsi="<?= htmlspecialchars($b['deskripsi'] ?? 'Belum ada deskripsi buku.') ?>">

                    <img src="<?= $b['cover'] ?>" class="card-img-top" alt="cover">

                    <div class="card-body text-center">
                        <div class="book-title"><?= $b['judul_buku'] ?></div>
                        <div class="book-author"><?= $b['nama_penulis'] ?></div>
                        <div class="mt-2">
                            <?php if ($b['status_buku'] == 'Dipinjam'): ?>
                                <span class="badge-status bg-danger text-white">DIPINJAM</span>
                            <?php else: ?>
                                <span class="badge-status bg-success text-white">TERSEDIA</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

        <?php if (count($buku) === 0): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center mb-0">
                    Tidak ada buku yang cocok dengan pencarian.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="modal fade" id="detailBukuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJudulBuku">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img id="modalCover" src="" alt="cover" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-md-8">
                        <h5 id="modalJudul" class="mb-1"></h5>
                        <p class="text-muted mb-2" id="modalPenulis"></p>

                        <p class="mb-1"><strong>Kode Buku:</strong> <span id="modalKode"></span></p>
                        <p class="mb-1"><strong>ISBN:</strong> <span id="modalIsbn"></span></p>
                        <p class="mb-1"><strong>Tahun Terbit:</strong> <span id="modalTahun"></span></p>
                        <p class="mb-1"><strong>Penerbit:</strong> <span id="modalPenerbit"></span></p>
                        <p class="mt-2"><strong>Status:</strong> <span id="modalStatus" class="badge-status"></span></p>

                        <hr>

                        <div class="modal-desc-wrapper">
                            <p id="modalDeskripsi" class="mb-0"></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Search Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="" method="GET">
                <div class="modal-body">

                    <input type="hidden" name="page" value="buku_anggota">

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Masukkan ISBN">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control"
                               placeholder="Masukkan Penulis">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun" min="2000" class="form-control" placeholder="Contoh: 2024">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control" placeholder="Masukkan penerbit">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kode Buku</label>
                        <input type="text" name="kode_buku" class="form-control" placeholder="Masukkan kode buku">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php include('./layouts/footer.php'); ?>