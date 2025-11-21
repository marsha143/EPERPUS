<?php include("./config/db.php"); ?>

<?php include('./layouts_anggota/header.php'); ?>

<?php include('./layouts_anggota/navbar.php'); ?>
<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home_anggota';
}
if (isset($_GET['view'])) {
    $view = $_GET['view'];
} else {
    $view = 'index';
}
    $features_anggota = "./features_anggota/$page/$view.php";




if (file_exists($features_anggota)) {
    include($features_anggota);
} else {
    include ("./config/404.php");
}
