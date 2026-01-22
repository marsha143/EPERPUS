<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "EPERPUS");
if (!$conn) {
    die("Koneksi database gagal");
}
