<?php
include './config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['user']['role'] !== 'anggota') {
    header('Location: login');
    exit;
}

include './anggota/layouts_anggota/header.php';
include './anggota/layouts_anggota/navbar.php';

$page = $_GET['page'] ?? 'home_anggota';
$view = $_GET['view'] ?? 'index';

$page = basename($page);
$view = basename($view);

$features_anggota = "./anggota/features_anggota/$page/$view.php";

if (file_exists($features_anggota)) {
    include $features_anggota;
} else {
    include './config/404.php';
}