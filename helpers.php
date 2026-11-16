<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const UPLOAD_DIR = __DIR__ . '/tempat_gambar/';

// Escape output agar aman dari XSS
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function rupiah($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
function redirect($url) { header("Location: $url"); exit; }
function gambar_url($g) { return $g ? 'tempat_gambar/' . rawurlencode($g) : null; }

function flash($type, $msg) { $_SESSION['flash'] = ['type' => $type, 'msg' => $msg]; }
function get_flash() {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function is_logged_in() { return isset($_SESSION['user_id']); }
function require_login() {
    if (!is_logged_in()) {
        flash('error', 'Silakan masuk terlebih dahulu.');
        redirect('login.php');
    }
}

function csrf_field() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">';
}
function require_post($kembali) {
    $token = $_SESSION['csrf'] ?? '';
    $ok = $_SERVER['REQUEST_METHOD'] === 'POST'
        && $token !== '' // token kosong tidak boleh dianggap cocok
        && hash_equals($token, (string)($_POST['csrf'] ?? ''));
    if (!$ok) {
        flash('error', 'Permintaan tidak valid. Muat ulang halaman lalu coba lagi.');
        redirect($kembali);
    }
}

// Prepared statement singkat: q($db, "SELECT ... WHERE id = ?", 'i', [$id])
function q(mysqli $db, string $sql, string $types = '', array $params = []) {
    $st = $db->prepare($sql);
    if ($types !== '') $st->bind_param($types, ...$params);
    $st->execute();
    return $st;
}

// Upload gambar aman: cek isi file asli, batasi ukuran, nama acak.
function upload_gambar(array $file, ?string &$error): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) { $error = 'Upload gambar gagal. Coba lagi.'; return null; }
    if ($file['size'] > 2 * 1024 * 1024) { $error = 'Ukuran gambar maksimal 2 MB.'; return null; }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
    if (!$ext) { $error = 'Format gambar harus JPG, PNG, atau WebP.'; return null; }
    $nama = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $nama)) { $error = 'Gagal menyimpan gambar.'; return null; }
    return $nama;
}

// Hapus file gambar hanya jika tidak dipakai produk lain
function hapus_gambar(mysqli $db, ?string $nama) {
    if (!$nama || basename($nama) !== $nama) return;
    $dipakai = q($db, "SELECT COUNT(*) c FROM product WHERE gambar = ?", 's', [$nama])->get_result()->fetch_assoc()['c'];
    $path = UPLOAD_DIR . $nama;
    if ($dipakai == 0 && is_file($path)) unlink($path);
}
