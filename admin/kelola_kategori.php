<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Tambah kategori
if (isset($_POST['nama'])) {
    $nama = trim($_POST['nama']);
    if ($nama !== '') {
        $query = "INSERT INTO kategori (nama) VALUES (?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 's', $nama);
        mysqli_stmt_execute($stmt);
    }
}

// Ambil kategori
$result = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama ASC");
$kategori = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kelola Kategori</title>
</head>
<body>
    <h2>Kelola Kategori</h2>
    <form method="post">
        <input type="text" name="nama" placeholder="Nama kategori" required>
        <button type="submit">Tambah</button>
    </form>
    
    <ul>
        <?php foreach ($kategori as $kat): ?>
        <li><?= htmlspecialchars($kat['nama']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <p><a href="index.php">Kembali ke Dashboard</a></p>
</body>
</html>
