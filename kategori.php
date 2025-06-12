<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$kategori_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT b.*, k.nama AS nama_kategori 
          FROM berita b 
          JOIN kategori k ON b.kategori_id = k.id 
          WHERE k.id = ? 
          ORDER BY b.dibuat_pada DESC";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $kategori_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$berita_kategori = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori Berita - Aldy News</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Berita Kategori</h2>
        <?php foreach ($berita_kategori as $berita): ?>
        <div class="news-item">
            <h3><a href="baca_berita.php?id=<?= $berita['id'] ?>"><?= htmlspecialchars($berita['judul']) ?></a></h3>
            <p class="meta"><?= htmlspecialchars($berita['nama_kategori']) ?> | <?= format_tanggal($berita['dibuat_pada']) ?></p>
            <p><?= excerpt(strip_tags($berita['isi']), 150) ?></p>
            <a href="baca_berita.php?id=<?= $berita['id'] ?>" class="read-more">Baca Selengkapnya</a>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
