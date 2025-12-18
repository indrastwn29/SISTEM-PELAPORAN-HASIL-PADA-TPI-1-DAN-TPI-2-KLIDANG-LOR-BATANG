<?php
require_once 'config.php';

// Cek login, redirect jika sudah login
if (isLoggedIn()) {
    if ($_SESSION['role'] == ROLE_ADMIN) {
        redirect('admin/dashboard.php');
    } else {
        redirect('petugas/dashboard.php');
    }
}
?>