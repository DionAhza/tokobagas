<?php
require 'helpers.php';
if (is_logged_in()) redirect('dashboard.php');

$judul = 'Daftar';
include 'partials/header.php';
?>
<div class="auth">
    <div class="panel">
        <h1>Buat akun</h1>
        <p class="sub">Daftar untuk mulai mengelola produk.</p>
        <form action="registerAction.php" method="post">
            <?= csrf_field() ?>
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="50" autocomplete="username">
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>
            <div class="field">
                <label for="kolom_password">Password</label>
                <div class="pw">
                    <input type="password" id="kolom_password" name="password" required minlength="8" autocomplete="new-password">
                    <button type="button" data-toggle-pw="kolom_password" aria-pressed="false">Lihat</button>
                </div>
                <p class="hint">Minimal 8 karakter.</p>
            </div>
            <button class="btn btn-block" type="submit" name="daftar">Daftar</button>
        </form>
        <p class="alt">Sudah punya akun? <a href="login.php">Masuk</a></p>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
