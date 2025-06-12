<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once '../includes/config.php';

$result = mysqli_query($koneksi, "SELECT b.id, b.judul, k.nama AS kategori 
                                  FROM berita b 
                                  JOIN kategori k ON b.kategori_id = k.id 
                                  ORDER BY b.dibuat_pada DESC");
$berita = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Aldy News</title>
</head>
<body>
    <h2>Dashboard Admin</h2>
    <p><a href="tambah_berita.php">+ Tambah Berita</a> | <a href="kelola_kategori.php">Kelola Kategori</a> | <a href="logout.php">Logout</a></p>
    
    <table border="1" cellpadding="5">
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($berita as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['judul']) ?></td>
            <td><?= htmlspecialchars($b['kategori']) ?></td>
            <td>
                <a href="edit_berita.php?id=<?= $b['id'] ?>">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
