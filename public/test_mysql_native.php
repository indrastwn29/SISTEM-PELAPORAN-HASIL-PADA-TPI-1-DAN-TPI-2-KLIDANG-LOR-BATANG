<?php
// test_mysql_native.php - Akses via: http://localhost/lelang-ikan-tpi/public/test_mysql_native.php

echo "<h1>Test MySQL Native Connection</h1>";

// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tpi_lelang';

// Connect to MySQL
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("<div style='color: red;'>❌ Connection failed: " . mysqli_connect_error() . "</div>");
}

echo "<div style='color: green;'>✅ Connected to MySQL successfully</div>";

// Data test
$data = [
    'nama_bakul' => 'Test Native PHP',
    'alamat' => 'Alamat Test Native',
    'berat_ikan' => 77.5,
    'jumlah_karcis' => 1,
    'jumlah_pembelian' => 1500000,
    'jasa_lelang' => 75000,
    'lain_lain' => 0,
    'total' => 1575000,
    'jumlah_bayar' => 1575000
];

echo "<h3>Data yang akan disimpan:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";

// Insert data
$sql = "INSERT INTO karcis_bakul (nama_bakul, alamat, berat_ikan, jumlah_karcis, jumlah_pembelian, jasa_lelang, lain_lain, total, jumlah_bayar) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssdiddddd", 
    $data['nama_bakul'],
    $data['alamat'], 
    $data['berat_ikan'],
    $data['jumlah_karcis'],
    $data['jumlah_pembelian'],
    $data['jasa_lelang'],
    $data['lain_lain'],
    $data['total'],
    $data['jumlah_bayar']
);

if (mysqli_stmt_execute($stmt)) {
    $insertId = mysqli_insert_id($conn);
    echo "<div style='color: green; font-weight: bold;'>✅ SUCCESS! Data berhasil disimpan. ID: " . $insertId . "</div>";
    
    // Show all data
    echo "<h3>Data di table karcis_bakul:</h3>";
    $result = mysqli_query($conn, "SELECT * FROM karcis_bakul ORDER BY id_bakul DESC LIMIT 5");
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Nama Bakul</th><th>Berat</th><th>Total</th><th>Tanggal</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_bakul'] . "</td>";
        echo "<td>" . $row['nama_bakul'] . "</td>";
        echo "<td>" . $row['berat_ikan'] . " kg</td>";
        echo "<td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>";
        echo "<td>" . $row['tanggal_input'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div style='color: red; font-weight: bold;'>❌ FAILED: " . mysqli_error($conn) . "</div>";
}

mysqli_close($conn);
?>