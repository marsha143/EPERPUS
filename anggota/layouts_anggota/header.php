<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link id="pagestyle" href="asset/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<title>
    EPERPUS
</title>
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
<!-- Nucleo Icons -->
<link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
<link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<!-- CSS Files -->
<link id="pagestyle" href="./assets/css/material-kit.css?v=3.0.0" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
/* GRID ala Booksaw */
.book-grid {
    margin-top: 2.5rem;
    margin-bottom: 2.5rem;
}

.book-card {
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    border: none;
    transition: 0.25s;
    cursor: pointer;
    background: #ffffff;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
}

.book-card img {
    height: 250px;
    object-fit: cover;
}

.book-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 4px;
}

.book-author {
    font-size: 14px;
    color: #6c757d;
}

.badge-status {
    font-size: 11px;
    border-radius: 999px;
    padding: 4px 10px;
}


/* --- Rekomendasi slider --- */
.rekom-wrapper {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
    margin-bottom: 24px;
}

.rekom-slider-card {
    border-radius: 18px;
    overflow: hidden;
    cursor: pointer;
    transition: transform .2s ease, box-shadow .2s ease;
}

.rekom-slider-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
}

.rekom-slider-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, .12);
}

.rekom-caption-date {
    font-size: 12px;
    color: #6c757d;
}

/* Tombol carousel */
#rekomCarousel .carousel-control-prev,
#rekomCarousel .carousel-control-next {
    width: 5%;
}

#rekomCarousel .carousel-control-prev-icon,
#rekomCarousel .carousel-control-next-icon {
    filter: invert(1) grayscale(100%);
}

/* --- Modal deskripsi scroll --- */
.modal-desc-wrapper {
    max-height: 220px;
    overflow-y: auto;
    padding-right: 4px;
}

.modal-desc-wrapper::-webkit-scrollbar {
    width: 6px;
}

.modal-desc-wrapper::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, .2);
    border-radius: 10px;
}

/* Supaya header modal rapi */
#detailBukuModal .modal-title {
    font-weight: 600;
}
/* Wrapper pagination */
.pagination {
    gap: 6px;
}

/* --- PREVIOUS & NEXT (kotak) --- */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    border-radius: 6px !important;      /* kotak rounded */
    padding: 8px 14px;
    font-weight: 500;
    color: #555;
    background: #fff;
    border: 1px solid #e5e5e5;
    transition: 0.2s ease;
}

/* Hover effect untuk Previous & Next */
.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background: #f5f5f5;
}

/* Disabled state */
.pagination .page-item.disabled .page-link {
    color: #aaa !important;
    background: #f0f0f0 !important;
    border-color: #ddd !important;
}


/* --- ANGKA (lingkaran) --- */
.pagination .page-item:not(:first-child):not(:last-child) .page-link {
    width: 40px;
    height: 40px;
    border-radius: 50% !important;     /* bulat */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    background: #fff;
    color: #555;
    border: 1px solid #e5e5e5;
    transition: 0.2s ease;
}

/* Hover angka */
.pagination .page-item:not(:first-child):not(:last-child) .page-link:hover {
    background: #f8f8f8;
}

/* Active number (warna pink seperti gambar) */
.pagination .page-item.active .page-link {
    background: #e91e63 !important;      /* warna pink */
    border-color: #e91e63 !important;
    color: white !important;
}

/* === KARTU ANGGOTA EPERPUS === */

.kartu-anggota {
    position: relative;
    overflow: hidden;
    /* soft gradient merah Takumi + biru muda */
    background: linear-gradient(135deg, #ffe3ea, #e7f0ff);
    border-radius: 18px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}

/* strip warna di atas kartu (modern) */
.kartu-anggota::before {
    content: "";
    position: absolute;
    top: 0;
    left: -20%;
    width: 140%;
    height: 6px;
    background: linear-gradient(90deg, #d62828, #243b64);
}

/* Header kartu */
.kartu-anggota-header .fw-bold {
    font-size: 14px;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #243b64; /* biru tua ala kampus */
}

/* Badge AKTIF */
.badge-anggota {
    background-color: rgba(214, 40, 40, 0.12); /* merah Takumi lembut */
    color: #d62828;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 999px;
    font-weight: 600;
}

/* Foto anggota */
.kartu-anggota-foto {
    width: 90px;
    height: 90px;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Baris data (Nama, Prodi, dst) jadi rapi dua kolom */
#kartu-anggota .mb-2 {
    display: flex;
    gap: 6px;
    font-size: 13px;
}

#kartu-anggota .mb-2 strong {
    min-width: 120px;
    color: #444;
}

#kartu-anggota .mb-2 .text-muted {
    flex: 1;
}

/* Tombol download biar kelihatan kartu */
#kartu-anggota + .mt-3 .btn,
#kartu-anggota .btn {
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* Tombolnya merah Takumi */
#kartu-anggota .btn-outline-primary {
    border-color: #d62828;
    color: #d62828;
}
#kartu-anggota .btn-outline-primary:hover {
    background-color: #d62828;
    color: #fff;
}

/* PRINT: hanya kartu yang tercetak */
@media print {
    body {
        margin: 0;
    }

    /* Sembunyikan semua elemen */
    body * {
        visibility: hidden !important;
    }

    /* Tampilkan hanya kartu */
    #kartu-anggota, #kartu-anggota * {
        visibility: visible !important;
    }

    /* Posisikan kartu di tengah halaman dan cukup besar */
    #kartu-anggota {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 140mm; /* kira-kira selebar ID card besar */
        box-shadow: none; /* supaya tidak ada bayangan di print */
    }
}

</style>
</head>

<body class="index-page bg-gray-200">