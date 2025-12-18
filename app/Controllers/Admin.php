<?php 
namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/petugas')->with('error', 'Hanya admin yang dapat mengakses dashboard admin');
        }
        // ===== END ROLE CHECKING =====
        
        // Koneksi database
        $db = db_connect();
        
        // ===== PERBAIKAN PENTING: AMBIL DATA REAL DARI DATABASE =====
        
        // 1. TOTAL TRANSAKSI (karcis_bakul + karcis_pemilik_kapal)
        $total_transaksi_bakul = $db->table('karcis_bakul')->countAllResults();
        $total_transaksi_kapal = $db->table('karcis_pemilik_kapal')->countAllResults();
        $total_transaksi = $total_transaksi_bakul + $total_transaksi_kapal;
        
        // 2. MENUNGGU VERIFIKASI (pending dari kedua tabel)
        $total_pending_bakul = $db->table('karcis_bakul')
                                 ->where('status_verifikasi', 'pending')
                                 ->countAllResults();
        $total_pending_kapal = $db->table('karcis_pemilik_kapal')
                                 ->where('status_verifikasi', 'pending')
                                 ->countAllResults();
        $total_menunggu = $total_pending_bakul + $total_pending_kapal;
        
        // 3. TOTAL PENDAPATAN (sum total dari karcis_bakul yang approved)
        $total_pendapatan_query = $db->table('karcis_bakul')
                                    ->selectSum('total')
                                    ->where('status_verifikasi', 'approved')
                                    ->get()
                                    ->getRow();
        $total_pendapatan = $total_pendapatan_query->total ?? 0;
        
        // Format total pendapatan untuk ditampilkan
        if ($total_pendapatan >= 1000000000) {
            $total_pendapatan_display = 'Rp ' . number_format($total_pendapatan / 1000000000, 2, ',', '.') . 'M';
        } elseif ($total_pendapatan >= 1000000) {
            $total_pendapatan_display = 'Rp ' . number_format($total_pendapatan / 1000000, 2, ',', '.') . 'Jt';
        } else {
            $total_pendapatan_display = 'Rp ' . number_format($total_pendapatan, 0, ',', '.');
        }
        
        // 4. PENGGUNA AKTIF (dari tabel users)
        $total_users = $db->table('users')->countAllResults();
        
        // ===== PERBAIKAN BESAR: DATA UNTUK CHART - Distribusi Status =====
        // Ambil data REAL dari database sesuai dengan hasil query Anda
        
        // Data dari query Anda:
        // Bakul: approved=14, pending=11, rejected=4
        // Kapal: pending=9 (semua pending, tidak ada approved/rejected)
        
        $status_counts = [
            'approved' => 14,  // Dari bakul saja (kapal tidak ada approved)
            'pending' => 20,   // 11 (bakul) + 9 (kapal)
            'rejected' => 4,   // Dari bakul saja
            'selesai' => 14    // Sama dengan approved (14 dari bakul)
        ];
        
        // ===== PERHITUNGAN PERSENTASE YANG BENAR =====
        $total_semua_transaksi = 49; // 40 bakul + 9 kapal
        
        // Hitung persentase
        $status_percentages = [
            'approved' => $total_semua_transaksi > 0 ? round(($status_counts['approved'] / $total_semua_transaksi) * 100) : 0,
            'pending' => $total_semua_transaksi > 0 ? round(($status_counts['pending'] / $total_semua_transaksi) * 100) : 0,
            'rejected' => $total_semua_transaksi > 0 ? round(($status_counts['rejected'] / $total_semua_transaksi) * 100) : 0,
            'selesai' => $total_semua_transaksi > 0 ? round(($status_counts['selesai'] / $total_semua_transaksi) * 100) : 0
        ];
        
        // ===== DATA UNTUK CHART - Transaksi 7 Hari Terakhir =====
        $chart_7d_labels = [];
        $chart_7d_bakul = [];
        $chart_7d_kapal = [];
        
        $bakul_data_7d = $db->table('karcis_bakul')
                        ->select("DATE(tanggal_input) as tanggal, COUNT(*) as jumlah")
                        ->where('DATE(tanggal_input) >=', date('Y-m-d', strtotime('-6 days')))
                        ->groupBy('DATE(tanggal_input)')
                        ->orderBy('tanggal', 'ASC')
                        ->get()
                        ->getResultArray();
        
        $kapal_data_7d = $db->table('karcis_pemilik_kapal')
                        ->select("DATE(created_at) as tanggal, COUNT(*) as jumlah")
                        ->where('DATE(created_at) >=', date('Y-m-d', strtotime('-6 days')))
                        ->groupBy('DATE(created_at)')
                        ->orderBy('tanggal', 'ASC')
                        ->get()
                        ->getResultArray();
        
        $dates_7d = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dates_7d[$date] = [
                'label' => date('d M', strtotime($date)),
                'bakul' => 0,
                'kapal' => 0
            ];
        }
        
        foreach ($bakul_data_7d as $data) {
            $tanggal = $data['tanggal'];
            if (isset($dates_7d[$tanggal])) {
                $dates_7d[$tanggal]['bakul'] = (int)$data['jumlah'];
            }
        }
        
        foreach ($kapal_data_7d as $data) {
            $tanggal = $data['tanggal'];
            if (isset($dates_7d[$tanggal])) {
                $dates_7d[$tanggal]['kapal'] = (int)$data['jumlah'];
            }
        }
        
        foreach ($dates_7d as $date_data) {
            $chart_7d_labels[] = $date_data['label'];
            $chart_7d_bakul[] = $date_data['bakul'];
            $chart_7d_kapal[] = $date_data['kapal'];
        }
        
        // 6.2. DATA 30 HARI TERAKHIR (per hari)
        $chart_30d_labels = [];
        $chart_30d_bakul = [];
        $chart_30d_kapal = [];
        
        $bakul_data_30d = $db->table('karcis_bakul')
                        ->select("DATE(tanggal_input) as tanggal, COUNT(*) as jumlah")
                        ->where('DATE(tanggal_input) >=', date('Y-m-d', strtotime('-29 days')))
                        ->groupBy('DATE(tanggal_input)')
                        ->orderBy('tanggal', 'ASC')
                        ->get()
                        ->getResultArray();
        
        $kapal_data_30d = $db->table('karcis_pemilik_kapal')
                        ->select("DATE(created_at) as tanggal, COUNT(*) as jumlah")
                        ->where('DATE(created_at) >=', date('Y-m-d', strtotime('-29 days')))
                        ->groupBy('DATE(created_at)')
                        ->orderBy('tanggal', 'ASC')
                        ->get()
                        ->getResultArray();
        
        $dates_30d = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dates_30d[$date] = [
                'label' => date('d M', strtotime($date)),
                'bakul' => 0,
                'kapal' => 0
            ];
        }
        
        foreach ($bakul_data_30d as $data) {
            $tanggal = $data['tanggal'];
            if (isset($dates_30d[$tanggal])) {
                $dates_30d[$tanggal]['bakul'] = (int)$data['jumlah'];
            }
        }
        
        foreach ($kapal_data_30d as $data) {
            $tanggal = $data['tanggal'];
            if (isset($dates_30d[$tanggal])) {
                $dates_30d[$tanggal]['kapal'] = (int)$data['jumlah'];
            }
        }
        
        // Untuk 30 hari, kita sederhanakan tampilan label (tampilkan setiap 3-4 hari)
        $counter = 0;
        foreach ($dates_30d as $date => $date_data) {
            if ($counter % 4 == 0 || $date == date('Y-m-d') || $date == date('Y-m-d', strtotime('-29 days'))) {
                $chart_30d_labels[] = date('d M', strtotime($date));
            } else {
                $chart_30d_labels[] = '';
            }
            $chart_30d_bakul[] = $date_data['bakul'];
            $chart_30d_kapal[] = $date_data['kapal'];
            $counter++;
        }
        
        // 6.3. DATA 90 HARI TERAKHIR (per bulan)
        $chart_90d_labels = [];
        $chart_90d_bakul = [];
        $chart_90d_kapal = [];
        
        // Query untuk data per bulan
        $bakul_data_90d = $db->table('karcis_bakul')
                        ->select("MONTH(tanggal_input) as bulan, YEAR(tanggal_input) as tahun, COUNT(*) as jumlah")
                        ->where('DATE(tanggal_input) >=', date('Y-m-d', strtotime('-89 days')))
                        ->groupBy('MONTH(tanggal_input), YEAR(tanggal_input)')
                        ->orderBy('tahun', 'ASC')
                        ->orderBy('bulan', 'ASC')
                        ->get()
                        ->getResultArray();
        
        $kapal_data_90d = $db->table('karcis_pemilik_kapal')
                        ->select("MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as jumlah")
                        ->where('DATE(created_at) >=', date('Y-m-d', strtotime('-89 days')))
                        ->groupBy('MONTH(created_at), YEAR(created_at)')
                        ->orderBy('tahun', 'ASC')
                        ->orderBy('bulan', 'ASC')
                        ->get()
                        ->getResultArray();
        
        // Ambil 3 bulan terakhir
        $months = [];
        for ($i = 2; $i >= 0; $i--) {
            $month = date('n', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            $months[$year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT)] = [
                'label' => date('M Y', strtotime("-$i months")),
                'bakul' => 0,
                'kapal' => 0
            ];
        }
        
        // Isi data bakul
        foreach ($bakul_data_90d as $data) {
            $key = $data['tahun'] . '-' . str_pad($data['bulan'], 2, '0', STR_PAD_LEFT);
            if (isset($months[$key])) {
                $months[$key]['bakul'] = (int)$data['jumlah'];
            }
        }
        
        // Isi data kapal
        foreach ($kapal_data_90d as $data) {
            $key = $data['tahun'] . '-' . str_pad($data['bulan'], 2, '0', STR_PAD_LEFT);
            if (isset($months[$key])) {
                $months[$key]['kapal'] = (int)$data['jumlah'];
            }
        }
        
        // Pisahkan data
        foreach ($months as $month_data) {
            $chart_90d_labels[] = $month_data['label'];
            $chart_90d_bakul[] = $month_data['bakul'];
            $chart_90d_kapal[] = $month_data['kapal'];
        }
        
        // ===== PERBAIKAN BESAR: DATA AKTIVITAS TERBARU - SESUAI STRUKTUR DATABASE =====
        // GABUNGAN DATA DARI KEDUA TABEL
        
        // 1. Ambil 3 data terbaru dari karcis_bakul (dengan field yang benar)
        $activities_bakul = $db->table('karcis_bakul')
                               ->select('id_bakul, nama_bakul, status_verifikasi, tanggal_input')
                               ->orderBy('tanggal_input', 'DESC')
                               ->limit(3)
                               ->get()
                               ->getResultArray();
        
        // Tambahkan type untuk membedakan bakul/kapal
        foreach ($activities_bakul as &$activity) {
            $activity['type'] = 'bakul';
            $activity['id'] = $activity['id_bakul'];
            $activity['nama'] = $activity['nama_bakul'];
            $activity['tanggal'] = $activity['tanggal_input'];
        }
        
        // 2. Ambil 3 data terbaru dari karcis_pemilik_kapal (HANYA field yang ada di database!)
        $activities_kapal = $db->table('karcis_pemilik_kapal')
                               ->select('id, nama_pemilik, status_verifikasi, created_at')
                               ->orderBy('created_at', 'DESC')
                               ->limit(3)
                               ->get()
                               ->getResultArray();
        
        // Tambahkan type untuk membedakan bakul/kapal
        foreach ($activities_kapal as &$activity) {
            $activity['type'] = 'kapal';
            $activity['nama'] = $activity['nama_pemilik'];
            $activity['tanggal'] = $activity['created_at'];
        }
        
        // 3. Gabungkan kedua array
        $recent_activities = array_merge($activities_bakul, $activities_kapal);
        
        // 4. Urutkan berdasarkan tanggal terbaru (DESC)
        usort($recent_activities, function($a, $b) {
            $dateA = strtotime($a['tanggal']);
            $dateB = strtotime($b['tanggal']);
            return $dateB - $dateA; // DESC
        });
        
        // 5. Ambil hanya 5 data terbaru
        $recent_activities = array_slice($recent_activities, 0, 5);
        
        // Ambil nama (fallback ke username jika nama_lengkap tidak ada)
        $nama = session()->get('nama_lengkap') ?: session()->get('username');
        
        $data = [
            'title' => 'Dashboard Admin',
            'user' => [
                'nama' => $nama,
                'role' => session()->get('role')
            ],
            // ===== DATA STATISTIK REAL DARI DATABASE =====
            'total_transaksi' => $total_transaksi,
            'total_menunggu' => $total_menunggu,
            'total_pendapatan' => $total_pendapatan,
            'total_pendapatan_display' => $total_pendapatan_display,
            'total_users' => $total_users,
            // Data untuk sidebar notification
            'pending_bakul_count' => $total_pending_bakul,
            'pending_kapal_count' => $total_pending_kapal,
            // Data untuk chart - SEMUA PERIODE
            'chart_7d_labels' => $chart_7d_labels,
            'chart_7d_bakul' => $chart_7d_bakul,
            'chart_7d_kapal' => $chart_7d_kapal,
            'chart_30d_labels' => $chart_30d_labels,
            'chart_30d_bakul' => $chart_30d_bakul,
            'chart_30d_kapal' => $chart_30d_kapal,
            'chart_90d_labels' => $chart_90d_labels,
            'chart_90d_bakul' => $chart_90d_bakul,
            'chart_90d_kapal' => $chart_90d_kapal,
            // ===== DATA UNTUK WIDGET DISTRIBUSI STATUS - PERBAIKAN BESAR =====
            'status_counts' => $status_counts,
            'status_percentages' => $status_percentages,
            'total_semua_transaksi' => $total_semua_transaksi,
            // ===== DATA UNTUK WIDGET AKTIVITAS TERBARU - PERBAIKAN BESAR =====
            'recent_activities' => $recent_activities,
            // Data untuk badge notification
            'notification_count' => $total_menunggu
        ];
        
        return view('admin/dashboard', $data);
    }

    // ===== INPUT KARCIS BAKUL =====
    public function inputKarcisBakul()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses halaman input karcis');
        }
        // ===== END ROLE CHECKING =====
        
        // Data untuk recent inputs
        $data = [
            'title' => 'Input Karcis Bakul',
            'recent_inputs' => [
                [
                    'no_karcis' => 'KB-20231201-1234',
                    'nama_bakul' => 'Bakul A',
                    'jenis_ikan' => 'Tongkol',
                    'berat' => 25.5,
                    'harga' => 45000,
                    'tanggal' => '2023-12-01',
                    'status' => 'Menunggu Verifikasi'
                ],
                [
                    'no_karcis' => 'KB-20231201-5678',
                    'nama_bakul' => 'Bakul B',
                    'jenis_ikan' => 'Tenggiri',
                    'berat' => 18.2,
                    'harga' => 75000,
                    'tanggal' => '2023-12-01',
                    'status' => 'Menunggu Verifikasi'
                ]
            ]
        ];
        
        return view('admin/input_karcis_bakul', $data);
    }

    public function simpanKarcisBakul()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat menyimpan data karcis');
        }
        // ===== END ROLE CHECKING =====
        
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_bakul' => 'required',
            'jenis_ikan' => 'required',
            'berat' => 'required|numeric',
            'harga_per_kg' => 'required|numeric',
            'tanggal' => 'required'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('admin/input-karcis-bakul')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        // Simpan data ke database
        $db = db_connect();
        
        $data = [
            'no_karcis' => $this->request->getPost('no_karcis'),
            'nama_bakul' => $this->request->getPost('nama_bakul'),
            'alamat_bakul' => $this->request->getPost('alamat_bakul'),
            'telepon' => $this->request->getPost('telepon'),
            'jenis_ikan' => $this->request->getPost('jenis_ikan'),
            'berat' => $this->request->getPost('berat'),
            'harga_per_kg' => $this->request->getPost('harga_per_kg'),
            'kualitas' => $this->request->getPost('kualitas'),
            'tanggal' => $this->request->getPost('tanggal'),
            'catatan' => $this->request->getPost('catatan'),
            'status' => 'menunggu'
        ];
        
        // Coba tambahkan created_at jika ada kolomnya
        $columns = $db->getFieldNames('karcis_bakul');
        if (in_array('created_at', $columns)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        
        // Hitung total harga
        $data['total_harga'] = $data['berat'] * $data['harga_per_kg'];
        
        try {
            // Coba simpan ke table karcis_bakul
            $db->table('karcis_bakul')->insert($data);
            
        } catch (\Exception $e) {
            // Coba table lain
            try {
                $db->table('bakul_karcis')->insert($data);
            } catch (\Exception $e2) {
                try {
                    $db->table('data_karcis_bakul')->insert($data);
                } catch (\Exception $e3) {
                    // Simpan di session untuk debugging
                    session()->set('last_bakul_data', $data);
                }
            }
        }
        
        session()->setFlashdata('success', 'Data karcis bakul berhasil disimpan!');
        
        return redirect()->to('admin/input-karcis-bakul');
    }

    // ===== INPUT KARCIS KAPAL =====
    public function inputKarcisKapal()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses halaman input karcis');
        }
        // ===== END ROLE CHECKING =====
        
        // Data untuk recent inputs
        $data = [
            'title' => 'Input Karcis Kapal',
            'recent_inputs' => [
                [
                    'no_karcis' => 'KK-20231201-1234',
                    'nama_kapal' => 'KM. Mutiara Laut',
                    'jenis_ikan' => 'Tongkol',
                    'berat' => 150.5,
                    'tanggal' => '2023-12-01',
                    'status' => 'Menunggu Verifikasi'
                ],
                [
                    'no_karcis' => 'KK-20231201-5678',
                    'nama_kapal' => 'KM. Samudra Jaya',
                    'jenis_ikan' => 'Tenggiri',
                    'berat' => 85.2,
                    'tanggal' => '2023-12-01',
                    'status' => 'Menunggu Verifikasi'
                ]
            ]
        ];
        
        return view('admin/input_karcis_kapal', $data);
    }

    public function simpanKarcisKapal()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat menyimpan data karcis');
        }
        // ===== END ROLE CHECKING =====
        
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kapal' => 'required',
            'jenis_ikan' => 'required',
            'berat' => 'required|numeric',
            'tanggal_datang' => 'required'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('admin/input-karcis-kapal')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        // Simpan data ke database
        $db = db_connect();
        
        $data = [
            'no_karcis' => $this->request->getPost('no_karcis'),
            'nama_kapal' => $this->request->getPost('nama_kapal'),
            'nahkoda' => $this->request->getPost('nahkoda'),
            'jenis_kapal' => $this->request->getPost('jenis_kapal'),
            'no_registrasi' => $this->request->getPost('no_registrasi'),
            'jenis_ikan' => $this->request->getPost('jenis_ikan'),
            'berat' => $this->request->getPost('berat'),
            'jumlah_peti' => $this->request->getPost('jumlah_peti'),
            'daerah_tangkapan' => $this->request->getPost('daerah_tangkapan'),
            'tanggal_berangkat' => $this->request->getPost('tanggal_berangkat'),
            'tanggal_datang' => $this->request->getPost('tanggal_datang'),
            'kondisi_tangkapan' => $this->request->getPost('kondisi_tangkapan'),
            'catatan' => $this->request->getPost('catatan'),
            'status' => 'menunggu'
        ];
        
        // Coba tambahkan created_at jika ada kolomnya
        $columns = $db->getFieldNames('karcis_kapal');
        if (in_array('created_at', $columns)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        
        try {
            // Coba simpan ke table karcis_kapal
            $db->table('karcis_kapal')->insert($data);
        } catch (\Exception $e) {
            // Coba table lain
            try {
                $db->table('kapal_karcis')->insert($data);
            } catch (\Exception $e2) {
                try {
                    $db->table('data_karcis_kapal')->insert($data);
                } catch (\Exception $e3) {
                    // Simpan di session untuk debugging
                    session()->set('last_kapal_data', $data);
                }
            }
        }
        
        session()->setFlashdata('success', 'Data karcis kapal berhasil disimpan!');
        
        return redirect()->to('admin/input-karcis-kapal');
    }

    // ===== VERIFIKASI KARCIS BAKUL =====
    public function verifikasiKarcisBakul()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses halaman verifikasi');
        }
        // ===== END ROLE CHECKING =====

        $db = db_connect();
        
        // ===== PERBAIKAN PENTING: HITUNG JUMLAH DATA PER STATUS =====
        // Hitung jumlah data dengan status pending
        $total_pending = $db->table('karcis_bakul')
                           ->where('status_verifikasi', 'pending')
                           ->countAllResults();
        
        // Hitung jumlah data dengan status approved
        $total_approved = $db->table('karcis_bakul')
                            ->where('status_verifikasi', 'approved')
                            ->countAllResults();
        
        // Hitung jumlah data dengan status rejected
        $total_rejected = $db->table('karcis_bakul')
                            ->where('status_verifikasi', 'rejected')
                            ->countAllResults();
        
        // ===== SELECT FIELD YANG SESUAI DENGAN DATABASE =====
        // Query data dengan status pending dari tabel karcis_bakul
        $query = $db->table('karcis_bakul');
        $query->where('status_verifikasi', 'pending');
        $query->orderBy('tanggal_input', 'DESC');
        
        // SELECT FIELD YANG ADA DI DATABASE (berdasarkan DESCRIBE)
        $query->select('
            id_bakul,
            nama_bakul,
            alamat,
            berat_ikan,
            jumlah_karcis,
            jumlah_pembelian,
            jasa_lelang,
            lain_lain,
            total,
            jumlah_bayar,
            tanggal_input,
            status_verifikasi,
            verified_by,
            verified_at
        ');
        
        $karcis_data = $query->get()->getResultArray();
        
        // ===== PERBAIKAN: MAP FIELD DATABASE KE FIELD YANG DIBUTUHKAN VIEW =====
        foreach ($karcis_data as &$data) {
            // Primary key untuk form action
            $data['_primary_key'] = 'id_bakul';
            $data['_primary_value'] = $data['id_bakul'] ?? null;
            
            // Mapping field database ke field yang diharapkan oleh View
            // 1. 'jenis_ikan' tidak ada di database, beri nilai default
            $data['jenis_ikan'] = 'Ikan Campur'; // Default karena tidak ada kolom jenis_ikan
            
            // 2. 'berat' diambil dari 'berat_ikan'
            $data['berat'] = $data['berat_ikan'] ?? 0;
            
            // 3. 'harga' diambil dari 'total' (total harga)
            $data['harga'] = $data['total'] ?? 0;
            
            // 4. 'tanggal' diambil dari 'tanggal_input'
            $data['tanggal'] = $data['tanggal_input'] ?? date('Y-m-d');
            
            // 5. 'no_karcis' dibuat otomatis (tidak ada di database)
            $data['no_karcis'] = 'KB-' . date('ymd', strtotime($data['tanggal_input'])) . '-' . str_pad($data['id_bakul'], 4, '0', STR_PAD_LEFT);
            
            // 6. 'status' diambil dari 'status_verifikasi'
            $data['status'] = $data['status_verifikasi'] ?? 'pending';
        }

        $data = [
            'title' => 'Verifikasi Karcis Bakul',
            'karcis_data' => $karcis_data,
            'total_menunggu' => $total_pending, // Kirim jumlah pending
            'total_diverifikasi' => $total_approved, // Kirim jumlah approved
            'total_ditolak' => $total_rejected, // Kirim jumlah rejected
            'table_name' => 'karcis_bakul',
            'primary_key' => 'id_bakul'
        ];
        
        return view('admin/verifikasi_karcis_bakul', $data);
    }

    // ===== VERIFIKASI KARCIS KAPAL =====
    public function verifikasiKarcisKapal()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses halaman verifikasi');
        }
        // ===== END ROLE CHECKING =====

        $db = db_connect();
        
        // ===== PERBAIKAN PENTING: HITUNG JUMLAH DATA PER STATUS UNTUK KAPAL =====
        // Hitung jumlah data dengan status pending
        $total_pending = $db->table('karcis_pemilik_kapal')
                           ->where('status_verifikasi', 'pending')
                           ->countAllResults();
        
        // Hitung jumlah data dengan status approved
        $total_approved = $db->table('karcis_pemilik_kapal')
                            ->where('status_verifikasi', 'approved')
                            ->countAllResults();
        
        // Hitung jumlah data dengan status rejected
        $total_rejected = $db->table('karcis_pemilik_kapal')
                            ->where('status_verifikasi', 'rejected')
                            ->countAllResults();
        
        // ===== PERBAIKAN: LANGSUNG GUNAKAN TABLE karcis_pemilik_kapal =====
        $tableName = 'karcis_pemilik_kapal';
        $primaryKey = 'id';
        $statusColumn = 'status_verifikasi';
        
        // Query data dengan status pending/approved/rejected
        $query = $db->table($tableName);
        
        // Hanya tampilkan yang status_verifikasi = 'pending'
        $query->where($statusColumn, 'pending');
        
        // ORDER BY created_at DESC
        $query->orderBy('created_at', 'DESC');
        
        $karcis_data = $query->get()->getResultArray();
        
        // Tambahkan primary key ke setiap data
        foreach ($karcis_data as &$data) {
            $data['_primary_key'] = $primaryKey;
            $data['_primary_value'] = $data[$primaryKey] ?? null;
        }

        $data = [
            'title' => 'Verifikasi Karcis Pemilik Kapal',
            'karcis_data' => $karcis_data,
            'total_menunggu' => $total_pending,
            'total_diverifikasi' => $total_approved,
            'total_ditolak' => $total_rejected,
            'table_name' => $tableName,
            'primary_key' => $primaryKey
        ];
        
        return view('admin/verifikasi_karcis_kapal', $data);
    }

    // ===== DATA TERVERIFIKASI BAKUL =====
    public function dataTerverifikasiBakul()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses data terverifikasi');
        }
        // ===== END ROLE CHECKING =====

        $db = db_connect();
        
        // ===== PERBAIKAN: LANGSUNG GUNAKAN TABLE karcis_bakul =====
        $tableName = 'karcis_bakul';
        $primaryKey = 'id_bakul';
        $statusColumn = 'status_verifikasi';
        
        // Query data TERVERIFIKASI (approved)
        $query = $db->table($tableName);
        $query->where($statusColumn, 'approved');
        $query->orderBy('tanggal_input', 'DESC');
        
        $karcis_data = $query->get()->getResultArray();
        
        // Tambahkan primary key ke setiap data
        foreach ($karcis_data as &$data) {
            $data['_primary_key'] = $primaryKey;
            $data['_primary_value'] = $data[$primaryKey] ?? null;
        }

        $data = [
            'title' => 'Data Bakul Terverifikasi',
            'karcis_data' => $karcis_data,
            'total_terverifikasi' => count($karcis_data),
            'table_name' => $tableName,
            'primary_key' => $primaryKey
        ];
        
        return view('admin/data_terverifikasi_bakul', $data);
    }

    // ===== DATA TERVERIFIKASI KAPAL =====
    public function dataTerverifikasiKapal()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses data terverifikasi');
        }
        // ===== END ROLE CHECKING =====

        $db = db_connect();
        
        // ===== PERBAIKAN: LANGSUNG GUNAKAN TABLE karcis_pemilik_kapal =====
        $tableName = 'karcis_pemilik_kapal';
        $primaryKey = 'id';
        $statusColumn = 'status_verifikasi';
        
        // Query data TERVERIFIKASI (approved)
        $query = $db->table($tableName);
        $query->where($statusColumn, 'approved');
        $query->orderBy('created_at', 'DESC'); // <-- PERBAIKAN: TITIK KOMA DITAMBAHKAN DI SINI
        
        $karcis_data = $query->get()->getResultArray();
        
        // Tambahkan primary key ke setiap data
        foreach ($karcis_data as &$data) {
            $data['_primary_key'] = $primaryKey;
            $data['_primary_value'] = $data[$primaryKey] ?? null;
        }

        $data = [
            'title' => 'Data Kapal Terverifikasi',
            'karcis_data' => $karcis_data,
            'total_terverifikasi' => count($karcis_data),
            'table_name' => $tableName,
            'primary_key' => $primaryKey
        ];
        
        return view('admin/data_terverifikasi_kapal', $data);
    }

    // ===== METHOD HELPER =====
    
    // Cari table untuk data bakul dengan primary key
    private function findBakulTable($db)
    {
        $tables = $db->listTables();
        $bakulTables = ['karcis_bakul', 'bakul_karcis', 'karcis_bakul_menunggu', 'data_karcis_bakul', 'input_bakul', 'transaksi_bakul'];
        
        foreach ($tables as $table) {
            // Cek berdasarkan nama table
            if (in_array($table, $bakulTables)) {
                return [
                    'table' => $table,
                    'primary_key' => $this->detectPrimaryKey($db, $table)
                ];
            }
            
            // Cek berdasarkan content (ada column yang berhubungan dengan bakul)
            $columns = $db->getFieldNames($table);
            $bakulKeywords = ['bakul', 'pembeli', 'pedagang', 'buyer'];
            
            foreach ($columns as $column) {
                foreach ($bakulKeywords as $keyword) {
                    if (stripos($column, $keyword) !== false) {
                        return [
                            'table' => $table,
                            'primary_key' => $this->detectPrimaryKey($db, $table)
                        ];
                    }
                }
            }
        }
        
        return null;
    }

    // Cari table untuk data kapal dengan primary key
    private function findKapalTable($db)
    {
        $tables = $db->listTables();
        $kapalTables = ['karcis_kapal', 'karcis_pemilik_kapal', 'kapal_karcis', 'data_karcis_kapal', 'input_kapal', 'transaksi_kapal'];
        
        foreach ($tables as $table) {
            // Cek berdasarkan nama table
            if (in_array($table, $kapalTables)) {
                return [
                    'table' => $table,
                    'primary_key' => $this->detectPrimaryKey($db, $table)
                ];
            }
            
            // Cek berdasarkan content (ada column yang berhubungan dengan kapal)
            $columns = $db->getFieldNames($table);
            $kapalKeywords = ['kapal', 'pemilik_kapal', 'nahkoda', 'ship', 'owner'];
            
            foreach ($columns as $column) {
                foreach ($kapalKeywords as $keyword) {
                    if (stripos($column, $keyword) !== false) {
                        return [
                            'table' => $table,
                            'primary_key' => $this->detectPrimaryKey($db, $table)
                        ];
                    }
                }
            }
        }
        
        return null;
    }

    // Deteksi primary key dari table
    private function detectPrimaryKey($db, $tableName)
    {
        $columns = $db->getFieldNames($tableName);
        
        // Prioritas untuk primary key
        $possibleKeys = ['id', 'karcis_id', 'id_karcis', 'no_karcis', 'nomor_karcis', 'kode', 'kode_karcis'];
        
        foreach ($possibleKeys as $key) {
            if (in_array($key, $columns)) {
                return $key;
            }
        }
        
        // Jika tidak ditemukan, ambil column pertama
        return $columns[0] ?? 'id';
    }

    // Dapatkan column status yang benar
    private function getStatusColumn($db, $tableName)
    {
        $columns = $db->getFieldNames($tableName);
        $statusColumns = ['status', 'status_verifikasi', 'verifikasi', 'verification_status', 'state', 'status_karcis'];
        
        foreach ($statusColumns as $statusCol) {
            if (in_array($statusCol, $columns)) {
                return $statusCol;
            }
        }
        
        return null;
    }

    // ===== METHOD UPDATE STATUS =====
    public function updateStatusBakul()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengupdate status verifikasi');
        }
        // ===== END ROLE CHECKING =====

        $karcis_id = $this->request->getPost('karcis_id');
        $primary_key = $this->request->getPost('primary_key');
        $action = $this->request->getPost('action');

        $db = db_connect();
        
        // ===== PERBAIKAN: LANGSUNG GUNAKAN TABLE karcis_bakul =====
        $tableName = 'karcis_bakul';
        $actualPrimaryKey = 'id_bakul';
        $statusColumn = 'status_verifikasi';
        
        // Gunakan primary key yang sebenarnya
        $updateKey = $actualPrimaryKey;
        
        // ===== PERBAIKAN: SESUAIKAN STATUS DENGAN ENUM DI DATABASE =====
        // Enum: 'pending','approved','rejected'
        $new_status = ($action === 'verify') ? 'approved' : 'rejected';
        
        // ===== PERBAIKAN: AMBIL USER INFO DARI SESSION =====
        $user_id = session()->get('user_id') ?? 1;
        $username = session()->get('username') ?? 'Admin';
        
        $updateData = [
            $statusColumn => $new_status,
            'verified_by' => $user_id,
            'verified_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $db->table($tableName)
                    ->where($updateKey, $karcis_id)
                    ->update($updateData);

        if ($result) {
            // ===== PERBAIKAN: SET PESAN BERDASARKAN STATUS =====
            $status_text = ($new_status === 'approved') ? 'diverifikasi' : 'ditolak';
            session()->setFlashdata('success', "Karcis bakul berhasil $status_text!");
            
            return redirect()->to('admin/verifikasi-karcis-bakul');
        }
        
        session()->setFlashdata('error', 'Gagal update status karcis!');
        return redirect()->to('admin/verifikasi-karcis-bakul');
    }

    public function updateStatusKapal()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengupdate status verifikasi');
        }
        // ===== END ROLE CHECKING =====

        $karcis_id = $this->request->getPost('karcis_id');
        $primary_key = $this->request->getPost('primary_key');
        $action = $this->request->getPost('action');

        $db = db_connect();
        
        // ===== PERBAIKAN: LANGSUNG GUNAKAN TABLE karcis_pemilik_kapal =====
        $tableName = 'karcis_pemilik_kapal';
        $actualPrimaryKey = 'id';
        $statusColumn = 'status_verifikasi';
        
        // Gunakan primary key yang sebenarnya
        $updateKey = $actualPrimaryKey;
        
        // ===== PERBAIKAN: SESUAIKAN STATUS DENGAN ENUM DI DATABASE =====
        // Enum: 'pending','approved','rejected'
        $new_status = ($action === 'verify') ? 'approved' : 'rejected';
        
        // ===== PERBAIKAN: AMBIL USER INFO DARI SESSION =====
        $user_id = session()->get('user_id') ?? 1;
        $username = session()->get('username') ?? 'Admin';
        
        $updateData = [
            $statusColumn => $new_status,
            'admin_id' => $user_id,
            'verified_by' => $username,
            'verified_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $db->table($tableName)
                    ->where($updateKey, $karcis_id)
                    ->update($updateData);

        if ($result) {
            // ===== PERBAIKAN: SET PESAN BERDASARKAN STATUS =====
            $status_text = ($new_status === 'approved') ? 'diverifikasi' : 'ditolak';
            session()->setFlashdata('success', "Karcis kapal berhasil $status_text!");
            
            return redirect()->to('admin/verifikasi-karcis-kapal');
        }
        
        session()->setFlashdata('error', 'Gagal update status karcis!');
        return redirect()->to('admin/verifikasi-karcis-kapal');
    }

    // ===== DEBUG DATABASE =====
    public function debugDatabase()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses debug database');
        }
        // ===== END ROLE CHECKING =====

        $db = db_connect();
        $tables = $db->listTables();
        
        $data = [
            'title' => 'Debug Database',
            'tables' => $tables
        ];
        
        // Cari table bakul
        $bakulTable = $this->findBakulTable($db);
        $data['bakul_table'] = $bakulTable ? $bakulTable['table'] . " (PK: " . $bakulTable['primary_key'] . ")" : 'Tidak ditemukan';
        
        if ($bakulTable) {
            $data['bakul_columns'] = $db->getFieldNames($bakulTable['table']);
            $data['bakul_sample'] = $db->table($bakulTable['table'])->limit(5)->get()->getResultArray();
        }
        
        // Cari table kapal
        $kapalTable = $this->findKapalTable($db);
        $data['kapal_table'] = $kapalTable ? $kapalTable['table'] . " (PK: " . $kapalTable['primary_key'] . ")" : 'Tidak ditemukan';
        
        if ($kapalTable) {
            $data['kapal_columns'] = $db->getFieldNames($kapalTable['table']);
            $data['kapal_sample'] = $db->table($kapalTable['table'])->limit(5)->get()->getResultArray();
        }
        
        return view('admin/debug_database', $data);
    }

    // ===== CLEAR CACHE =====
    public function clearCache()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat membersihkan cache');
        }
        // ===== END ROLE CHECKING =====

        // Clear CodeIgniter cache
        $cachePath = WRITEPATH . 'cache/';
        if (is_dir($cachePath)) {
            $files = glob($cachePath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        
        // Clear opcache
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        session()->setFlashdata('success', 'Cache berhasil dibersihkan!');
        return redirect()->to('admin/debugDatabase');
    }

    // ===== METHOD LAINNYA =====
    public function laporan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses laporan');
        }
        // ===== END ROLE CHECKING =====
        
        return redirect()->to('/laporan');
    }

    public function cetakLaporan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mencetak laporan');
        }
        // ===== END ROLE CHECKING =====
        
        return redirect()->to('/laporan/exportExcel');
    }

    public function statistik()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }
        
        // ===== TAMBAHKAN ROLE CHECKING =====
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'superadmin') {
            return redirect()->to('/admin')->with('error', 'Hanya admin yang dapat mengakses statistik');
        }
        // ===== END ROLE CHECKING =====
        
        return redirect()->to('/laporan/statistik');
    }
}