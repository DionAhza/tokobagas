<?php
// Variabel: $judul (judul halaman)
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul ?? 'Beranda') ?> - Toko Elektronik Bagas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="nav">
    <div class="wrap">
        <a class="brand" href="index.php"><i>⚡</i> Toko Elektronik Bagas</a>
        <nav class="nav-links" aria-label="Menu utama">
            <a href="index.php">Produk</a>
            <?php if (is_logged_in()): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Keluar</a>
            <?php else: ?>
                <a href="login.php">Masuk</a>
                <a class="cta" href="register.php">Daftar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main>
<?php if ($flash): ?>
    <div class="wrap"><div class="flash <?= e($flash['type']) ?>" role="status"><?= e($flash['msg']) ?></div></div>
<?php endif; ?>
