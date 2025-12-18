<?php

namespace App\Controllers;

use App\Models\KarcisBakulModel;
use App\Models\KarcisPemilikKapalModel;

class Petugas extends BaseController
{
    protected $karcisBakulModel;
    protected $karcisKapalModel;
    
    public function __construct()
    {
        $this->karcisBakulModel = new KarcisBakulModel();
        $this->karcisKapalModel = new KarcisPemilikKapalModel();
        helper(['form', 'url', 'session', 'number']);
    }

    public function index()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // Cek role
        if (session()->get('role') !== 'petugas') {
            return redirect()->to('/login')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
        
        $petugas_id = session()->get('user_id');
        
        // ==================== AMBIL DATA DARI DATABASE ====================
        try {
            // KARCIS BAKUL - TIDAK BISA FILTER BY PETUGAS_ID (field tidak ada)
            $total_bakul_harian = $this->karcisBakulModel->getTotalHariIni();
            $pendapatan_bakul_harian = $this->karcisBakulModel->getTotalPendapatanHariIni();
            
            // KARCIS KAPAL - MASIH BISA FILTER (ada field petugas_id)
            $total_kapal_harian = $this->karcisKapalModel->getTotalHariIni($petugas_id);
            $pendapatan_kapal_harian = $this->karcisKapalModel->getTotalPendapatanHariIni($petugas_id);
            
            // Data menunggu verifikasi (hanya untuk kapal)
            $menungguVerifikasi = $this->karcisKapalModel->where('status_verifikasi', 'pending')
                                                          ->where('petugas_id', $petugas_id)
                                                          ->countAllResults();
            
            // Total semua data
            $total_semua_bakul = $this->karcisBakulModel->countAllResults();
            $total_semua_kapal = $this->karcisKapalModel->where('petugas_id', $petugas_id)->countAllResults();
            
            // Data untuk chart
            $chartData = [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                'bakul' => [5, 8, 12,15, 18, 20, 22, 25, 20, 18, 15, 12],
                'kapal' => [2, 4, 6, 8, 10, 12, 14, 16, 14, 12, 10, 8],
                'distribution' => [
                    ['type' => 'Karcis Bakul', 'count' => $total_semua_bakul],
                    ['type' => 'Karcis Kapal', 'count' => $total_semua_kapal]
                ]
            ];
            
            // Data terbaru
            $bakul_terbaru = $this->karcisBakulModel->orderBy('tanggal_input', 'DESC')
                                                    ->limit(5)
                                                    ->findAll();
            
            $kapal_terbaru = $this->karcisKapalModel->where('petugas_id', $petugas_id)
                                                    ->orderBy('created_at', 'DESC')
                                                    ->limit(5)
                                                    ->findAll();
            
        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            
            // Fallback data
            $total_bakul_harian = $total_kapal_harian = 0;
            $pendapatan_bakul_harian = $pendapatan_kapal_harian = 0;
            $menungguVerifikasi = $total_semua_bakul = $total_semua_kapal = 0;
            
            $chartData = [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                'bakul' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                'kapal' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                'distribution' => [
                    ['type' => 'Karcis Bakul', 'count' => 0],
                    ['type' => 'Karcis Kapal', 'count' => 0]
                ]
            ];
            
            $bakul_terbaru = $kapal_terbaru = [];
        }
        
        // Data untuk view
        $data = [
            'title' => 'Dashboard Petugas - Sistem TPI',
            'nama_lengkap' => session()->get('nama_lengkap') ?? 'Petugas TPI',
            'tpi_id' => session()->get('tpi_id') ?? 1,
            
            // Data statistik
            'total_bakul_harian' => $total_bakul_harian,
            'total_kapal_harian' => $total_kapal_harian,
            'pendapatan_bakul_harian' => $pendapatan_bakul_harian,
            'pendapatan_kapal_harian' => $pendapatan_kapal_harian,
            'menungguVerifikasi' => $menungguVerifikasi,
            'total_semua_bakul' => $total_semua_bakul,
            'total_semua_kapal' => $total_semua_kapal,
            'percentageIncrease' => 12.5,
            
            // Chart data
            'chartData' => $chartData,
            
            // Data terbaru
            'bakul_terbaru' => $bakul_terbaru,
            'kapal_terbaru' => $kapal_terbaru,
            
            // Total harian
            'total_harian' => $total_bakul_harian + $total_kapal_harian,
            'pendapatan_harian' => $pendapatan_bakul_harian + $pendapatan_kapal_harian,
        ];
        
        return view('petugas/dashboard', $data);
    }

    // ==================== INPUT BAKUL ====================
    public function inputBakul()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Input Karcis Bakul',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
        ];
        
        return view('petugas/input_karcis_bakul', $data);
    }
    
    public function saveBakul()
    {
        log_message('debug', '========== SAVE BAKUL START ==========');
        
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // Debug post data
        $postData = $this->request->getPost();
        log_message('debug', '📝 POST Data: ' . print_r($postData, true));
        
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_bakul' => 'required|min_length[3]|max_length[100]',
            'alamat' => 'required|min_length[5]|max_length[150]',
            'berat_ikan' => 'required|numeric|greater_than[0]',
            'jumlah_karcis' => 'required|integer|greater_than[0]',
            'jumlah_pembelian' => 'required|numeric|greater_than[0]',
            'jasa_lelang' => 'numeric',
            'lain_lain' => 'numeric'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        // Hitung total
        $jumlah_pembelian = (float)$this->request->getPost('jumlah_pembelian');
        $jasa_lelang = (float)$this->request->getPost('jasa_lelang') ?? 0;
        $lain_lain = (float)$this->request->getPost('lain_lain') ?? 0;
        $total = $jumlah_pembelian + $jasa_lelang + $lain_lain;
        
        // ==================== DATA UNTUK DISIMPAN ====================
        // HANYA field yang ADA di database
        $data = [
            'nama_bakul' => $this->request->getPost('nama_bakul'),
            'alamat' => $this->request->getPost('alamat'),
            'berat_ikan' => $this->request->getPost('berat_ikan'),
            'jumlah_karcis' => $this->request->getPost('jumlah_karcis'),
            'jumlah_pembelian' => $jumlah_pembelian,
            'jasa_lelang' => $jasa_lelang,
            'lain_lain' => $lain_lain,
            'total' => $total,
            'jumlah_bayar' => $total,
            'status_verifikasi' => 'pending'
            // TIDAK ADA: 'petugas_id', 'tanggal_input'
        ];
        
        log_message('debug', '📦 Data untuk INSERT: ' . print_r($data, true));
        
        try {
            // Debug: Cek koneksi database
            $db = \Config\Database::connect();
            log_message('debug', '🔗 Database connected: ' . ($db->connect() ? 'YES' : 'NO'));
            
            // Debug: Data count sebelum insert
            $countBefore = $db->table('karcis_bakul')->countAll();
            log_message('debug', '📊 Data count BEFORE insert: ' . $countBefore);
            
            // Insert data
            $insertId = $this->karcisBakulModel->insert($data);
            log_message('debug', '📝 Insert ID from Model: ' . ($insertId ?: 'NULL'));
            
            // Debug: Data count setelah insert
            $countAfter = $db->table('karcis_bakul')->countAll();
            log_message('debug', '📊 Data count AFTER insert: ' . $countAfter);
            
            // Verifikasi data
            $check = $db->table('karcis_bakul')->where('id_bakul', $insertId)->get()->getRow();
            
            if ($insertId && $check) {
                log_message('debug', '🎉 SUCCESS: Data saved to database! ID: ' . $insertId);
                
                // Clear cache
                if (function_exists('opcache_reset')) {
                    opcache_reset();
                }
                
                return redirect()->to('/petugas/daftar-karcis-bakul')
                    ->with('success', 'Data karcis bakul berhasil disimpan! ID: ' . $insertId);
                    
            } else {
                log_message('debug', '❌ FAILED: Insert returned ID but data not found in DB');
                
                // Fallback: Direct database insert
                try {
                    $db->table('karcis_bakul')->insert($data);
                    $directId = $db->insertID();
                    
                    if ($directId) {
                        return redirect()->to('/petugas/daftar-karcis-bakul')
                            ->with('success', 'Data karcis bakul berhasil disimpan via direct insert! ID: ' . $directId);
                    }
                } catch (\Exception $e2) {
                    log_message('debug', '❌ Direct DB insert also failed: ' . $e2->getMessage());
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data berhasil disimpan tetapi tidak dapat diverifikasi. Silakan cek database langsung.');
            }
                
        } catch (\Exception $e) {
            log_message('error', '❌ Save bakul error: ' . $e->getMessage());
            log_message('debug', '📄 Error details: ' . $e->getFile() . ':' . $e->getLine());
            
            $errorDetail = 'Gagal menyimpan data. ';
            if (strpos($e->getMessage(), 'petugas_id') !== false) {
                $errorDetail .= 'ERROR: Field petugas_id tidak ada di database. Pastikan tidak mengirim petugas_id.';
            } else {
                $errorDetail .= 'Error: ' . $e->getMessage();
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorDetail);
        } finally {
            log_message('debug', '========== SAVE BAKUL END ==========');
        }
    }
    
    // ==================== INPUT KAPAL ====================
    public function inputKapal()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $no_karcis = $this->karcisKapalModel->generateNoKarcis();
        
        $data = [
            'title' => 'Input Karcis Pemilik Kapal',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'no_karcis' => $no_karcis
        ];
        
        return view('petugas/input_karcis_pemilik_kapal', $data);
    }
    
    public function saveKapal()
    {
        log_message('debug', '========== SAVE KAPAL START ==========');
        
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $petugas_id = session()->get('user_id');
        
        // Debug post data
        $postData = $this->request->getPost();
        log_message('debug', '📝 POST Data KAPAL: ' . print_r($postData, true));
        
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'no_karcis' => 'required|max_length[20]',
            'nama_pemilik' => 'required|min_length[3]|max_length[100]',
            'nama_kapal' => 'required|min_length[3]|max_length[100]',
            'tanggal' => 'required|valid_date',
            'jenis_ikan' => 'required|max_length[50]',
            'berat' => 'required|numeric|greater_than[0]',
            'harga' => 'required|numeric|greater_than[0]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            log_message('debug', '❌ Validasi gagal: ' . print_r($validation->getErrors(), true));
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        // ==================== DATA UNTUK DISIMPAN ====================
        // HANYA FIELD YANG ADA DI TABEL karcis_pemilik_kapal
        $data = [
            'no_karcis' => $this->request->getPost('no_karcis'),
            'nama_pemilik' => $this->request->getPost('nama_pemilik'),
            'nama_kapal' => $this->request->getPost('nama_kapal'),
            'tanggal' => $this->request->getPost('tanggal'),
            'jenis_ikan' => $this->request->getPost('jenis_ikan'),
            'berat' => $this->request->getPost('berat'),
            'harga' => $this->request->getPost('harga'),
            'status_verifikasi' => 'pending',
            'petugas_id' => $petugas_id
            // TIDAK ADA: tanggal_verifikasi, admin_id, created_at, updated_at
        ];
        
        log_message('debug', '📦 Data untuk INSERT KAPAL: ' . print_r($data, true));
        
        try {
            // Debug: Cek koneksi database
            $db = \Config\Database::connect();
            log_message('debug', '🔗 Database connected: ' . ($db->connect() ? 'YES' : 'NO'));
            
            // Debug: Cek struktur tabel
            log_message('debug', '🔍 Cek tabel karcis_pemilik_kapal...');
            if (!$db->tableExists('karcis_pemilik_kapal')) {
                log_message('error', '❌ Tabel karcis_pemilik_kapal tidak ditemukan!');
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Tabel database tidak ditemukan!');
            }
            
            // Debug: Data count sebelum insert
            $countBefore = $db->table('karcis_pemilik_kapal')->countAll();
            log_message('debug', '📊 Data count BEFORE insert: ' . $countBefore);
            
            // Debug: Cek model configuration
            log_message('debug', '🔧 Model configuration:');
            log_message('debug', '   - Table: ' . $this->karcisKapalModel->table);
            log_message('debug', '   - useTimestamps: ' . ($this->karcisKapalModel->useTimestamps ? 'TRUE' : 'FALSE'));
            log_message('debug', '   - createdField: ' . ($this->karcisKapalModel->createdField ?? 'NULL'));
            log_message('debug', '   - updatedField: ' . ($this->karcisKapalModel->updatedField ?? 'NULL'));
            
            // Insert data
            $insertId = $this->karcisKapalModel->insert($data);
            log_message('debug', '📝 Insert ID from Model: ' . ($insertId ?: 'NULL'));
            
            // Debug: Data count setelah insert
            $countAfter = $db->table('karcis_pemilik_kapal')->countAll();
            log_message('debug', '📊 Data count AFTER insert: ' . $countAfter);
            
            // Verifikasi data
            if ($insertId) {
                $check = $db->table('karcis_pemilik_kapal')->where('id', $insertId)->get()->getRow();
                
                if ($check) {
                    log_message('debug', '🎉 SUCCESS: Data kapal saved to karcis_pemilik_kapal! ID: ' . $insertId);
                    log_message('debug', '✅ Data yang disimpan: ' . print_r($check, true));
                    
                    return redirect()->to('/petugas/daftar-karcis-pemilik-kapal')
                        ->with('success', 'Data karcis kapal berhasil disimpan! No: ' . $data['no_karcis']);
                        
                } else {
                    log_message('debug', '❌ FAILED: Insert returned ID but data not found in DB');
                    
                    // Coba cek apakah data masuk ke tabel yang salah
                    $checkWrongTable = $db->table('karcis_kapal')->where('nama_kapal', $data['nama_kapal'])->get()->getRow();
                    if ($checkWrongTable) {
                        log_message('debug', '⚠️ Data ditemukan di tabel karcis_kapal!');
                        return redirect()->back()
                            ->withInput()
                            ->with('error', 'ERROR: Data masuk ke tabel yang salah (karcis_kapal)!');
                    }
                    
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Data gagal disimpan. Silakan cek database langsung.');
                }
            } else {
                log_message('error', '❌ Insert gagal - tidak ada ID yang dikembalikan');
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Insert gagal - sistem tidak mengembalikan ID');
            }
                
        } catch (\Exception $e) {
            log_message('error', '❌ Save kapal error: ' . $e->getMessage());
            log_message('debug', '📄 Error details: ' . $e->getFile() . ':' . $e->getLine());
            
            $errorDetail = 'Gagal menyimpan data kapal. ';
            $errorDetail .= 'Error: ' . $e->getMessage();
            
            // Cek error spesifik
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                $errorDetail .= "\n\n⚠️ ERROR: Ada field yang tidak ada di database!";
                
                // Extract column name from error
                preg_match("/Unknown column '(.+?)'/", $e->getMessage(), $matches);
                if (isset($matches[1])) {
                    $errorDetail .= "\nField yang bermasalah: '" . $matches[1] . "'";
                    
                    // Saran perbaikan berdasarkan field yang error
                    if ($matches[1] === 'updated_at') {
                        $errorDetail .= "\n💡 SOLUSI: Nonaktifkan timestamps di Model (useTimestamps = false)";
                    }
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorDetail);
        } finally {
            log_message('debug', '========== SAVE KAPAL END ==========');
        }
    }
    
    // ==================== DAFTAR KARCIS BAKUL ====================
    public function daftarKarcisBakul()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        // TIDAK BISA FILTER BY PETUGAS_ID karena field tidak ada
        try {
            $karcis = $this->karcisBakulModel->orderBy('tanggal_input', 'DESC')->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error get bakul list: ' . $e->getMessage());
            $karcis = [];
        }
        
        $data = [
            'title' => 'Daftar Karcis Bakul',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'karcis' => $karcis
        ];
        
        return view('petugas/daftar_karcis_bakul', $data);
    }
    
    // ==================== DAFTAR KARCIS PEMILIK KAPAL ====================
    public function daftarKarcisPemilikKapal()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $petugas_id = session()->get('user_id');
        
        try {
            $karcis = $this->karcisKapalModel->where('petugas_id', $petugas_id)
                                            ->orderBy('created_at', 'DESC')
                                            ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error get kapal list: ' . $e->getMessage());
            $karcis = [];
        }
        
        $data = [
            'title' => 'Daftar Karcis Pemilik Kapal',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'karcis' => $karcis
        ];
        
        return view('petugas/daftar_karcis_pemilik_kapal', $data);
    }
    
    // ==================== HISTORY ====================
    public function history()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $petugas_id = session()->get('user_id');
        $history_data = [];
        
        // Data bakul - TIDAK BISA FILTER BY PETUGAS_ID
        try {
            $bakul_history = $this->karcisBakulModel->orderBy('tanggal_input', 'DESC')->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error get bakul history: ' . $e->getMessage());
            $bakul_history = [];
        }
        
        foreach ($bakul_history as $item) {
            $history_data[] = [
                'type' => 'bakul',
                'id' => $item['id_bakul'] ?? 0,
                'nama' => $item['nama_bakul'] ?? 'N/A',
                'nama_kapal' => '',
                'jenis_ikan' => 'Bakul',
                'berat' => $item['berat_ikan'] ?? 0,
                'harga' => $item['total'] ?? 0,
                'tanggal' => $item['tanggal_input'] ?? date('Y-m-d H:i:s'),
                'status' => $item['status_verifikasi'] ?? 'pending'
            ];
        }
        
        // Data kapal - MASIH BISA FILTER
        try {
            $kapal_history = $this->karcisKapalModel->where('petugas_id', $petugas_id)
                                                  ->orderBy('created_at', 'DESC')
                                                  ->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error get kapal history: ' . $e->getMessage());
            $kapal_history = [];
        }
        
        foreach ($kapal_history as $item) {
            $history_data[] = [
                'type' => 'kapal',
                'id' => $item['id'] ?? 0,
                'nama' => $item['nama_pemilik'] ?? 'N/A',
                'nama_kapal' => $item['nama_kapal'] ?? 'N/A',
                'jenis_ikan' => $item['jenis_ikan'] ?? 'N/A',
                'berat' => $item['berat'] ?? 0,
                'harga' => $item['harga'] ?? 0,
                'tanggal' => $item['created_at'] ?? $item['tanggal'] ?? date('Y-m-d'),
                'status' => $item['status_verifikasi'] ?? 'pending'
            ];
        }
        
        // Urutkan berdasarkan tanggal
        usort($history_data, function($a, $b) {
            $timeA = strtotime($a['tanggal'] ?? '1970-01-01');
            $timeB = strtotime($b['tanggal'] ?? '1970-01-01');
            return $timeB - $timeA;
        });
        
        $data = [
            'title' => 'History Input Karcis',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'history_data' => $history_data
        ];
        
        return view('petugas/history', $data);
    }
    
    // ==================== METHOD LAINNYA ====================
    public function profile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Profile Petugas',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id')
        ];
        
        return view('petugas/profile', $data);
    }
    
    public function inputSukses()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Input Berhasil',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id')
        ];
        
        return view('petugas/input_sukses', $data);
    }
    
    public function inputSuksesKapal()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'title' => 'Input Berhasil - Kapal',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id')
        ];
        
        return view('petugas/input_sukses_kapal', $data);
    }
    
    public function settings()
    {
        return $this->profile();
    }
    
    public function statistik()
    {
        return $this->index();
    }
    
    // ==================== CRUD METHODS ====================
    public function editBakul($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $karcis = $this->karcisBakulModel->find($id);
        
        if (!$karcis) {
            return redirect()->to('/petugas/daftar-karcis-bakul')
                ->with('error', 'Data karcis tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Karcis Bakul',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'karcis' => $karcis
        ];
        
        return view('petugas/edit_karcis_bakul', $data);
    }
    
    public function updateBakul($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_bakul' => 'required|min_length[3]|max_length[100]',
            'berat_ikan' => 'required|numeric|greater_than[0]',
            'jumlah_pembelian' => 'required|numeric|greater_than[0]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        $data = [
            'nama_bakul' => $this->request->getPost('nama_bakul'),
            'alamat' => $this->request->getPost('alamat'),
            'berat_ikan' => $this->request->getPost('berat_ikan'),
            'jumlah_karcis' => $this->request->getPost('jumlah_karcis'),
            'jumlah_pembelian' => $this->request->getPost('jumlah_pembelian'),
            'jasa_lelang' => $this->request->getPost('jasa_lelang') ?? 0,
            'lain_lain' => $this->request->getPost('lain_lain') ?? 0,
            'total' => $this->request->getPost('total'),
            'jumlah_bayar' => $this->request->getPost('total')
        ];
        
        try {
            $this->karcisBakulModel->update($id, $data);
            
            return redirect()->to('/petugas/daftar-karcis-bakul')
                ->with('success', 'Data karcis bakul berhasil diperbarui!');
                
        } catch (\Exception $e) {
            log_message('error', 'Update bakul error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data. Error: ' . $e->getMessage());
        }
    }
    
    public function deleteBakul($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        try {
            $this->karcisBakulModel->delete($id);
            
            return redirect()->to('/petugas/daftar-karcis-bakul')
                ->with('success', 'Data karcis bakul berhasil dihapus!');
                
        } catch (\Exception $e) {
            log_message('error', 'Delete bakul error: ' . $e->getMessage());
            
            return redirect()->to('/petugas/daftar-karcis-bakul')
                ->with('error', 'Gagal menghapus data. Error: ' . $e->getMessage());
        }
    }
    
    public function editKapal($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $karcis = $this->karcisKapalModel->find($id);
        
        if (!$karcis) {
            return redirect()->to('/petugas/daftar-karcis-pemilik-kapal')
                ->with('error', 'Data karcis tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Karcis Kapal',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'karcis' => $karcis
        ];
        
        return view('petugas/edit_karcis_kapal', $data);
    }
    
    public function updateKapal($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_pemilik' => 'required|min_length[3]|max_length[100]',
            'berat' => 'required|numeric|greater_than[0]',
            'harga' => 'required|numeric|greater_than[0]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        $data = [
            'nama_pemilik' => $this->request->getPost('nama_pemilik'),
            'nama_kapal' => $this->request->getPost('nama_kapal'),
            'tanggal' => $this->request->getPost('tanggal'),
            'jenis_ikan' => $this->request->getPost('jenis_ikan'),
            'berat' => $this->request->getPost('berat'),
            'harga' => $this->request->getPost('harga')
        ];
        
        try {
            $this->karcisKapalModel->update($id, $data);
            
            return redirect()->to('/petugas/daftar-karcis-pemilik-kapal')
                ->with('success', 'Data karcis kapal berhasil diperbarui!');
                
        } catch (\Exception $e) {
            log_message('error', 'Update kapal error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data. Error: ' . $e->getMessage());
        }
    }
    
    public function deleteKapal($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        try {
            $this->karcisKapalModel->delete($id);
            
            return redirect()->to('/petugas/daftar-karcis-pemilik-kapal')
                ->with('success', 'Data karcis kapal berhasil dihapus!');
                
        } catch (\Exception $e) {
            log_message('error', 'Delete kapal error: ' . $e->getMessage());
            
            return redirect()->to('/petugas/daftar-karcis-pemilik-kapal')
                ->with('error', 'Gagal menghapus data. Error: ' . $e->getMessage());
        }
    }
    
    // ==================== VERIFIKASI ====================
    public function verifikasi()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $petugas_id = session()->get('user_id');
        
        $karcisKapal = $this->karcisKapalModel->where('status_verifikasi', 'pending')
                                            ->where('petugas_id', $petugas_id)
                                            ->findAll();
        
        $data = [
            'title' => 'Verifikasi Karcis',
            'nama_lengkap' => session()->get('nama_lengkap'),
            'tpi_id' => session()->get('tpi_id'),
            'karcisKapal' => $karcisKapal
        ];
        
        return view('petugas/verifikasi', $data);
    }
    
    public function prosesVerifikasi($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        log_message('debug', '========== PROSES VERIFIKASI START ==========');
        log_message('debug', 'Verifikasi ID: ' . $id);
        
        try {
            // HAPUS tanggal_verifikasi karena field tidak ada di database
            $updateData = [
                'status_verifikasi' => 'verified'
                // TIDAK ADA: 'tanggal_verifikasi'
            ];
            
            log_message('debug', '📝 Data untuk update: ' . print_r($updateData, true));
            
            $result = $this->karcisKapalModel->update($id, $updateData);
            
            if ($result) {
                log_message('debug', '✅ Verifikasi berhasil untuk ID: ' . $id);
                return redirect()->to('/petugas/verifikasi')
                    ->with('success', 'Karcis berhasil diverifikasi!');
            } else {
                log_message('debug', '❌ Verifikasi gagal untuk ID: ' . $id);
                return redirect()->to('/petugas/verifikasi')
                    ->with('error', 'Gagal memverifikasi karcis.');
            }
                    
        } catch (\Exception $e) {
            log_message('error', '❌ Verifikasi error: ' . $e->getMessage());
            log_message('debug', '📄 Error details: ' . $e->getFile() . ':' . $e->getLine());
            
            // Cek error spesifik
            $errorMessage = 'Gagal memverifikasi. Error: ' . $e->getMessage();
            if (strpos($e->getMessage(), 'Unknown column') !== false) {
                $errorMessage .= "\n\n⚠️ ERROR: Field tidak ada di database!";
            }
            
            return redirect()->to('/petugas/verifikasi')
                ->with('error', $errorMessage);
        } finally {
            log_message('debug', '========== PROSES VERIFIKASI END ==========');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logout berhasil');
    }
}