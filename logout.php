<?php
require 'helpers.php';

$_SESSION = [];
session_destroy();
session_start();
flash('success', 'Anda sudah keluar.');
redirect('login.php');
