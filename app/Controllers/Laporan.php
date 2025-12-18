<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Laporan extends BaseController
{
    protected $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // Get filter parameters
        $periode = $this->request->getGet('periode') ?? 'harian';
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-d');
        
        // Adjust dates based on period
        switch ($periode) {
            case 'bulanan':
                $start_date = date('Y-m-01');
                $end_date = date('Y-m-t');
                break;
            case 'tahunan':
                $start_date = date('Y-01-01');
                $end_date = date('Y-12-31');
                break;
        }
        
        // Get data langsung dari database
        $karcis_bakul = [];
        $karcis_pemilik = [];
        
        // ==================== CARI DATA BAKUL ====================
        $bakulTables = ['karcis_bakul', 'bakul', 'pedagang', 'transaksi_bakul', 'transaksi'];
        
        foreach ($bakulTables as $table) {
            if ($this->db->tableExists($table)) {
                $builder = $this->db->table($table);
                
                // Cek kolom tanggal yang ada di tabel
                $columns = $this->db->getFieldNames($table);
                $dateColumn = null;
                
                // Cari kolom yang kemungkinan berisi tanggal
                $possibleDateColumns = ['tanggal', 'created_at', 'tgl', 'date', 'tanggal_input', 'tanggal_transaksi'];
                foreach ($possibleDateColumns as $col) {
                    if (in_array($col, $columns)) {
                        $dateColumn = $col;
                        break;
                    }
                }
                
                if ($dateColumn) {
                    // Gunakan kolom tanggal yang ditemukan
                    $builder->where("DATE($dateColumn) >=", $start_date);
                    $builder->where("DATE($dateColumn) <=", $end_date);
                }
                
                $karcis_bakul = $builder->get()->getResultArray();
                
                if (!empty($karcis_bakul)) {
                    break; // Stop jika data ditemukan
                }
            }
        }
        
        // ==================== CARI DATA KAPAL ====================
        $kapalTables = ['karcis_pemilik', 'karcis_kapal', 'pemilik_kapal', 'nelayan', 'kapal', 'pemilik'];
        
        foreach ($kapalTables as $table) {
            if ($this->db->tableExists($table)) {
                $builder = $this->db->table($table);
                
                // Cek kolom tanggal yang ada di tabel
                $columns = $this->db->getFieldNames($table);
                $dateColumn = null;
                
                // Cari kolom yang kemungkinan berisi tanggal
                $possibleDateColumns = ['tanggal', 'created_at', 'tgl', 'date', 'tanggal_datang', 'tanggal_input'];
                foreach ($possibleDateColumns as $col) {
                    if (in_array($col, $columns)) {
                        $dateColumn = $col;
                        break;
                    }
                }
                
                if ($dateColumn) {
                    // Gunakan kolom tanggal yang ditemukan
                    $builder->where("DATE($dateColumn) >=", $start_date);
                    $builder->where("DATE($dateColumn) <=", $end_date);
                }
                
                $karcis_pemilik = $builder->get()->getResultArray();
                
                if (!empty($karcis_pemilik)) {
                    break; // Stop jika data ditemukan
                }
            }
        }
        
        // Jika data kosong, gunakan data dummy untuk development
        if (empty($karcis_bakul)) {
            $karcis_bakul = $this->getDummyBakulData();
        }
        
        if (empty($karcis_pemilik)) {
            $karcis_pemilik = $this->getDummyKapalData();
        }
        
        // Calculate statistics
        $total_bakul = count($karcis_bakul);
        $total_kapal = count($karcis_pemilik);
        
        $total_berat_bakul = 0;
        $total_pembelian = 0;
        foreach ($karcis_bakul as $kb) {
            $total_berat_bakul += $kb['berat_ikan'] ?? $kb['berat'] ?? $kb['berat_total'] ?? $kb['jumlah'] ?? 0;
            $total_pembelian += $kb['total_harga'] ?? $kb['total'] ?? $kb['total_nilai'] ?? $kb['harga'] ?? $kb['jumlah_harga'] ?? 0;
        }
        
        $total_berat_pemilik = 0;
        $total_penjualan = 0;
        foreach ($karcis_pemilik as $kp) {
            $total_berat_pemilik += $kp['berat_ikan'] ?? $kp['berat'] ?? $kp['berat_total'] ?? $kp['jumlah'] ?? 0;
            $total_penjualan += $kp['total_harga'] ?? $kp['total'] ?? $kp['total_nilai'] ?? $kp['harga'] ?? $kp['jumlah_harga'] ?? 0;
        }
        
        // Prepare data for view
        $data = [
            'title' => 'Laporan & Statistik',
            'nama_lengkap' => session()->get('nama_lengkap') ?? 'Administrator',
            'periode' => $periode,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'karcis_bakul' => $karcis_bakul,
            'karcis_pemilik' => $karcis_pemilik,
            'total_bakul' => $total_bakul,
            'total_kapal' => $total_kapal,
            'total_berat_bakul' => $total_berat_bakul,
            'total_berat_pemilik' => $total_berat_pemilik,
            'total_pembelian' => $total_pembelian,
            'total_penjualan' => $total_penjualan
        ];
        
        return view('laporan/index', $data);
    }
    
    public function statistik()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        $data = [
            'title' => 'Statistik Lelang Ikan',
            'nama_lengkap' => session()->get('nama_lengkap') ?? 'Administrator'
        ];
        
        return view('laporan/statistik', $data);
    }
    
    /**
     * Helper function untuk debug - lihat struktur tabel database
     */
    public function debugTables()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        $tables = $this->db->listTables();
        
        echo "<h1>Database Tables</h1>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li><strong>$table</strong></li>";
            
            $fields = $this->db->getFieldNames($table);
            echo "<ul>";
            foreach ($fields as $field) {
                echo "<li>$field</li>";
            }
            echo "</ul>";
        }
        echo "</ul>";
        
        // Jangan tampilkan view lain
        exit;
    }
    
    private function getDummyBakulData()
    {
        return [
            [
                'id' => 1,
                'nomor_karcis' => 'KB-001',
                'nama_bakul' => 'Toko Ikan Segar',
                'nama_pedagang' => 'Budi Santoso',
                'jenis_ikan' => 'Tongkol',
                'berat_ikan' => 45.5,
                'harga_per_kg' => 38000,
                'total_harga' => 1729000,
                'status' => 'diverifikasi',
                'tanggal' => date('Y-m-d', strtotime('-3 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 2,
                'nomor_karcis' => 'KB-002',
                'nama_bakul' => 'Warung Ikan Makmur',
                'nama_pedagang' => 'Siti Rahayu',
                'jenis_ikan' => 'Cakalang',
                'berat_ikan' => 32.75,
                'harga_per_kg' => 45000,
                'total_harga' => 1473750,
                'status' => 'diverifikasi',
                'tanggal' => date('Y-m-d', strtotime('-2 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'id' => 3,
                'nomor_karcis' => 'KB-003',
                'nama_bakul' => 'Kios Ikan Jaya',
                'nama_pedagang' => 'Rudi Hermawan',
                'jenis_ikan' => 'Tuna',
                'berat_ikan' => 25.25,
                'harga_per_kg' => 68000,
                'total_harga' => 1717000,
                'status' => 'menunggu',
                'tanggal' => date('Y-m-d', strtotime('-1 day')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'id' => 4,
                'nomor_karcis' => 'KB-004',
                'nama_bakul' => 'Toko Laut Selatan',
                'nama_pedagang' => 'Ahmad Fauzi',
                'jenis_ikan' => 'Tenggiri',
                'berat_ikan' => 18.5,
                'harga_per_kg' => 55000,
                'total_harga' => 1017500,
                'status' => 'diverifikasi',
                'tanggal' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
    }
    
    private function getDummyKapalData()
    {
        return [
            [
                'id' => 1,
                'nomor_karcis' => 'KP-001',
                'nama_nelayan' => 'Ahmad Santoso',
                'nama_kapal' => 'KM Sumber Rejeki',
                'jenis_ikan' => 'Tongkol',
                'berat_ikan' => 125.5,
                'daerah_tangkapan' => 'Laut Jawa',
                'harga_per_kg' => 35000,
                'total_harga' => 4392500,
                'status' => 'diverifikasi',
                'tanggal_datang' => date('Y-m-d', strtotime('-2 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'id' => 2,
                'nomor_karcis' => 'KP-002',
                'nama_nelayan' => 'Budi Hartono',
                'nama_kapal' => 'KM Jaya Abadi',
                'jenis_ikan' => 'Cakalang',
                'berat_ikan' => 85.75,
                'daerah_tangkapan' => 'Selat Sunda',
                'harga_per_kg' => 42000,
                'total_harga' => 3601500,
                'status' => 'menunggu',
                'tanggal_datang' => date('Y-m-d', strtotime('-1 day')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'id' => 3,
                'nomor_karcis' => 'KP-003',
                'nama_nelayan' => 'Rudi Hermawan',
                'nama_kapal' => 'KM Sejahtera',
                'jenis_ikan' => 'Tuna',
                'berat_ikan' => 210.25,
                'daerah_tangkapan' => 'Samudera Hindia',
                'harga_per_kg' => 65000,
                'total_harga' => 13666250,
                'status' => 'diverifikasi',
                'tanggal_datang' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
    }
    
    /**
     * Export data to Excel
     */
    public function exportExcel()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // Get filter parameters
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-d');
        
        // Get data (gunakan data dummy untuk sekarang)
        $karcis_bakul = $this->getDummyBakulData();
        $karcis_pemilik = $this->getDummyKapalData();
        
        // Simple CSV export sebagai placeholder
        $filename = "laporan_{$start_date}_to_{$end_date}.csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Header for bakul
        fputcsv($output, ['LAPORAN KARCIS BAKUL']);
        fputcsv($output, ['Periode: ' . $start_date . ' sampai ' . $end_date]);
        fputcsv($output, []); // Empty line
        
        fputcsv($output, ['No', 'Nomor Karcis', 'Nama Bakul', 'Jenis Ikan', 'Berat (kg)', 'Harga/Kg', 'Total', 'Status', 'Tanggal']);
        
        $no = 1;
        $total_berat_bakul = 0;
        $total_pembelian = 0;
        
        foreach ($karcis_bakul as $row) {
            fputcsv($output, [
                $no++,
                $row['nomor_karcis'],
                $row['nama_bakul'],
                $row['jenis_ikan'],
                $row['berat_ikan'],
                $row['harga_per_kg'],
                $row['total_harga'],
                $row['status'],
                $row['tanggal'] ?? $row['created_at'] ?? ''
            ]);
            
            $total_berat_bakul += $row['berat_ikan'];
            $total_pembelian += $row['total_harga'];
        }
        
        // Total row for bakul
        fputcsv($output, ['TOTAL', '', '', '', $total_berat_bakul, '', $total_pembelian, '', '']);
        fputcsv($output, []); // Empty line
        
        // Header for kapal
        fputcsv($output, ['LAPORAN KARCIS KAPAL']);
        fputcsv($output, []); // Empty line
        
        fputcsv($output, ['No', 'Nomor Karcis', 'Nama Nelayan/Kapal', 'Jenis Ikan', 'Berat (kg)', 'Daerah Tangkapan', 'Harga/Kg', 'Total', 'Status', 'Tanggal Datang']);
        
        $no = 1;
        $total_berat_kapal = 0;
        $total_penjualan = 0;
        
        foreach ($karcis_pemilik as $row) {
            fputcsv($output, [
                $no++,
                $row['nomor_karcis'],
                $row['nama_nelayan'] . ' / ' . $row['nama_kapal'],
                $row['jenis_ikan'],
                $row['berat_ikan'],
                $row['daerah_tangkapan'],
                $row['harga_per_kg'],
                $row['total_harga'],
                $row['status'],
                $row['tanggal_datang'] ?? $row['created_at'] ?? ''
            ]);
            
            $total_berat_kapal += $row['berat_ikan'];
            $total_penjualan += $row['total_harga'];
        }
        
        // Total row for kapal
        fputcsv($output, ['TOTAL', '', '', '', $total_berat_kapal, '', '', $total_penjualan, '', '']);
        fputcsv($output, []); // Empty line
        
        // Summary
        fputcsv($output, ['RINGKASAN']);
        fputcsv($output, ['Total Bakul', count($karcis_bakul)]);
        fputcsv($output, ['Total Kapal', count($karcis_pemilik)]);
        fputcsv($output, ['Total Berat (kg)', $total_berat_bakul + $total_berat_kapal]);
        fputcsv($output, ['Total Nilai Transaksi (Rp)', $total_pembelian + $total_penjualan]);
        
        fclose($output);
        exit;
    }
}