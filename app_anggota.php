<?php include("./config/db.php"); ?>

<?php include('./layouts/header.php'); ?>

<?php include('./layouts/navbar_anggota.php'); ?>
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
