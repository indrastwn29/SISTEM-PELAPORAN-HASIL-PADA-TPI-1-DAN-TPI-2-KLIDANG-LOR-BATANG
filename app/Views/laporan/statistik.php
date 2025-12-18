<?php
$title = 'Statistik - Sistem Lelang Ikan TPI';
$nama_lengkap = session()->get('nama_lengkap') ?? 'Administrator';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #3498DB;
            --accent-color: #FF7F50;
            --warning-color: #F39C12;
            --danger-color: #E74C3C;
            --success-color: #27AE60;
            --info-color: #3498DB;
            --light-color: #F8F9FA;
            --dark-color: #2C3E50;
            --gray-light: #ECF0F1;
            --gray-medium: #95A5A6;
            --gray-dark: #7F8C8D;
            --blue-light: #E3F2FD;
            --blue-medium: #3498DB;
            --blue-dark: #2980B9;
            --shadow-sm: 0 2px 8px rgba(44, 62, 80, 0.08);
            --shadow-md: 0 4px 16px rgba(44, 62, 80, 0.12);
            --shadow-lg: 0 8px 30px rgba(44, 62, 80, 0.15);
            --gradient-primary: linear-gradient(135deg, #2C3E50 0%, #3498DB 100%);
            --gradient-secondary: linear-gradient(135deg, #3498DB 0%, #2980B9 100%);
            --gradient-warning: linear-gradient(135deg, #F39C12 0%, #F1C40F 100%);
            --gradient-success: linear-gradient(135deg, #27AE60 0%, #2ECC71 100%);
            --gradient-danger: linear-gradient(135deg, #E74C3C 0%, #C0392B 100%);
        }
        
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #ecf0f1 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }
        
        /* NAVBAR STICKY */
        .glass-navbar {
            background: rgba(44, 62, 80, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }
        
        .navbar-scrolled {
            background: rgba(44, 62, 80, 0.98) !important;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Sidebar Modern */
        .sidebar-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(236, 240, 241, 0.8);
            box-shadow: 5px 0 25px rgba(44, 62, 80, 0.05);
            height: calc(100vh - 80px);
            position: sticky;
            top: 80px;
            z-index: 1020;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-modern::-webkit-scrollbar {
            display: none;
        }
        
        .sidebar-modern {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .nav-item-modern {
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: #2C3E50;
        }
        
        .nav-item-modern:hover {
            background: rgba(52, 152, 219, 0.1);
            transform: translateX(5px);
            color: #2980B9;
        }
        
        .nav-item-modern.active {
            background: var(--gradient-primary);
            color: white !important;
            box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
        }
        
        /* Button Modern */
        .btn-modern {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            border: 2px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-modern-primary {
            background: var(--gradient-primary);
            color: white;
        }
        
        .btn-modern-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(44, 62, 80, 0.3);
            color: white;
            background: var(--gradient-secondary);
        }
        
        .btn-modern-outline {
            background: transparent;
            border: 2px solid var(--blue-medium);
            color: var(--blue-medium);
        }
        
        .btn-modern-outline:hover {
            background: var(--gradient-secondary);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border-left: 4px solid #3498DB;
            height: 100%;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .stats-icon-primary {
            background: rgba(52, 152, 219, 0.1);
            color: #3498DB;
        }
        
        .stats-icon-success {
            background: rgba(39, 174, 96, 0.1);
            color: #27AE60;
        }
        
        .stats-icon-warning {
            background: rgba(243, 156, 18, 0.1);
            color: #F39C12;
        }
        
        .stats-icon-danger {
            background: rgba(231, 76, 60, 0.1);
            color: #E74C3C;
        }
        
        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            height: 100%;
            margin-bottom: 20px;
        }
        
        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            margin-bottom: 20px;
        }
        
        /* Tabs Styling */
        .nav-tabs-custom {
            border-bottom: 2px solid #ECF0F1;
        }
        
        .nav-tabs-custom .nav-link {
            border: none;
            color: #7F8C8D;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 10px 10px 0 0;
            margin-right: 5px;
        }
        
        .nav-tabs-custom .nav-link:hover {
            color: #3498DB;
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .nav-tabs-custom .nav-link.active {
            color: #3498DB;
            background-color: rgba(52, 152, 219, 0.1);
            border-bottom: 3px solid #3498DB;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar-modern {
                height: auto;
                position: static;
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .glass-card {
                border-radius: 15px;
            }
            
            .stats-card {
                padding: 15px;
            }
            
            .nav-tabs-custom .nav-link {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
        
        /* HIDE SCROLLBARS */
        ::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        
        * {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>
</head>
<body>
    <!-- Navigation - STICKY NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark glass-navbar py-3" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('/admin') ?>">
                <div class="fish-icon me-3">
                    <i class="fas fa-fish" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <div class="fs-5">SISTEM LELANG IKAN TPI</div>
                    <small class="opacity-75">Administrator Dashboard</small>
                </div>
            </a>
            
            <div class="d-flex align-items-center">
                <!-- User Profile -->
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-modern-outline d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="bg-white rounded-circle p-2 me-2">
                            <i class="fas fa-user" style="color: #3498DB;"></i>
                        </div>
                        <div class="text-start d-none d-md-block">
                            <div class="fw-bold"><?= $nama_lengkap ?></div>
                            <small>Administrator</small>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= site_url('/auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 mb-4">
                <div class="sidebar-modern glass-card p-3">
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url('/admin') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-tachometer-alt me-3"></i>
                            <span>Dashboard</span>
                        </a>
                        
                        <!-- Input Karcis Menu (DROPDOWN) -->
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 dropdown-toggle" 
                               data-bs-toggle="dropdown">
                                <i class="fas fa-plus-circle me-3"></i>
                                <span>Input Karcis</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('admin/input-karcis-bakul') ?>">
                                        <i class="fas fa-users me-2"></i> Input Karcis Bakul
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('admin/input-karcis-kapal') ?>">
                                        <i class="fas fa-ship me-2"></i> Input Karcis Kapal
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Verifikasi Bakul -->
                        <a href="<?= site_url('admin/verifikasi-karcis-bakul') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-users me-3"></i>
                            <span>Verifikasi Bakul</span>
                            <span class="badge bg-danger float-end">5</span>
                        </a>
                        
                        <!-- Verifikasi Kapal -->
                        <a href="<?= site_url('admin/verifikasi-karcis-kapal') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-ship me-3"></i>
                            <span>Verifikasi Kapal</span>
                            <span class="badge bg-warning float-end">3</span>
                        </a>
                        
                        <!-- Data Terverifikasi (DROPDOWN) -->
                        <div class="dropdown">
                            <a href="#" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 dropdown-toggle" 
                               data-bs-toggle="dropdown">
                                <i class="fas fa-check-circle me-3"></i>
                                <span>Data Terverifikasi</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('admin/data-terverifikasi-bakul') ?>">
                                        <i class="fas fa-users me-2"></i> Bakul Terverifikasi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('admin/data-terverifikasi-kapal') ?>">
                                        <i class="fas fa-ship me-2"></i> Kapal Terverifikasi
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Laporan & Statistik -->
                        <a href="<?= site_url('/laporan') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-chart-bar me-3"></i>
                            <span>Laporan</span>
                        </a>
                        
                        <!-- Statistik -->
                        <a href="<?= site_url('/laporan/statistik') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 active">
                            <i class="fas fa-chart-line me-3"></i>
                            <span>Statistik</span>
                        </a>
                        
                        <!-- Debug System -->
                        <a href="<?= site_url('/admin/debugDatabase') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-bug me-3"></i>
                            <span>Debug System</span>
                        </a>
                        
                        <!-- Pengaturan -->
                        <a href="<?= site_url('/admin/pengaturan') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-cog me-3"></i>
                            <span>Pengaturan</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="fw-bold mb-2" style="color: #2C3E50;">
                            <i class="fas fa-chart-line me-3" style="color: #3498DB;"></i>
                            STATISTIK LELANG IKAN
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2" style="color: #3498DB;"></i>
                            Analisis statistik dan visualisasi data transaksi
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('/laporan') ?>" class="btn btn-modern btn-modern-outline">
                            <i class="fas fa-arrow-left"></i>
                            <span class="d-none d-md-inline">Kembali ke Laporan</span>
                        </a>
                        <button class="btn btn-modern btn-modern-primary" onclick="downloadCharts()">
                            <i class="fas fa-download"></i>
                            <span class="d-none d-md-inline">Download Statistik</span>
                        </button>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-card">
                    <h5 class="fw-bold mb-3" style="color: #2C3E50;">
                        <i class="fas fa-filter me-2"></i>
                        Filter Statistik
                    </h5>
                    <form id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tahun</label>
                                <select class="form-control form-control-modern" name="tahun" id="tahun">
                                    <?php 
                                    $currentYear = date('Y');
                                    for($i = $currentYear; $i >= 2020; $i--): 
                                    ?>
                                        <option value="<?= $i ?>" <?= $i == $currentYear ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Bulan</label>
                                <select class="form-control form-control-modern" name="bulan" id="bulan">
                                    <option value="all">Semua Bulan</option>
                                    <?php 
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    $currentMonth = date('n');
                                    foreach($months as $key => $month): 
                                    ?>
                                        <option value="<?= $key ?>" <?= $key == $currentMonth ? 'selected' : '' ?>><?= $month ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Jenis Ikan</label>
                                <select class="form-control form-control-modern" name="jenis_ikan" id="jenis_ikan">
                                    <option value="all">Semua Jenis</option>
                                    <option value="Tongkol">Tongkol</option>
                                    <option value="Cakalang">Cakalang</option>
                                    <option value="Tuna">Tuna</option>
                                    <option value="Tenggiri">Tenggiri</option>
                                    <option value="Kakap">Kakap</option>
                                    <option value="Kerapu">Kerapu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold d-block">&nbsp;</label>
                                <button type="button" onclick="updateCharts()" class="btn btn-modern btn-modern-primary w-100">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-primary">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4 class="fw-bold mb-2" id="totalTransaksi">0</h4>
                            <p class="text-muted mb-0">Total Transaksi</p>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                <span id="growthTransaksi">0%</span> dari bulan lalu
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-success">
                                <i class="fas fa-weight"></i>
                            </div>
                            <h4 class="fw-bold mb-2" id="totalBerat">0 kg</h4>
                            <p class="text-muted mb-0">Total Berat Ikan</p>
                            <small class="text-info">
                                <i class="fas fa-balance-scale me-1"></i>
                                Rata-rata <span id="avgBerat">0</span> kg/transaksi
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-danger">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h4 class="fw-bold mb-2" id="totalNilai">Rp 0</h4>
                            <p class="text-muted mb-0">Total Nilai Transaksi</p>
                            <small class="text-danger">
                                <i class="fas fa-chart-line me-1"></i>
                                Rata-rata <span id="avgNilai">Rp 0</span>/transaksi
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-warning">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="fw-bold mb-2" id="totalAgen">0</h4>
                            <p class="text-muted mb-0">Total Agen Aktif</p>
                            <small class="text-warning">
                                <i class="fas fa-user-check me-1"></i>
                                <span id="activeAgen">0</span> agen aktif
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="statistikTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-trend">
                            <i class="fas fa-chart-line me-2"></i>
                            Trend Bulanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-distribusi">
                            <i class="fas fa-chart-pie me-2"></i>
                            Distribusi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-perbandingan">
                            <i class="fas fa-balance-scale me-2"></i>
                            Perbandingan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-prediksi">
                            <i class="fas fa-crystal-ball me-2"></i>
                            Prediksi
                        </a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content">
                    <!-- Tab 1: Trend Bulanan -->
                    <div class="tab-pane fade show active" id="tab-trend">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Trend Transaksi Bulanan</h6>
                                    <canvas id="lineChartMonthly"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Status Transaksi</h6>
                                    <canvas id="doughnutChartStatus"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Perbandingan Bakul vs Kapal</h6>
                                    <canvas id="barChartComparison"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Distribusi -->
                    <div class="tab-pane fade" id="tab-distribusi">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Distribusi Jenis Ikan</h6>
                                    <canvas id="pieChartJenisIkan"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Distribusi Berdasarkan Harga</h6>
                                    <canvas id="barChartHarga"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Distribusi Waktu Transaksi</h6>
                                    <canvas id="lineChartTime"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Perbandingan -->
                    <div class="tab-pane fade" id="tab-perbandingan">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Perbandingan Tahun <?= date('Y')-1 ?> vs <?= date('Y') ?></h6>
                                    <canvas id="barChartYearComparison"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Perbandingan Harga per Jenis Ikan</h6>
                                    <canvas id="radarChartPrice"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Perbandingan Rata-rata Berat</h6>
                                    <canvas id="barChartWeight"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Prediksi -->
                    <div class="tab-pane fade" id="tab-prediksi">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Prediksi Transaksi 3 Bulan Ke Depan</h6>
                                    <canvas id="lineChartPrediction"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="fw-bold mb-3">Analisis Musiman</h6>
                                    <canvas id="barChartSeasonal"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="glass-card p-4">
                                    <h6 class="fw-bold mb-3">Rekomendasi Berdasarkan Analisis</h6>
                                    <div class="alert alert-info">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        <strong>Insight:</strong> Trend menunjukkan peningkatan transaksi sebesar 15% pada bulan depan
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Waktu terbaik untuk beli ikan Tongkol</span>
                                            <span class="badge bg-primary">Pagi Hari</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Harga terbaik untuk ikan Tuna</span>
                                            <span class="badge bg-success">Rp 45.000/kg</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Prediksi kenaikan harga Cakalang</span>
                                            <span class="badge bg-warning">+12%</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Jenis ikan paling diminati</span>
                                            <span class="badge bg-danger">Tongkol</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-3 text-center" style="background: rgba(44, 62, 80, 0.05);">
        <div class="container">
            <small class="text-muted">
                &copy; <?= date('Y') ?> Sistem Lelang Ikan TPI - 
                <span class="text-primary">Statistik Dashboard v1.0</span> | 
                Data terupdate: <?= date('d/m/Y H:i:s') ?>
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script>
        // Generate random data untuk demo
        function generateMonthlyData() {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const data = {
                transactions: [],
                weight: [],
                value: []
            };
            
            for (let i = 0; i < 12; i++) {
                data.transactions.push(Math.floor(Math.random() * 50) + 30);
                data.weight.push(Math.floor(Math.random() * 10000) + 5000);
                data.value.push(Math.floor(Math.random() * 300000000) + 150000000);
            }
            
            return { months, data };
        }
        
        function generateFishDistribution() {
            const fishTypes = ['Tongkol', 'Cakalang', 'Tuna', 'Tenggiri', 'Kakap', 'Kerapu', 'Lainnya'];
            const distribution = [];
            
            for (let i = 0; i < fishTypes.length; i++) {
                distribution.push(Math.floor(Math.random() * 30) + 10);
            }
            
            // Normalize to 100%
            const total = distribution.reduce((a, b) => a + b, 0);
            return distribution.map(val => Math.round((val / total) * 100));
        }
        
        function generateStatusData() {
            return {
                verified: Math.floor(Math.random() * 70) + 20,
                pending: Math.floor(Math.random() * 20) + 5,
                rejected: Math.floor(Math.random() * 10) + 1
            };
        }
        
        function generatePriceRangeData() {
            const ranges = ['< 20k', '20k-40k', '40k-60k', '60k-80k', '> 80k'];
            const data = [];
            
            for (let i = 0; i < ranges.length; i++) {
                data.push(Math.floor(Math.random() * 40) + 10);
            }
            
            return data;
        }
        
        // Initialize charts
        let lineChartMonthly, doughnutChartStatus, barChartComparison, pieChartJenisIkan;
        let barChartHarga, lineChartTime, barChartYearComparison, radarChartPrice;
        let barChartWeight, lineChartPrediction, barChartSeasonal;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Update stats cards
            updateStatsCards();
            
            // Initialize all charts
            initializeCharts();
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('mainNavbar');
                if (navbar) {
                    if (window.scrollY > 50) {
                        navbar.classList.add('navbar-scrolled');
                    } else {
                        navbar.classList.remove('navbar-scrolled');
                    }
                }
            });
        });
        
        function updateStatsCards() {
            // Update stats cards with demo data
            document.getElementById('totalTransaksi').textContent = '1,250';
            document.getElementById('growthTransaksi').textContent = '15.2%';
            document.getElementById('totalBerat').textContent = '45,250.75 kg';
            document.getElementById('avgBerat').textContent = '36.2 kg';
            document.getElementById('totalNilai').textContent = 'Rp 3.25 M';
            document.getElementById('avgNilai').textContent = 'Rp 2.6 jt';
            document.getElementById('totalAgen').textContent = '185';
            document.getElementById('activeAgen').textContent = '152';
        }
        
        function initializeCharts() {
            const { months, data } = generateMonthlyData();
            const fishDistribution = generateFishDistribution();
            const statusData = generateStatusData();
            const priceRangeData = generatePriceRangeData();
            
            // 1. Line Chart - Monthly Trend
            const lineMonthlyCtx = document.getElementById('lineChartMonthly');
            if (lineMonthlyCtx) {
                lineChartMonthly = new Chart(lineMonthlyCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Jumlah Transaksi',
                                data: data.transactions,
                                borderColor: '#3498DB',
                                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Total Nilai (Miliar Rp)',
                                data: data.value.map(v => v / 1000000000),
                                borderColor: '#2ECC71',
                                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // 2. Doughnut Chart - Status
            const doughnutStatusCtx = document.getElementById('doughnutChartStatus');
            if (doughnutStatusCtx) {
                doughnutChartStatus = new Chart(doughnutStatusCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Diverifikasi', 'Menunggu', 'Ditolak'],
                        datasets: [{
                            data: [statusData.verified, statusData.pending, statusData.rejected],
                            backgroundColor: ['#2ECC71', '#F39C12', '#E74C3C'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
            
            // 3. Bar Chart - Comparison
            const barComparisonCtx = document.getElementById('barChartComparison');
            if (barComparisonCtx) {
                barChartComparison = new Chart(barComparisonCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: months.slice(0, 6),
                        datasets: [
                            {
                                label: 'Bakul',
                                data: months.slice(0, 6).map(() => Math.floor(Math.random() * 30) + 15),
                                backgroundColor: '#3498DB',
                                borderWidth: 1
                            },
                            {
                                label: 'Kapal',
                                data: months.slice(0, 6).map(() => Math.floor(Math.random() * 30) + 10),
                                backgroundColor: '#F39C12',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // 4. Pie Chart - Jenis Ikan
            const pieJenisCtx = document.getElementById('pieChartJenisIkan');
            if (pieJenisCtx) {
                pieChartJenisIkan = new Chart(pieJenisCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Tongkol', 'Cakalang', 'Tuna', 'Tenggiri', 'Kakap', 'Kerapu', 'Lainnya'],
                        datasets: [{
                            data: fishDistribution,
                            backgroundColor: [
                                '#3498DB', '#2ECC71', '#F39C12', '#E74C3C',
                                '#9B59B6', '#1ABC9C', '#95A5A6'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
            
            // 5. Bar Chart - Harga
            const barHargaCtx = document.getElementById('barChartHarga');
            if (barHargaCtx) {
                barChartHarga = new Chart(barHargaCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['< 20k', '20k-40k', '40k-60k', '60k-80k', '> 80k'],
                        datasets: [{
                            label: 'Jumlah Transaksi',
                            data: priceRangeData,
                            backgroundColor: '#9B59B6',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Initialize other charts as needed...
        }
        
        function updateCharts() {
            const tahun = document.getElementById('tahun').value;
            const bulan = document.getElementById('bulan').value;
            const jenisIkan = document.getElementById('jenis_ikan').value;
            
            // Show loading
            alert(`Memperbarui chart dengan filter:\nTahun: ${tahun}\nBulan: ${bulan}\nJenis Ikan: ${jenisIkan}`);
            
            // In real implementation, fetch new data from server
            // and update all charts
            
            // For demo, just update stats cards
            updateStatsCards();
        }
        
        function downloadCharts() {
            alert('Download statistik dalam format PDF akan diimplementasikan');
            // Implement download functionality
        }
    </script>
</body>
</html>