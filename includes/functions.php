<?php
function berita_terbaru($koneksi, $limit = 5) {
    $query = "SELECT b.*, k.nama AS nama_kategori 
              FROM berita b 
              JOIN kategori k ON b.kategori_id = k.id 
              ORDER BY b.dibuat_pada DESC 
              LIMIT ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function ambil_kategori($koneksi) {
    $query = "SELECT * FROM kategori ORDER BY nama ASC";
    $result = mysqli_query($koneksi, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function format_tanggal($tanggal) {
    return date('d M Y', strtotime($tanggal));
}

function excerpt($text, $length = 150) {
    return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}
?>
