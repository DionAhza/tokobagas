<?php
require 'koneksi.php';
require_login();
require_post('dashboard.php'); // hapus hanya lewat POST + token CSRF, bukan link biasa

$id = (int)($_POST['id'] ?? 0);
$data = q($koneksi, "SELECT nama, gambar FROM product WHERE id = ?", 'i', [$id])->get_result()->fetch_assoc();

if ($data) {
    q($koneksi, "DELETE FROM product WHERE id = ?", 'i', [$id]);
    hapus_gambar($koneksi, $data['gambar']);
    flash('success', 'Produk "' . $data['nama'] . '" dihapus.');
} else {
    flash('error', 'Produk tidak ditemukan.');
}
redirect('dashboard.php');
