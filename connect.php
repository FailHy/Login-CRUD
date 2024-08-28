<?php
$host = 'localhost';  // Atau alamat server database
$db = 'webtest';      // Nama database
$user = 'root';       // Username database
$pass = '';           // Password database

$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}