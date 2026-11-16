<?php
require 'koneksi.php';

require_post('login.php');
if (!isset($_POST['login'])) redirect('login.php');

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$user = q($koneksi, "SELECT id, username, password FROM users WHERE email = ?", 's', [$email])
    ->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true); // cegah session fixation
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama_akun'] = $user['username'];
    redirect('dashboard.php');
}

flash('error', 'Email atau password salah.');
redirect('login.php');
