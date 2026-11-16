<?php
require 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);
$data = q($koneksi, "SELECT * FROM product WHERE id = ?", 'i', [$id])->get_result()->fetch_assoc();

if (!$data) {
    http_response_code(404);
    $judul = 'Produk tidak ditemukan';
    include 'partials/header.php';
    echo '<div class="wrap"><div class="empty" style="margin:3rem 0">Produk tidak ditemukan atau sudah dihapus. <a href="index.php">Kembali ke daftar produk</a>.</div></div>';
    include 'partials/footer.php';
    exit;
}

$url = gambar_url($data['gambar']);
$judul = $data['nama'];
include 'partials/header.php';
?>
<div class="wrap">
    <a class="back" href="index.php">Kembali ke produk</a>
    <div class="detail">
        <div class="thumb">
            <?php if ($url): ?><img src="<?= e($url) ?>" alt="<?= e($data['nama']) ?>">
            <?php else: ?><span class="noimg">Belum ada foto</span><?php endif; ?>
        </div>
        <div>
            <h1><?= e($data['nama']) ?></h1>
            <span class="tag tag-lg"><?= e(rupiah($data['harga'])) ?></span>
            <p class="desc"><?= nl2br(e($data['deskripsi'])) ?></p>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
