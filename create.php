<?php
require 'koneksi.php';
require_login();
require_post('dashboard.php');
if (!isset($_POST['simpan'])) redirect('dashboard.php');

$nama = trim($_POST['nama_produk'] ?? '');
$deskripsi = trim($_POST['deskripsi_produk'] ?? '');
$harga = $_POST['harga_produk'] ?? '';

if ($nama === '' || !ctype_digit((string)$harga)) {
    flash('error', 'Nama produk wajib diisi dan harga harus berupa angka.');
    redirect('dashboard.php');
}

$error = null;
$gambar = upload_gambar($_FILES['gambar_produk'] ?? [], $error);
if ($error) {
    flash('error', $error);
    redirect('dashboard.php');
}

q($koneksi, "INSERT INTO product (nama, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)",
    'ssis', [$nama, $deskripsi, (int)$harga, $gambar]);

flash('success', 'Produk "' . $nama . '" berhasil ditambahkan.');
redirect('dashboard.php');
