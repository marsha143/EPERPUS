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
include './config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login');
    exit;
}


include './admin/layouts/header.php';
include './admin/layouts/navbar.php';

$page = $_GET['page'] ?? 'home';
$view = $_GET['view'] ?? 'index';


$page = basename($page);
$view = basename($view);

$features = "./admin/features/$page/$view.php";

if (file_exists($features)) {
    include $features;
} else {
    include './config/404.php';
}
