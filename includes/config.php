<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'aldy_news');

$koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset('utf8');

// Fungsi untuk mencegah SQL injection
function clean_input($data) {
    global $koneksi;
    return $koneksi->real_escape_string(htmlspecialchars(trim($data)));
}
?>