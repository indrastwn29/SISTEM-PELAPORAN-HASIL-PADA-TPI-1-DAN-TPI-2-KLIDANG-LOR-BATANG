<?php
// config.php - File konfigurasi sistem karcis TPI
session_start();

// ==================== KONEKSI DATABASE ====================
$host = "localhost";      // Server database
$username = "root";       // Username database (biasanya root)
$password = "";           // Password database (kosongkan jika tidak ada)
$database = "sistem_karcis_tpi"; // Nama database yang sudah dibuat

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek jika koneksi gagal
if (!$conn) {
    die("❌ KONEKSI DATABASE GAGAL: " . mysqli_connect_error());
}

// ==================== CONSTANT UNTUK STATUS ====================
define('STATUS_PENDING', 'pending');
define('STATUS_APPROVED', 'approved');
define('STATUS_REJECTED', 'rejected');

// ==================== CONSTANT UNTUK TIPE KARCIS ====================
define('KARCIS_BAKUL', 'bakul');
define('KARCIS_PEMILIK_KAPAL', 'pemilik_kapal');

// ==================== CONSTANT UNTUK ROLE USER ====================
define('ROLE_PETUGAS', 'petugas');
define('ROLE_ADMIN', 'admin');

// ==================== SETTING TIMEZONE ====================
date_default_timezone_set('Asia/Jakarta');

// ==================== FUNGSI UMUM ====================
function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] == $role;
}

echo "✅ Config.php loaded successfully!";
?>