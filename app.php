<?php

$page = $_GET['page'] ?? 'dashboard';
$view = $_GET['view'] ?? null;

/* ====== KHUSUS EXPORT ====== */
if ($page === 'peminjaman' && $view === 'export_exel') {
    require 'admin/features/peminjaman/export_exel.php';
    exit; 
}
?>
<?php include("./config/db.php"); ?>

<?php include('./admin/layouts/header.php'); ?>


<?php include('./admin/layouts/navbar.php'); ?>


<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home';
}
if (isset($_GET['view'])) {
    $view = $_GET['view'];
} else {
    $view = 'index';
}
    $features = "./admin/features/$page/$view.php";




if (file_exists($features)) {
    include($features);
} else {
    include ("./config/404.php");
}

