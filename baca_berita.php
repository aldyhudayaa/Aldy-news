<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT b.*, k.nama AS nama_kategori 
          FROM berita b 
          JOIN kategori k ON b.kategori_id = k.id 
          WHERE b.id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$berita = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($berita['judul']) ?> - Aldy News</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .news-image {
            display: block;
            margin: 20px auto;
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .news-content {
            white-space: pre-line;
            font-size: 1.1em;
            line-height: 1.8;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2><?= htmlspecialchars($berita['judul']) ?></h2>
        <p class="meta"><?= htmlspecialchars($berita['nama_kategori']) ?> | <?= format_tanggal($berita['dibuat_pada']) ?></p>

        <?php if (!empty($berita['gambar'])): ?>
            <img class="news-image" src="uploads/<?= htmlspecialchars($berita['gambar']) ?>" alt="<?= htmlspecialchars($berita['judul']) ?>">
        <?php endif; ?>

        <div class="news-content">
        <?= $berita['isi'] ?>
    </div>

    </div>
</body>
</html>
