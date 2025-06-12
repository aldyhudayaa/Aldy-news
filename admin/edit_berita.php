<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM berita WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$berita = mysqli_fetch_assoc($result);

if (!$berita) {
    die("Berita tidak ditemukan.");
}

$kategori = ambil_kategori($koneksi);

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori_id = $_POST['kategori_id'];

    $update = "UPDATE berita SET judul = ?, isi = ?, kategori_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $update);
    mysqli_stmt_bind_param($stmt, 'ssii', $judul, $isi, $kategori_id, $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

// Proses hapus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    $hapus = "DELETE FROM berita WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $hapus);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
</head>
<body>
    <h2>Edit Berita</h2>
    <form method="post">
        <input type="text" name="judul" value="<?= htmlspecialchars($berita['judul']) ?>" required><br><br>

        <textarea name="isi" rows="10" cols="80" required><?= htmlspecialchars($berita['isi']) ?></textarea><br><br>
        <script>
            CKEDITOR.replace('isi'); // Aktifkan editor teks HTML (bold, italic, dll)
        </script>

        <select name="kategori_id" required>
            <?php foreach ($kategori as $kat): ?>
                <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $berita['kategori_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kat['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit" name="update">Update</button>
    </form>

    <form method="post" onsubmit="return confirm('Yakin ingin menghapus berita ini?');" style="margin-top: 20px;">
        <input type="hidden" name="hapus" value="1">
        <button type="submit" style="color: red;">Hapus Berita</button>
    </form>
</body>
</html>
