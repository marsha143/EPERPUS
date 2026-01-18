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

#rekomCarousel .carousel-control-prev,
#rekomCarousel .carousel-control-next {
    width: 5%;
}

#rekomCarousel .carousel-control-prev-icon,
#rekomCarousel .carousel-control-next-icon {
    filter: invert(1) grayscale(100%);
}

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

#detailBukuModal .modal-title {
    font-weight: 600;
}

.pagination {
    gap: 12px;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    border-radius: 6px !important;
    padding: 8px 50px;
    font-weight: 500;
    color: #555;
    background: #fff;
    border: 1px solid #e5e5e5;
    transition: 0.2s ease;
}

.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background: #f5f5f5;
}

.pagination .page-item.disabled .page-link {
    color: #aaa !important;
    background: #f0f0f0 !important;
    border-color: #ddd !important;
}

.pagination .page-item:not(:first-child):not(:last-child) .page-link {
    width: 40px;
    height: 40px;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    background: #fff;
    color: #555;
    border: 1px solid #e5e5e5;
    transition: 0.2s ease;
}

.pagination .page-item:not(:first-child):not(:last-child) .page-link:hover {
    background: #f8f8f8;
}

.pagination .page-item.active .page-link {
    background: #e91e63 !important;
    border-color: #e91e63 !important;
    color: white !important;
}

/* === KARTU ANGGOTA EPERPUS ===*/
.kartu-anggota {
    border-radius: 18px;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff, #fff7f5);
    border: 1px solid #f3e5e5;
    max-width: 620px;
    margin-inline: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
}

.kartu-anggota-header {
    background: linear-gradient(90deg, #27aae1, #4b88a2ff);
    margin: -12px -12px 0 -12px;
    padding: 12px 20px;
    color: #fff;
}

.title-kartu {
    font-size: 0.9rem;
    letter-spacing: 0.06em;
}

.sub-title-kartu {
    font-size: 0.75rem;
    opacity: 0.9;
}

.kartu-anggota-body {
    padding: 16px 30px 10px 20px;
}

.blok-foto {
    min-width: 110px;
}

.kartu-anggota-foto {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    margin-bottom: 8px;
}

.chip-id {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 999px;
    background: #fbe9e7;
    font-size: 0.75rem;
    font-weight: 600;
    color: #2699ceff;
}

.info-row {
    display: flex;
    font-size: 0.85rem;
    padding: 5px 0;
    border-bottom: 1px dashed #f1d6d0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    width: 40%;
    font-weight: 600;
    color: #757575;
}

.info-value {
    flex: 1;
    color: #424242;
}

.kartu-anggota-footer {
    border-top: 1px solid #f3e5e5;
    padding-top: 8px;
    margin-top: 4px;
}

.btn-download-kartu {
    border-radius: 999px;
    padding-inline: 18px;
    font-size: 0.78rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    background: linear-gradient(90deg, #e91e63);
    border: none;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.btn-download-kartu:hover {
    filter: brightness(1.05);
    transform: translateY(-1px);
}

@media print {
    body {
        margin: 0;
    }

    body * {
        visibility: hidden !important;
    }

    #kartu-anggota,
    #kartu-anggota * {
        visibility: visible !important;
    }

    #kartu-anggota {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 140mm;
        box-shadow: none;
    }
}

.profile-photo .avatar-wrapper {
    position: relative;
    display: inline-block;
}

.avatar-profile {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #f1f1f1;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.avatar-upload-btn {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e91e63;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transition: 0.2s;
}

.avatar-upload-btn:hover {
    background: #c2185b;
    transform: scale(1.05);
}

.simpan {
    background: #c2185b;
    color: #fff;
}

.edit {
    background: #f0f2f5;
    border-radius: 7px;
}

</style>
</head>

<body class="index-page bg-gray-200">