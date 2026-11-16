<?php
require 'helpers.php';
if (is_logged_in()) redirect('dashboard.php');

$judul = 'Masuk';
include 'partials/header.php';
?>
<div class="auth">
    <div class="panel">
        <h1>Masuk</h1>
        <p class="sub">Masuk untuk mengelola produk toko.</p>
        <form action="loginAction.php" method="post">
            <?= csrf_field() ?>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>
            <div class="field">
                <label for="kolom_password">Password</label>
                <div class="pw">
                    <input type="password" id="kolom_password" name="password" required autocomplete="current-password">
                    <button type="button" data-toggle-pw="kolom_password" aria-pressed="false">Lihat</button>
                </div>
            </div>
            <button class="btn btn-block" type="submit" name="login">Masuk</button>
        </form>
        <p class="alt">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</div>
<?php include 'partials/footer.php'; ?>
