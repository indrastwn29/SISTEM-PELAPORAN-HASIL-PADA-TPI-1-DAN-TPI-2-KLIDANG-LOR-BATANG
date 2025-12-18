<?php
// File test model setelah diperbaiki
$model = new \App\Models\KarcisBakulModel();

echo "<h2>🔄 Test Model KarcisBakul</h2>";
echo "<pre>";

// TEST 1: Koneksi Database
echo "=== TEST 1: KONEKSI DATABASE ===\n";
echo $model->testConnection() . "\n\n";

// TEST 2: Struktur Table
echo "=== TEST 2: STRUKTUR TABLE ===\n";
$structure = $model->getTableStructure();
foreach ($structure as $field) {
    echo "• " . $field . "\n";
}
echo "\n";

// TEST 3: Data Sekarang
echo "=== TEST 3: DATA SAAT INI ===\n";
$currentCount = $model->countAll();
echo "Jumlah data di database: " . $currentCount . "\n\n";

// TEST 4: Test Insert Data
echo "=== TEST 4: TEST INSERT DATA ===\n";
$testData = [
    'nama_bakul' => 'TEST FIX ' . date('H:i:s'),
    'alamat' => 'Jl. Test Fix Model',
    'berat_ikan' => 10.5,
    'jumlah_karcis' => 2,
    'jumlah_pembelian' => 1050000,
    'jasa_lelang' => 52500,
    'lain_lain' => 20000,
    'total' => 1122500,
    'jumlah_bayar' => 1122500,
    'status_verifikasi' => 'pending'
];

echo "Data yang akan diinsert:\n";
print_r($testData);
echo "\n";

// Validasi data
$errors = $model->validateInsertData($testData);
if (empty($errors)) {
    echo "✅ Validasi data: LULUS\n";
    
    try {
        // Insert data
        $insertId = $model->insert($testData);
        
        if ($insertId) {
            echo "✅ Insert BERHASIL! ID: " . $insertId . "\n";
            
            // Cek data setelah insert
            $newCount = $model->countAll();
            echo "✅ Jumlah data setelah insert: " . $newCount . "\n";
            
            if ($newCount > $currentCount) {
                echo "✅✅ DATA BERHASIL MASUK KE DATABASE!\n";
                
                // Tampilkan data yang baru diinsert
                $newData = $model->find($insertId);
                echo "\nData yang baru diinsert:\n";
                print_r($newData);
            } else {
                echo "❌ DATA TIDAK BERTAMBAH di database!\n";
            }
        } else {
            echo "❌ Insert GAGAL - Tidak dapat ID\n";
        }
        
    } catch (Exception $e) {
        echo "❌ ERROR saat insert: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Validasi data GAGAL:\n";
    foreach ($errors as $error) {
        echo "  - " . $error . "\n";
    }
}

echo "\n=== TEST 5: CEK SEMUA DATA ===\n";
$allData = $model->findAll();
echo "Total data ditemukan: " . count($allData) . "\n";

if (!empty($allData)) {
    echo "\n3 Data terbaru:\n";
    $recentData = array_slice($allData, 0, 3);
    foreach ($recentData as $data) {
        echo "• ID: #" . $data['id_bakul'] . " | " . $data['nama_bakul'] . 
             " | Rp " . number_format($data['total'], 0, ',', '.') . 
             " | " . $data['tanggal_input'] . "\n";
    }
}

echo "</pre>";

// Link untuk test lain
echo '<hr>';
echo '<h3>🔗 Link Test Lain:</h3>';
echo '<ul>';
echo '<li><a href="' . site_url('/petugas/input-bakul') . '" target="_blank">➡️ Test Input via Form Web</a></li>';
echo '<li><a href="' . site_url('/petugas/daftar-karcis-bakul') . '" target="_blank">➡️ Lihat Daftar Karcis Bakul</a></li>';
echo '<li><a href="' . site_url('/petugas') . '" target="_blank">➡️ Cek Dashboard</a></li>';
echo '</ul>';
?>