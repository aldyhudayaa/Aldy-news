<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$kategori = ambil_kategori($koneksi);
?>

<header>
  <div class="container header-flex">
    <div class="logo" style="display: flex; align-items: center; gap: 10px;">
      <img src="assets/images/logo-aldy.png" alt="Aldy News" style="width: 40px; height: auto;">
      <h1><a href="index.php" style="text-decoration: none; color: inherit;">Aldy News</a></h1>
    </div>
    <nav class="nav-right">
      <ul class="nav-menu">
        <li><a href="index.php">Beranda</a></li>
        <li class="dropdown">
          <a href="#">Kategori</a>
          <ul class="dropdown-content">
            <?php foreach ($kategori as $kat): ?>
              <li><a href="kategori.php?id=<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li><a href="pencarian.php">Pencarian</a></li>
      </ul>
    </nav>
  </div>
</header>
