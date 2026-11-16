<?php
require 'koneksi.php';

require_post('register.php');
if (!isset($_POST['daftar'])) redirect('register.php');

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (strlen($username) < 3 || strlen($username) > 50) {
    flash('error', 'Username harus 3 sampai 50 karakter.');
    redirect('register.php');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash('error', 'Format email tidak valid.');
    redirect('register.php');
}
if (strlen($password) < 8) {
    flash('error', 'Password minimal 8 karakter.');
    redirect('register.php');
}

$ada = q($koneksi, "SELECT id FROM users WHERE email = ?", 's', [$email])->get_result()->num_rows;
if ($ada) {
    flash('error', 'Email sudah terdaftar. Silakan masuk.');
    redirect('register.php');
}

$hash = password_hash($password, PASSWORD_DEFAULT);
q($koneksi, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)", 'sss', [$username, $email, $hash]);

flash('success', 'Pendaftaran berhasil. Silakan masuk.');
redirect('login.php');
