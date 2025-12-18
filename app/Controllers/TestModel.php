<?php
namespace App\Controllers;

use App\Models\KarcisBakulModel;

class TestModel extends \CodeIgniter\Controller
{
    public function __construct()
    {
        // Tidak panggil parent constructor agar tidak cek auth
        helper('url');
    }
    
    public function index()
    {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>🔄 Test Model - Tanpa Login</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .success { color: green; font-weight: bold; }
                .error { color: red; font-weight: bold; }
                .box { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0; }
                pre { background: white; padding: 10px; border: 1px solid #ddd; }
            </style>
        </head>
        <body>";
        
        echo "<h1>🔄 TEST MODEL KARCIS BAKUL (TANPA LOGIN)</h1>";
        echo "<p><a href='" . site_url('/login') . "'>🔑 Login ke Sistem</a></p>";
        
        $model = new KarcisBakulModel();
        
        // TEST 1: Koneksi Database
        echo "<div class='box'>";
        echo "<h3>1. 🔗 Test Koneksi Database</h3>";
        try {
            $result = $model->testConnection();
            echo "<p class='success'>" . $result . "</p>";
        } catch (\Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        echo "</div>";
        
        // TEST 2: Struktur Tabel
        echo "<div class='box'>";
        echo "<h3>2. 📊 Struktur Tabel karcis_bakul</h3>";
        try {
            $structure = $model->getTableStructure();
            echo "<pre>";
            foreach ($structure as $field) {
                echo $field . "\n";
            }
            echo "</pre>";
        } catch (\Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        echo "</div>";
        
        // TEST 3: Count Data
        echo "<div class='box'>";
        echo "<h3>3. 📈 Data Saat Ini</h3>";
        try {
            $count = $model->countAll();
            echo "<p>Total data di database: <strong>" . $count . "</strong></p>";
            
            if ($count > 0) {
                $latest = $model->orderBy('id_bakul', 'DESC')->first();
                echo "<p>Data terbaru: <strong>" . ($latest['nama_bakul'] ?? 'N/A') . "</strong></p>";
                echo "<p>ID: " . ($latest['id_bakul'] ?? 'N/A') . " | Tanggal: " . ($latest['tanggal_input'] ?? 'N/A') . "</p>";
            }
        } catch (\Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        echo "</div>";
        
        // TEST 4: Test Insert
        echo "<div class='box'>";
        echo "<h3>4. 🧪 Test Insert Data</h3>";
        
        $testData = [
            'nama_bakul' => 'TEST MODEL ' . date('H:i:s'),
            'alamat' => 'Jl. Test Model',
            'berat_ikan' => 6.6,
            'jumlah_karcis' => 1,
            'jumlah_pembelian' => 660000,
            'jasa_lelang' => 33000,
            'lain_lain' => 12000,
            'total' => 705000,
            'jumlah_bayar' => 705000,
            'status_verifikasi' => 'pending'
        ];
        
        echo "<pre>Data yang akan diinsert:\n";
        print_r($testData);
        echo "</pre>";
        
        try {
            $insertId = $model->insert($testData);
            
            if ($insertId) {
                echo "<p class='success'>✅ INSERT BERHASIL! ID: " . $insertId . "</p>";
                
                // Verifikasi
                $newCount = $model->countAll();
                echo "<p>Total data setelah insert: <strong>" . $newCount . "</strong></p>";
                
                if ($newCount > $count) {
                    echo "<p class='success'>🎉 DATA BERHASIL MASUK KE DATABASE!</p>";
                    
                    // Tampilkan data yang baru diinsert
                    $newData = $model->find($insertId);
                    echo "<pre>Data yang baru diinsert:\n";
                    print_r($newData);
                    echo "</pre>";
                }
            } else {
                echo "<p class='error'>❌ INSERT GAGAL - Tidak dapat ID</p>";
            }
        } catch (\Exception $e) {
            echo "<p class='error'>❌ ERROR INSERT: " . $e->getMessage() . "</p>";
        }
        echo "</div>";
        
        // LINK KE SISTEM
        echo "<hr>";
        echo "<h3>🔗 Link ke Sistem:</h3>";
        echo "<ul>";
        echo "<li><a href='" . site_url('/login') . "' target='_blank'>🔑 Login ke Sistem</a></li>";
        echo "<li><a href='" . site_url('/petugas/input-bakul') . "' target='_blank'>📝 Form Input Bakul</a></li>";
        echo "<li><a href='http://localhost/phpmyadmin' target='_blank'>🗄️ phpMyAdmin</a></li>";
        echo "</ul>";
        
        echo "</body></html>";
    }
}