<?php
require 'koneksi.php';

$produk = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM product ORDER BY id DESC"), MYSQLI_ASSOC);
$unggulan = $produk[0] ?? null;

$judul = 'Beranda';
include 'partials/header.php';
?>
<section class="hero">
    <div class="wrap">
        <div>
            <h1>Elektronik pilihan, harga jelas.</h1>
            <p>Smartphone dan perangkat elektronik dari Toko Bagas. Lihat detail dan harga tiap produk sebelum memutuskan.</p>
            <div class="hero-actions">
                <a class="btn btn-amber" href="#produk">Lihat produk</a>
                <?php if (!is_logged_in()): ?><a class="btn btn-line" href="register.php">Buat akun</a><?php endif; ?>
            </div>
        </div>
        <?php if ($unggulan): ?>
        <a class="stage" href="detail.php?id=<?= (int)$unggulan['id'] ?>" aria-label="Produk terbaru: <?= e($unggulan['nama']) ?>" style="text-decoration:none">
            <div class="thumb">
                <?php if ($url = gambar_url($unggulan['gambar'])): ?>
                    <img src="<?= e($url) ?>" alt="<?= e($unggulan['nama']) ?>">
                <?php else: ?><span class="noimg">Belum ada foto</span><?php endif; ?>
            </div>
            <span class="stage-name"><?= e($unggulan['nama']) ?></span>
            <span class="tag"><?= e(rupiah($unggulan['harga'])) ?></span>
        </a>
        <?php endif; ?>
    </div>
</section>

<section class="section" id="produk">
    <div class="wrap">
        <div class="section-head">
            <h2>Semua produk</h2>
            <span><?= count($produk) ?> produk</span>
        </div>
        <?php if ($produk): ?>
        <div class="grid">
            <?php foreach ($produk as $p): $url = gambar_url($p['gambar']); ?>
            <a class="card" href="detail.php?id=<?= (int)$p['id'] ?>">
                <div class="thumb">
                    <?php if ($url): ?><img src="<?= e($url) ?>" alt="<?= e($p['nama']) ?>" loading="lazy">
                    <?php else: ?><span class="noimg">Belum ada foto</span><?php endif; ?>
                </div>
                <div class="card-body">
                    <h3><?= e($p['nama']) ?></h3>
                    <p><?= e($p['deskripsi']) ?></p>
                    <div class="card-foot">
                        <span class="tag"><?= e(rupiah($p['harga'])) ?></span>
                        <span class="more">Lihat detail</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty">Belum ada produk. <?= is_logged_in() ? '<a href="dashboard.php">Tambah produk pertama</a>.' : 'Produk akan tampil di sini setelah ditambahkan.' ?></div>
        <?php endif; ?>
    </div>
</section>
<?php include 'partials/footer.php'; ?>
