<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===== BASIC CONFIGURATION =====
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ===== AUTHENTICATION ROUTES =====
// Redirect root ke login
$routes->get('/', function() {
    return redirect()->to('/login');
});

// Login routes
$routes->get('/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');

// Tambahan route auth
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth/test-login/(:any)', 'Auth::testLogin/$1');
$routes->get('/auth/test-login', 'Auth::testLogin');

// ===== PETUGAS ROUTES DENGAN FILTER =====
$routes->group('petugas', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('/', 'Petugas::index');
    $routes->get('dashboard', 'Petugas::index');
    
    // Input Karcis
    $routes->get('input-bakul', 'Petugas::inputBakul');
    $routes->post('save-bakul', 'Petugas::saveBakul');
    $routes->get('input-kapal', 'Petugas::inputKapal');
    $routes->post('save-kapal', 'Petugas::saveKapal');
    
    // Data Karcis (MENU TERPISAH - BARU)
    $routes->get('daftar-karcis-bakul', 'Petugas::daftarKarcisBakul');
    $routes->get('daftar-karcis-pemilik-kapal', 'Petugas::daftarKarcisPemilikKapal');
    
    // Edit Karcis
    $routes->get('edit-bakul/(:num)', 'Petugas::editBakul/$1');
    $routes->post('update-bakul/(:num)', 'Petugas::updateBakul/$1');
    $routes->get('edit-kapal/(:num)', 'Petugas::editKapal/$1');
    $routes->post('update-kapal/(:num)', 'Petugas::updateKapal/$1');
    
    // Delete Karcis
    $routes->get('delete-bakul/(:num)', 'Petugas::deleteBakul/$1');
    $routes->get('delete-kapal/(:num)', 'Petugas::deleteKapal/$1');
    
    // History Input
    $routes->get('history', 'Petugas::history');
    
    // Verifikasi
    $routes->get('verifikasi', 'Petugas::verifikasi');
    $routes->get('proses-verifikasi/(:num)', 'Petugas::prosesVerifikasi/$1');
    
    // Success pages
    $routes->get('input-sukses', 'Petugas::inputSukses');
    $routes->get('input-sukses-kapal', 'Petugas::inputSuksesKapal');
    
    // Profile & Settings
    $routes->get('profile', 'Petugas::profile');
    $routes->get('settings', 'Petugas::settings');
    $routes->get('pengaturan', 'Petugas::settings');
    $routes->get('statistik', 'Petugas::statistik');
    
    // Legacy routes redirect
    $routes->get('input-karcis-bakul', 'Petugas::inputBakul');
    $routes->get('input-karcis-pemilik-kapal', 'Petugas::inputKapal');
    
    // Test routes
    $routes->get('test-input-bakul', 'Petugas::testInputBakul');
    $routes->get('test-manual-insert', 'Petugas::testManualInsert');
});

// ===== ADMIN ROUTES DENGAN FILTER =====
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('/', 'Admin::index');
    $routes->get('dashboard', 'Admin::index');
    
    // Input Karcis
    $routes->get('input-karcis-bakul', 'Admin::inputKarcisBakul');
    $routes->post('simpan-karcis-bakul', 'Admin::simpanKarcisBakul');
    $routes->get('input-karcis-kapal', 'Admin::inputKarcisKapal');
    $routes->post('simpan-karcis-kapal', 'Admin::simpanKarcisKapal');
    
    // VERIFIKASI KARCIS - ROUTE YANG TAMBAHKAN
    $routes->get('verifikasi-karcis-bakul', 'Admin::verifikasiKarcisBakul');
    $routes->get('verifikasi-karcis-kapal', 'Admin::verifikasiKarcisKapal');
    
    // UPDATE STATUS VERIFIKASI
    $routes->post('update-status-bakul', 'Admin::updateStatusBakul');
    $routes->post('update-status-kapal', 'Admin::updateStatusKapal');
    
    // DATA TERVERIFIKASI
    $routes->get('data-terverifikasi-bakul', 'Admin::dataTerverifikasiBakul');
    $routes->get('data-terverifikasi-kapal', 'Admin::dataTerverifikasiKapal');
    
    // DEBUG & SYSTEM
    $routes->get('debugDatabase', 'Admin::debugDatabase');
    $routes->get('clear-cache', 'Admin::clearCache');
    
    // PENGATURAN
    $routes->get('pengaturan', 'Admin::index');
});

// ===== LAPORAN ROUTES (GLOBAL) =====
$routes->group('laporan', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Laporan::index');
    $routes->get('detail/(:num)', 'Laporan::detail/$1');
    $routes->get('export', 'Laporan::exportExcel');
});

// ===== PUBLIC TEST ROUTES (TANPA FILTER) =====
$routes->get('/test-session', function() {
    return "Session: " . print_r(session()->get(), true);
});

$routes->get('/test-login', function() {
    if (!session()->get('logged_in')) {
        return "NOT LOGGED IN";
    }
    return "Logged in as: " . session()->get('nama_lengkap') . " (Role: " . session()->get('role') . ")";
});

$routes->get('/test-dashboard', function() {
    if (!session()->get('logged_in')) {
        return "NOT LOGGED IN";
    }
    return "TEST: Dashboard accessible! User: " . session()->get('nama_lengkap');
});

// ===== DEBUG ROUTES =====
$routes->get('/debug-session', function() {
    echo "<pre>";
    print_r(session()->get());
    echo "</pre>";
});

$routes->get('/debug-database', function() {
    $db = \Config\Database::connect();
    echo "<h3>Database Tables:</h3>";
    $tables = $db->listTables();
    echo "<pre>";
    print_r($tables);
    echo "</pre>";
});

// ===== SIMPLE TEST CONTROLLER =====
$routes->get('/simple-test', function() {
    return view('simple_test');
});

// ===== FALLBACK ROUTE =====
$routes->get('(:any)', function() {
    if (session()->get('logged_in')) {
        $role = session()->get('role');
        if ($role === 'admin' || $role === 'superadmin') {
            return redirect()->to('/admin');
        } elseif ($role === 'petugas') {
            return redirect()->to('/petugas');
        }
    }
    return redirect()->to('/login');
});