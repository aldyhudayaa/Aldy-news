<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$berita_terbaru = berita_terbaru($koneksi, 5);
$kategori = ambil_kategori($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aldy News - Portal Berita Terkini</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <div class="main-content">
            <div class="content">
                <div class="search-box">
                    <form action="pencarian.php" method="get">
                        <input type="text" name="q" placeholder="Cari berita...">
                        <button type="submit">Cari</button>
                    </form>
                </div>
                
                <h2>Berita Terbaru</h2>
                
                <?php foreach ($berita_terbaru as $berita): ?>
                <div class="news-item">
                    <h3><a href="baca_berita.php?id=<?= $berita['id'] ?>"><?= htmlspecialchars($berita['judul']) ?></a></h3>
                    <p class="meta"><?= htmlspecialchars($berita['nama_kategori']) ?> | <?= format_tanggal($berita['dibuat_pada']) ?></p>
                    <p><?= excerpt(strip_tags($berita['isi']), 150) ?></p>
                    <a href="baca_berita.php?id=<?= $berita['id'] ?>" class="read-more">Baca Selengkapnya</a>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="sidebar">
                <h3>Kategori</h3>
                <ul class="category-list">
                    <?php foreach ($kategori as $kat): ?>
                    <li><a href="kategori.php?id=<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
