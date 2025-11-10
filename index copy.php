<?php include("./config/db.php"); ?>

<?php include('./layouts/header.php'); ?>
<?php include('./layouts/navbar.php'); ?>
<?php
// $page = $_GET['page'];
// $view = $_GET['view'];
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
    $features = "./features/$page/$view.php";




if (file_exists($features)) {
    include($features);
} else {
    include ("./config/404.php");
}


 include('./layouts/footer.php');


