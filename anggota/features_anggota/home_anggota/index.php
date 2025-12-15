<?php
$idAnggota = $_SESSION['user']['id'] ?? 0;

$sqlSedang = "SELECT COUNT(*) AS jml FROM peminjaman WHERE id_anggota=$idAnggota AND status='Dipinjam'";
$sedang = mysqli_fetch_assoc(mysqli_query($conn, $sqlSedang))['jml'] ?? 0;

$sqlSelesai = "SELECT COUNT(*) AS jml FROM peminjaman WHERE id_anggota=$idAnggota AND status='Dikembalikan'";
$selesai = mysqli_fetch_assoc(mysqli_query($conn, $sqlSelesai))['jml'] ?? 0;

$sqlTotal = "SELECT COUNT(*) AS jml FROM peminjaman WHERE id_anggota=$idAnggota";
$total = mysqli_fetch_assoc(mysqli_query($conn, $sqlTotal))['jml'] ?? 0;

$sqlPopuler = "
    SELECT b.*, COUNT(p.id) AS total_pinjam , penulis.nama_penulis
    FROM peminjaman p
    JOIN buku b ON p.id_buku = b.id_buku
    LEFT JOIN penulis on penulis.id = b.id_penulis
    GROUP BY p.id_buku
    ORDER BY total_pinjam DESC
    LIMIT 4
";
$populer = mysqli_fetch_all(mysqli_query($conn, $sqlPopuler), MYSQLI_ASSOC);
$namaAnggota = htmlspecialchars($_SESSION['user']['username'] ?? 'Anggota');


$data = null;
$prodiAnggota = $alamatAnggota = $tahunGabungAnggota = $fotoPath = '';

if ($idAnggota) { 
    $sqlAnggota = "SELECT * FROM anggota WHERE id_anggota = $idAnggota";
    $resultAnggota = mysqli_query($conn, $sqlAnggota);
    $data = mysqli_fetch_assoc($resultAnggota);

    if ($data) {
        $idAnggota          = $data['id_anggota'];
        $prodiAnggota       = $data['program_studi'];
        $alamatAnggota      = $data['alamat'];
        $tahunGabungAnggota = $data['waktu_bergabung'];
        $fotoAnggota = $data['image'] ?? $data['foto'] ?? null;
        // path foto 
        $fotoPath = "uploads/" . (!empty($fotoAnggota) ? $fotoAnggota : "default.png");
    }
}
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <?php if (count($populer) == 0): ?>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-2">Buku Paling Sering Dipinjam</h5>
                    <p class="text-muted mb-0">Belum ada data peminjaman buku.</p>
                </div>
            </div>
            <?php else: ?>
            <?php $b = $populer[0]; ?>
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="row g-0 align-items-center" style="background: #f8f9fb;">
                    <div class="col-md-7">
                        <div class="p-5">
                            <small class="text-uppercase text-muted">
                                Buku Paling Sering Dipinjam
                            </small>
                            <h1 class="fw-bold mt-3 mb-2" style="letter-spacing: .05em; font-size: 2.7rem;">
                                <?= htmlspecialchars($b['judul_buku']) ?>
                            </h1>
                            <h5 class="text-secondary mb-4" style="font-weight: 400;">
                                <?= htmlspecialchars($b['nama_penulis']) ?>
                            </h5>
                            <span class="badge bg-primary-subtle text-primary me-2">
                                <?= $b['total_pinjam'] ?>x dipinjam
                            </span>
                            <span class="badge bg-primary text-white">
                                Populer di EPERPUS
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex justify-content-center align-items-center h-100 p-5">

                            <div class="bg-white rounded-3 shadow-sm p-3" style="max-width: 260px; cursor: pointer;">

                                <img src="<?= $b['cover'] ?>" class="img-fluid rounded-2" style="object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">
                        Selamat datang, <?= $namaAnggota; ?> 👋
                    </h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card shadow-sm border-0 mb-3">
                                <div class="card-body">
                                    <p class="text-muted mb-3">
                                        Berikut ringkasan aktivitas peminjaman Anda di EPERPUS.
                                    </p>
                                    <div class="d-flex flex-wrap gap-4">
                                        <div>
                                            <h5 class="mb-0"><?= $sedang ?></h5>
                                            <small class="text-muted">Buku sedang dipinjam</small>
                                        </div>
                                        <div>
                                            <h5 class="mb-0"><?= $selesai ?></h5>
                                            <small class="text-muted">Buku sudah dikembalikan</small>
                                        </div>
                                        <div>
                                            <h5 class="mb-0"><?= $total ?></h5>
                                            <small class="text-muted">Total peminjaman</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <small class="text-muted">
                                        Tips: cek menu <strong>Riwayat Peminjaman</strong> untuk melihat detail lengkap
                                        peminjaman Anda.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="kartu-anggota" class="card kartu-anggota shadow-sm border-0 p-3 position-relative">
                                <div class="d-flex justify-content-between align-items-center kartu-anggota-header">
                                    <div>
                                        <div class="fw-bold title-kartu">KARTU ANGGOTA EPERPUS</div>
                                        <small class="sub-title-kartu">Digital Member Card</small>
                                    </div>
                                    <img src="./assets/img/logo-takumi.png" class="navbar-brand-img h-100"
                                        alt="main_logo">
                                </div>
                                <div class="kartu-anggota-body d-flex align-items-center">
                                    <div class="blok-foto text-center me-4">
                                        <img src="<?= $fotoPath; ?>" alt="Foto Anggota" class="kartu-anggota-foto">
                                        <div class="chip-id">ID: <?= $idAnggota; ?></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="info-row">
                                            <div class="info-label">Nama</div>
                                            <div class="info-value"><?= $namaAnggota; ?></div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Program Studi</div>
                                            <div class="info-value"><?= $prodiAnggota; ?></div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Alamat</div>
                                            <div class="info-value"><?= $alamatAnggota; ?></div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Tahun Bergabung</div>
                                            <div class="info-value"><?= $tahunGabungAnggota; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=ID:<?= $idAnggota ?>|Nama:<?= urlencode($namaAnggota) ?>|Prodi:<?= urlencode($prodiAnggota) ?>"
                                    crossorigin="anonymous" class="position-absolute bottom-0 end-0 m-2"
                                    style="width:90px;height:90px" alt="QR Anggota">

                            </div>
                            <div class="text-end mt-3">
                                <button type="button" onclick="downloadKartuImg('png')" class="btn btn-primary btn-sm">
                                    DOWNLOAD PNG
                                </button>

                                <button type="button" onclick="downloadKartuImg('jpg')"
                                    class="btn btn-outline-primary btn-sm">
                                    DOWNLOAD JPG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('./anggota/layouts_anggota/footer.php'); ?>