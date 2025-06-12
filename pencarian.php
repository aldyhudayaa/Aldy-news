<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT b.*, k.nama AS nama_kategori 
        FROM berita b 
        JOIN kategori k ON b.kategori_id = k.id 
        WHERE b.judul LIKE ? OR b.isi LIKE ? 
        ORDER BY b.dibuat_pada DESC";

$stmt = mysqli_prepare($koneksi, $sql);
$search = "%$query%";
mysqli_stmt_bind_param($stmt, 'ss', $search, $search);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$hasil = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian - Aldy News</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Hasil Pencarian untuk: "<?= htmlspecialchars($query) ?>"</h2>
        <?php if ($hasil): ?>
            <?php foreach ($hasil as $berita): ?>
            <div class="news-item">
                <h3><a href="baca_berita.php?id=<?= $berita['id'] ?>"><?= htmlspecialchars($berita['judul']) ?></a></h3>
                <p class="meta"><?= htmlspecialchars($berita['nama_kategori']) ?> | <?= format_tanggal($berita['dibuat_pada']) ?></p>
                <p><?= excerpt(strip_tags($berita['isi']), 150) ?></p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ditemukan berita yang cocok.</p>
        <?php endif; ?>
    </div>
</body>
</html>
