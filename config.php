<?php
// config.php
// File konfigurasi untuk koneksi database

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_sekolah');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}
?>
