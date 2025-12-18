<?php
// test_input_simple.php - Akses via: http://localhost/lelang-ikan-tpi/public/test_input_simple.php

// Include database config
require_once '../app/Config/Database.php';

$config = new \Config\Database();
$db = \Config\Database::connect();

echo "<h1>Test Input Karcis Bakul - SIMPLE VERSION</h1>";

// Data test
$data = [
    'nama_bakul' => 'Test dari Simple',
    'alamat' => 'Alamat Test Simple',
    'berat_ikan' => 88.5,
    'jumlah_karcis' => 2,
    'jumlah_pembelian' => 2200000,
    'jasa_lelang' => 110000,
    'lain_lain' => 0,
    'total' => 2310000,
    'jumlah_bayar' => 2310000
];

echo "<h3>Data yang akan disimpan:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";

// Try insert
$result = $db->table('karcis_bakul')->insert($data);

if ($result) {
    $insertId = $db->insertID();
    echo "<div style='color: green; font-weight: bold;'>✅ SUCCESS! Data berhasil disimpan. ID: " . $insertId . "</div>";
    
    // Show all data in table
    echo "<h3>Data di table karcis_bakul:</h3>";
    $allData = $db->table('karcis_bakul')->get()->getResultArray();
    echo "<pre>";
    print_r($allData);
    echo "</pre>";
} else {
    $error = $db->error();
    echo "<div style='color: red; font-weight: bold;'>❌ FAILED: " . print_r($error, true) . "</div>";
}