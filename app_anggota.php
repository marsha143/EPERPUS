<?php
require './config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['user']['role'] !== 'anggota') {
    header('Location: login');
    exit;
}

$pages = [
    'home'   => './anggota/features_anggota/home_anggota/index.php',
    'profil' => './anggota/features_anggota/profil/index.php',
];

$page = $_GET['page'] ?? 'home';

if (!isset($pages[$page])) {
    include './config/404.php';
    exit;
}

include './anggota/layouts_anggota/header.php';
include './anggota/layouts_anggota/navbar.php';
include $pages[$page];
