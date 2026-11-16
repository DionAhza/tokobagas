<?php
require 'koneksi.php';
require_login(); // wajib login sebelum apa pun diproses

$produk = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM product ORDER BY id DESC"), MYSQLI_ASSOC);

$judul = 'Dashboard';
include 'partials/header.php';
?>
<div class="wrap">
    <div class="dash-head">
        <div>
            <h1>Halo, <?= e($_SESSION['nama_akun']) ?></h1>
            <p><?= count($produk) ?> produk di toko Anda.</p>
        </div>
        <a class="btn btn-line" href="index.php">Lihat toko</a>
    </div>

    <div class="dash-grid">
        <section class="panel">
            <h2>Tambah produk</h2>
            <form action="create.php" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="field">
                    <label for="nama_produk">Nama produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" required maxlength="150">
                </div>
                <div class="field">
                    <label for="deskripsi_produk">Deskripsi</label>
                    <textarea id="deskripsi_produk" name="deskripsi_produk"></textarea>
                </div>
                <div class="field">
                    <label for="harga_produk">Harga (Rp)</label>
                    <input type="number" id="harga_produk" name="harga_produk" required min="0" step="1">
                </div>
                <div class="field">
                    <label for="gambar_produk">Foto produk</label>
                    <img class="preview" id="pratinjau" alt="Pratinjau foto" hidden>
                    <input type="file" id="gambar_produk" name="gambar_produk" accept="image/jpeg,image/png,image/webp" data-preview="pratinjau">
                    <p class="hint">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                </div>
                <button class="btn btn-block" type="submit" name="simpan">Simpan produk</button>
            </form>
        </section>

        <section class="panel">
            <h2>Daftar produk</h2>
            <?php if ($produk): ?>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Foto</th><th>Produk</th><th>Harga</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php foreach ($produk as $p): $url = gambar_url($p['gambar']); ?>
                        <tr>
                            <td><?php if ($url): ?><img class="mini" src="<?= e($url) ?>" alt=""><?php else: ?><div class="mini-empty"></div><?php endif; ?></td>
                            <td class="nama"><?= e($p['nama']) ?><small><?= e($p['deskripsi']) ?></small></td>
                            <td><?= e(rupiah($p['harga'])) ?></td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-line btn-sm" href="detail.php?id=<?= (int)$p['id'] ?>">Detail</a>
                                    <a class="btn btn-line btn-sm" href="edit.php?id=<?= (int)$p['id'] ?>">Edit</a>
                                    <form action="delete.php" method="post" data-confirm="Hapus &quot;<?= e($p['nama']) ?>&quot;? Tindakan ini tidak bisa dibatalkan.">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="empty">Belum ada produk. Isi formulir di samping untuk menambah produk pertama.</div>
            <?php endif; ?>
        </section>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
