<?php

$page = $_GET['page'] ?? 'dashboard';
$view = $_GET['view'] ?? null;

/* ====== KHUSUS EXPORT ====== */
if ($page === 'peminjaman' && $view === 'export_exel') {
    require 'admin/features/peminjaman/export_exel.php';
    exit; 
}
?>
<?php
require './config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login');
    exit;
}

$pages = [
    'dashboard' => './admin/features/dashboard/index.php',
    'anggota'   => './admin/features/anggota/index.php',
];

$page = $_GET['page'] ?? 'dashboard';

if (!isset($pages[$page])) {
    include './config/404.php';
    exit;
}

include './admin/layouts/header.php';
include './admin/layouts/navbar.php';
include $pages[$page];
