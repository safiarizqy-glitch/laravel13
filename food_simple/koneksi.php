<?php
$koneksi = mysqli_connect("localhost", "root", "", "food_order");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
