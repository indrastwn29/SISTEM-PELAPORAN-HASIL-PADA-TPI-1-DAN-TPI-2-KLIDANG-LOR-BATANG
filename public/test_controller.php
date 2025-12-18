<?php
// test_controller.php - Test controller dari public folder
echo "<h1>🧪 TEST CONTROLLER & MODEL</h1>";
echo "<style>
    body { font-family: Arial; padding: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .box { background: #f8f9fa; padding: 15px; margin: 10px 0; border: 1px solid #ddd; }
</style>";

// Load framework manual
define('APPPATH', dirname(__DIR__) . '/app/');
define('ROOTPATH', dirname(__DIR__) . '/');

// Load essentials
require_once ROOTPATH . 'vendor/autoload.php';
require_once APPPATH . 'Config/Paths.php';
require_once SYSTEMPATH . 'bootstrap.php';

echo "<div class='box'>";
echo "<h3>1. 🔧 Load CodeIgniter Framework</h3>";

try {
    // Load services
    $config = new \Config\Database();
    $db = \Config\Database::connect();
    
    echo "<p class='success'>✅ Database service loaded</p>";
    
    // Test Model
    if (file_exists(APPPATH . 'Models/KarcisBakulModel.php')) {
        require_once APPPATH . 'Models/KarcisBakulModel.php';
        
        $model = new \App\Models\KarcisBakulModel();
        echo "<p class='success'>✅ Model KarcisBakul loaded</p>";
        
        // Test count
        $count = $model->countAll();
        echo "<p>Total data via Model: <strong>$count</strong></p>";
        
        // Test insert via Model
        echo "<h3>2. 🧪 Test Insert via Model</h3>";
        
        $testData = [
            'nama_bakul' => 'MODEL TEST ' . date('H:i:s'),
            'alamat' => 'Jl. Model Test',
            'berat_ikan' => 8.8,
            'jumlah_karcis' => 1,
            'jumlah_pembelian' => 880000,
            'jasa_lelang' => 44000,
            'lain_lain' => 10000,
            'total' => 934000,
            'jumlah_bayar' => 934000,
            'status_verifikasi' => 'pending'
            // TIDAK ada: petugas_id, tanggal_input
        ];
        
        echo "<pre>Data untuk insert:\n";
        print_r($testData);
        echo "</pre>";
        
        try {
            $insertId = $model->insert($testData);
            
            if ($insertId) {
                echo "<p class='success'>✅ Model INSERT BERHASIL! ID: $insertId</p>";
                
                // Verify
                $newCount = $model->countAll();
                echo "<p>Data setelah insert: <strong>$newCount</strong></p>";
                
                if ($newCount > $count) {
                    echo "<p class='success'>🎉 DATA BERHASIL via MODEL!</p>";
                }
            } else {
                echo "<p class='error'>❌ Model INSERT GAGAL - no ID returned</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Model INSERT ERROR: " . $e->getMessage() . "</p>";
            echo "<pre>Error trace:\n" . $e->getTraceAsString() . "</pre>";
        }
        
    } else {
        echo "<p class='error'>❌ Model file not found</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Framework error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Quick diagnosis
echo "<div class='box' style='background: #e8f4fd;'>";
echo "<h3>🎯 DIAGNOSIS</h3>";
echo "<p><strong>Status saat ini:</strong></p>";
echo "<ol>
        <li>Database: ✅ OK</li>
        <li>Table structure: ✅ OK (no petugas_id)</li>
        <li>Direct SQL insert: ✅ OK (ID: 35)</li>
        <li>Model insert: ❌ MASIH PERLU TEST</li>
        <li>Controller form: ❌ BELUM TEST</li>
      </ol>";
      
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>
        <li>Pastikan Model sudah diperbaiki (tidak ada petugas_id)</li>
        <li>Pastikan Controller sudah diperbaiki</li>
        <li>Clear cache</li>
        <li>Test via form web</li>
      </ol>";
echo "</div>";

// Links
echo "<hr>";
echo "<h3>🔗 Action Required:</h3>";
echo "<ul>
        <li>➡️ <a href='http://localhost/lelang-ikan-tpi/public/test_fix.php' target='_blank'>Test Database Again</a></li>
        <li>➡️ <a href='http://localhost/lelang-ikan-tpi/login' target='_blank'>Login ke Sistem</a></li>
        <li>➡️ <a href='http://localhost/lelang-ikan-tpi/petugas/input-bakul' target='_blank'>Test Form Input</a></li>
      </ul>";
?>