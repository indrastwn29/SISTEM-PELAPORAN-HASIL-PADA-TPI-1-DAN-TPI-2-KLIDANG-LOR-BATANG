<?php
// test_simple.php - Test paling sederhana
echo "<h2>🧪 Test Database Connection</h2>";

// Include minimal untuk koneksi database
require_once 'app/Config/Database.php';

$config = new \Config\Database();
$dbSettings = $config->default;

echo "<pre>";
echo "1. Database Config:\n";
echo "   Database: " . $dbSettings['database'] . "\n";
echo "   Username: " . $dbSettings['username'] . "\n";
echo "   Hostname: " . $dbSettings['hostname'] . "\n";

// Coba koneksi
try {
    $db = \Config\Database::connect();
    echo "\n2. Koneksi Database: ✅ BERHASIL\n";
    
    // Cek table
    $tables = $db->listTables();
    $tableExists = in_array('karcis_bakul', $tables);
    echo "3. Table karcis_bakul: " . ($tableExists ? "✅ ADA" : "❌ TIDAK ADA") . "\n";
    
    if ($tableExists) {
        // Hitung data
        $count = $db->table('karcis_bakul')->countAll();
        echo "4. Total data sekarang: " . $count . "\n";
        
        // Test insert
        $testData = [
            'nama_bakul' => 'TEST SIMPLE ' . date('H:i:s'),
            'alamat' => 'Jl. Test Simple',
            'berat_ikan' => 7.7,
            'jumlah_karcis' => 1,
            'jumlah_pembelian' => 770000,
            'total' => 770000,
            'jumlah_bayar' => 770000,
            'status_verifikasi' => 'pending'
        ];
        
        echo "\n5. Test Insert:\n";
        try {
            $db->table('karcis_bakul')->insert($testData);
            $newId = $db->insertID();
            
            if ($newId) {
                echo "   ✅ INSERT BERHASIL! ID: " . $newId . "\n";
                
                // Cek data bertambah
                $newCount = $db->table('karcis_bakul')->countAll();
                echo "6. Total data setelah insert: " . $newCount . "\n";
                
                if ($newCount > $count) {
                    echo "\n🎉 KESIMPULAN: DATA BISA MASUK KE DATABASE!\n";
                    echo "   Masalah ada di FORM WEB / CONTROLLER, bukan database.\n";
                }
            }
        } catch (Exception $e) {
            echo "   ❌ INSERT ERROR: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "\n2. Koneksi Database: ❌ GAGAL\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "</pre>";

echo "<hr>";
echo "<h3>📋 Next Step:</h3>";
echo "<ol>";
echo "<li>Jika test ini <b>BERHASIL</b> → masalah di Controller Petugas.php</li>";
echo "<li>Jika test ini <b>GAGAL</b> → masalah di koneksi database</li>";
echo "</ol>";
?>