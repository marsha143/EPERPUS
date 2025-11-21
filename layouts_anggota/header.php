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
    Material Kit 2 by Creative Tim
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
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
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
        box-shadow: 0 10px 30px rgba(0,0,0,0.18);
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
    box-shadow: 0 10px 30px rgba(0,0,0,.06);
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
    box-shadow: 0 12px 25px rgba(0,0,0,.12);
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
    background-color: rgba(0,0,0,.2);
    border-radius: 10px;
}

/* Supaya header modal rapi */
#detailBukuModal .modal-title {
    font-weight: 600;
}
</style>
</head>

<body class="index-page bg-gray-200">