<?php
// Koneksi database. Jangan ada echo/output di file ini,
// karena output sebelum header() membuat redirect gagal.
mysqli_report(MYSQLI_REPORT_OFF);
$koneksi = @mysqli_connect("localhost", "root", "", "toko_db");

if (!$koneksi) {
    http_response_code(500);
    exit("Koneksi database gagal. Pastikan MySQL berjalan dan database toko_db sudah diimport dari toko_db.sql.");
}
mysqli_set_charset($koneksi, "utf8mb4");

require_once __DIR__ . '/helpers.php';
