<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$kategori = ambil_kategori($koneksi);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori_id = $_POST['kategori_id'];
    $gambar = '';

    // Proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_name = time() . '_' . basename($_FILES['gambar']['name']);
        $upload_path = '../uploads/' . $gambar_name;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
            $gambar = $gambar_name;
        }
    }

    $query = "INSERT INTO berita (judul, isi, kategori_id, gambar, dibuat_pada) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ssis', $judul, $isi, $kategori_id, $gambar);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
</head>
<body>
    <h2>Tambah Berita</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Judul:</label><br>
        <input type="text" name="judul" placeholder="Judul berita" required><br><br>

        <label>Isi Berita:</label><br>
        <textarea name="isi" placeholder="Isi berita" rows="10" cols="50" required></textarea><br><br>

        <label>Kategori:</label><br>
        <select name="kategori_id" required>
            <?php foreach ($kategori as $kat): ?>
            <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Upload Gambar:</label><br>
        <input type="file" name="gambar" accept="image/*"><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
