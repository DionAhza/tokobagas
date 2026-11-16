<?php
require 'koneksi.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$data = q($koneksi, "SELECT * FROM product WHERE id = ?", 'i', [$id])->get_result()->fetch_assoc();
if (!$data) {
    flash('error', 'Produk tidak ditemukan.');
    redirect('dashboard.php');
}

if (isset($_POST['update'])) {
    require_post("edit.php?id=$id");

    $nama = trim($_POST['nama_produk'] ?? '');
    $deskripsi = trim($_POST['deskripsi_produk'] ?? '');
    $harga = $_POST['harga_produk'] ?? '';

    if ($nama === '' || !ctype_digit((string)$harga)) {
        flash('error', 'Nama produk wajib diisi dan harga harus berupa angka.');
        redirect("edit.php?id=$id");
    }

    $error = null;
    $gambarBaru = upload_gambar($_FILES['gambar_produk'] ?? [], $error);
    if ($error) {
        flash('error', $error);
        redirect("edit.php?id=$id");
    }

    $gambar = $gambarBaru ?? $data['gambar']; // tanpa upload baru, foto lama dipertahankan
    q($koneksi, "UPDATE product SET nama = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id = ?",
        'ssisi', [$nama, $deskripsi, (int)$harga, $gambar, $id]);

    if ($gambarBaru) hapus_gambar($koneksi, $data['gambar']);

    flash('success', 'Produk berhasil diperbarui.');
    redirect('dashboard.php');
}

$url = gambar_url($data['gambar']);
$judul = 'Edit ' . $data['nama'];
include 'partials/header.php';
?>
<div class="wrap" style="max-width:640px;padding:2rem 0 4rem">
    <div class="panel">
        <h2>Edit produk</h2>
        <form action="edit.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="field">
                <label for="nama_produk">Nama produk</label>
                <input type="text" id="nama_produk" name="nama_produk" required maxlength="150" value="<?= e($data['nama']) ?>">
            </div>
            <div class="field">
                <label for="deskripsi_produk">Deskripsi</label>
                <textarea id="deskripsi_produk" name="deskripsi_produk"><?= e($data['deskripsi']) ?></textarea>
            </div>
            <div class="field">
                <label for="harga_produk">Harga (Rp)</label>
                <input type="number" id="harga_produk" name="harga_produk" required min="0" step="1" value="<?= (int)$data['harga'] ?>">
            </div>
            <div class="field">
                <label for="gambar_produk">Foto produk</label>
                <img class="preview" id="pratinjau" src="<?= e($url ?? '') ?>" alt="Foto produk saat ini" <?= $url ? '' : 'hidden' ?>>
                <input type="file" id="gambar_produk" name="gambar_produk" accept="image/jpeg,image/png,image/webp" data-preview="pratinjau">
                <p class="hint">Kosongkan jika tidak ingin mengganti foto.</p>
            </div>
            <div class="form-actions">
                <button class="btn" type="submit" name="update">Simpan perubahan</button>
                <a class="btn btn-line" href="dashboard.php">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
