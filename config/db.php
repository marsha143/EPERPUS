<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "eperpus";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo ("koneksi gagal" . mysqli_connect_error());

}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
