<?php
$title = 'Laporan & Statistik - Sistem Lelang Ikan TPI';
$nama_lengkap = session()->get('nama_lengkap') ?? 'Administrator';
$total_bakul = $total_bakul ?? 0;
$total_kapal = $total_kapal ?? 0;
$total_berat_bakul = $total_berat_bakul ?? 0;
$total_berat_pemilik = $total_berat_pemilik ?? 0;
$total_pembelian = $total_pembelian ?? 0;
$total_penjualan = $total_penjualan ?? 0;
$karcis_bakul = $karcis_bakul ?? [];
$karcis_pemilik = $karcis_pemilik ?? [];
$periode = $periode ?? 'harian';
$start_date = $start_date ?? date('Y-m-d');
$end_date = $end_date ?? date('Y-m-d');
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
        
        /* Table Styling */
        .table-modern {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .table-modern thead th {
            background: linear-gradient(135deg, #2C3E50, #34495E);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        
        .table-modern tbody tr {
            transition: all 0.3s ease;
        }
        
        .table-modern tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
            transform: translateX(5px);
        }
        
        .table-modern tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #ECF0F1;
        }
        
        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            margin-bottom: 20px;
        }
        
        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            height: 100%;
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
        
        /* Empty State */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #95A5A6;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
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
        
        /* Print Styles */
        @media print {
            .sidebar-modern, 
            .glass-navbar,
            .btn-modern,
            .nav-tabs-custom,
            .filter-card,
            #exportBtn {
                display: none !important;
            }
            
            body {
                background: white !important;
            }
            
            .glass-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
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
                <!-- Notification Bell -->
                <div class="notification-bell position-relative me-4">
                    <i class="fas fa-bell fs-5 text-white"></i>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                        <?= $total_bakul + $total_kapal ?>
                    </span>
                </div>
                
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
                        <a href="<?= site_url('/laporan') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 active">
                            <i class="fas fa-chart-bar me-3"></i>
                            <span>Laporan & Statistik</span>
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
                            <i class="fas fa-chart-bar me-3" style="color: #3498DB;"></i>
                            LAPORAN & STATISTIK
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2" style="color: #3498DB;"></i>
                            Analisis data dan laporan transaksi lelang ikan
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('laporan/statistik') ?>" class="btn btn-modern btn-modern-outline">
                            <i class="fas fa-chart-line"></i>
                            <span class="d-none d-md-inline">Lihat Statistik</span>
                        </a>
                        <button class="btn btn-modern btn-modern-outline" onclick="exportToExcel()" id="exportBtn">
                            <i class="fas fa-file-excel"></i>
                            <span class="d-none d-md-inline">Export Excel</span>
                        </button>
                        <button class="btn btn-modern btn-modern-primary" onclick="printPage()">
                            <i class="fas fa-print"></i>
                            <span class="d-none d-md-inline">Cetak Laporan</span>
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="fw-bold mb-2"><?= $total_bakul ?></h4>
                            <p class="text-muted mb-0">Total Bakul</p>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                <?= $total_bakul ?> data
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-warning">
                                <i class="fas fa-ship"></i>
                            </div>
                            <h4 class="fw-bold mb-2"><?= $total_kapal ?></h4>
                            <p class="text-muted mb-0">Total Kapal</p>
                            <small class="text-warning">
                                <i class="fas fa-anchor me-1"></i>
                                <?= $total_kapal ?> data
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-success">
                                <i class="fas fa-weight"></i>
                            </div>
                            <h4 class="fw-bold mb-2"><?= number_format($total_berat_bakul + $total_berat_pemilik, 1) ?></h4>
                            <p class="text-muted mb-0">Total Berat (Kg)</p>
                            <small class="text-info">
                                <i class="fas fa-balance-scale me-1"></i>
                                <?= number_format($total_berat_bakul, 1) ?> + <?= number_format($total_berat_pemilik, 1) ?> kg
                            </small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="stats-icon stats-icon-danger">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Rp <?= number_format($total_pembelian + $total_penjualan, 0, ',', '.') ?></h4>
                            <p class="text-muted mb-0">Total Transaksi</p>
                            <small class="text-danger">
                                <i class="fas fa-chart-line me-1"></i>
                                Rp <?= number_format($total_pembelian, 0, ',', '.') ?> + Rp <?= number_format($total_penjualan, 0, ',', '.') ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-card">
                    <h5 class="fw-bold mb-3" style="color: #2C3E50;">
                        <i class="fas fa-filter me-2"></i>
                        Filter Laporan
                    </h5>
                    <form id="filterForm" method="GET" action="<?= site_url('/laporan') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Periode</label>
                                <select class="form-control form-control-modern" name="periode" id="periode">
                                    <option value="harian" <?= $periode == 'harian' ? 'selected' : '' ?>>Harian</option>
                                    <option value="bulanan" <?= $periode == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                                    <option value="tahunan" <?= $periode == 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-modern" 
                                       name="start_date" id="start_date" 
                                       value="<?= $start_date ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Akhir</label>
                                <input type="date" class="form-control form-control-modern" 
                                       name="end_date" id="end_date" 
                                       value="<?= $end_date ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-modern btn-modern-primary w-100">
                                    <i class="fas fa-search me-2"></i>
                                    Tampilkan Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="laporanTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-bakul">
                            <i class="fas fa-users me-2"></i>
                            Laporan Bakul
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-kapal">
                            <i class="fas fa-ship me-2"></i>
                            Laporan Kapal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-ringkasan">
                            <i class="fas fa-chart-pie me-2"></i>
                            Ringkasan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-statistik">
                            <i class="fas fa-chart-line me-2"></i>
                            Statistik
                        </a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content">
                    <!-- Tab 1: Laporan Bakul -->
                    <div class="tab-pane fade show active" id="tab-bakul">
                        <div class="glass-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                                    <i class="fas fa-users me-2 text-primary"></i>
                                    Laporan Karcis Bakul
                                    <span class="badge bg-primary ms-2"><?= count($karcis_bakul) ?> Data</span>
                                </h5>
                                <div class="text-muted">
                                    Periode: <?= $periode === 'harian' ? 'Harian' : ($periode === 'bulanan' ? 'Bulanan' : 'Tahunan') ?> 
                                    <?= $start_date ?> s/d <?= $end_date ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($karcis_bakul)): ?>
                                <div class="table-responsive">
                                    <table class="table table-modern">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Nomor Karcis</th>
                                                <th>Nama Bakul</th>
                                                <th>Jenis Ikan</th>
                                                <th>Berat (kg)</th>
                                                <th>Harga/Kg</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1; 
                                            $total_berat_bakul_tab = 0; 
                                            $total_pembelian_tab = 0;
                                            ?>
                                            <?php foreach ($karcis_bakul as $kb): ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td>
                                                    <span class="badge bg-info bg-opacity-10 text-info">
                                                        <?= $kb['nomor_karcis'] ?? $kb['no_karcis'] ?? 'N/A' ?>
                                                    </span>
                                                </td>
                                                <td><?= $kb['nama_bakul'] ?? $kb['nama_pedagang'] ?? 'N/A' ?></td>
                                                <td>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                        <?= $kb['jenis_ikan'] ?? 'N/A' ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <strong><?= number_format($kb['berat_ikan'] ?? $kb['berat'] ?? 0, 2) ?></strong> kg
                                                </td>
                                                <td class="text-end">
                                                    Rp <?= number_format($kb['harga_per_kg'] ?? 0, 0, ',', '.') ?>
                                                </td>
                                                <td class="text-end">
                                                    <strong class="text-success">
                                                        Rp <?= number_format($kb['total'] ?? $kb['total_harga'] ?? 0, 0, ',', '.') ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $status = $kb['status'] ?? 'menunggu';
                                                    $badge_class = ($status == 'diverifikasi') ? 'bg-success' : 
                                                                  (($status == 'ditolak') ? 'bg-danger' : 'bg-warning');
                                                    ?>
                                                    <span class="badge <?= $badge_class ?>">
                                                        <?= ucfirst($status) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?= isset($kb['tanggal']) ? date('d/m/Y', strtotime($kb['tanggal'])) : 
                                                       (isset($kb['created_at']) ? date('d/m/Y', strtotime($kb['created_at'])) : 'N/A') ?>
                                                </td>
                                            </tr>
                                            <?php 
                                                $total_berat_bakul_tab += $kb['berat_ikan'] ?? $kb['berat'] ?? 0;
                                                $total_pembelian_tab += $kb['total'] ?? $kb['total_harga'] ?? 0;
                                            ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="4" class="text-end">TOTAL</th>
                                                <th class="text-end">
                                                    <strong><?= number_format($total_berat_bakul_tab, 2) ?> kg</strong>
                                                </th>
                                                <th colspan="2" class="text-end">
                                                    <strong class="text-success">
                                                        Rp <?= number_format($total_pembelian_tab, 0, ',', '.') ?>
                                                    </strong>
                                                </th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h4 class="text-muted mb-3">Tidak ada data karcis bakul</h4>
                                    <p class="text-muted mb-4">Data karcis bakul akan muncul di sini setelah diinput dan diverifikasi</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab 2: Laporan Kapal -->
                    <div class="tab-pane fade" id="tab-kapal">
                        <div class="glass-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                                    <i class="fas fa-ship me-2 text-warning"></i>
                                    Laporan Karcis Kapal
                                    <span class="badge bg-warning ms-2"><?= count($karcis_pemilik) ?> Data</span>
                                </h5>
                                <div class="text-muted">
                                    Periode: <?= $periode === 'harian' ? 'Harian' : ($periode === 'bulanan' ? 'Bulanan' : 'Tahunan') ?> 
                                    <?= $start_date ?> s/d <?= $end_date ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($karcis_pemilik)): ?>
                                <div class="table-responsive">
                                    <table class="table table-modern">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Nomor Karcis</th>
                                                <th>Nama Kapal/Nelayan</th>
                                                <th>Jenis Ikan</th>
                                                <th>Berat (kg)</th>
                                                <th>Daerah Tangkapan</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Tanggal Datang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1; 
                                            $total_berat_pemilik_tab = 0; 
                                            $total_penjualan_tab = 0;
                                            ?>
                                            <?php foreach ($karcis_pemilik as $kp): ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td>
                                                    <span class="badge bg-info bg-opacity-10 text-info">
                                                        <?= $kp['nomor_karcis'] ?? $kp['no_karcis'] ?? 'N/A' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-ship me-2 text-primary"></i>
                                                    <?= $kp['nama_nelayan'] ?? $kp['nama_kapal'] ?? 'N/A' ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                        <?= $kp['jenis_ikan'] ?? 'N/A' ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <strong><?= number_format($kp['berat_ikan'] ?? $kp['berat'] ?? 0, 2) ?></strong> kg
                                                </td>
                                                <td><?= $kp['daerah_tangkapan'] ?? 'Tidak diketahui' ?></td>
                                                <td class="text-end">
                                                    <strong class="text-success">
                                                        Rp <?= number_format($kp['total'] ?? $kp['total_harga'] ?? 0, 0, ',', '.') ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $status = $kp['status'] ?? 'menunggu';
                                                    $badge_class = ($status == 'diverifikasi') ? 'bg-success' : 
                                                                  (($status == 'ditolak') ? 'bg-danger' : 'bg-warning');
                                                    ?>
                                                    <span class="badge <?= $badge_class ?>">
                                                        <?= ucfirst($status) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?= isset($kp['tanggal_datang']) ? date('d/m/Y', strtotime($kp['tanggal_datang'])) : 
                                                       (isset($kp['created_at']) ? date('d/m/Y', strtotime($kp['created_at'])) : 'N/A') ?>
                                                </td>
                                            </tr>
                                            <?php 
                                                $total_berat_pemilik_tab += $kp['berat_ikan'] ?? $kp['berat'] ?? 0;
                                                $total_penjualan_tab += $kp['total'] ?? $kp['total_harga'] ?? 0;
                                            ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th colspan="5" class="text-end">TOTAL</th>
                                                <th class="text-end">
                                                    <strong><?= number_format($total_berat_pemilik_tab, 2) ?> kg</strong>
                                                </th>
                                                <th class="text-end">
                                                    <strong class="text-success">
                                                        Rp <?= number_format($total_penjualan_tab, 0, ',', '.') ?>
                                                    </strong>
                                                </th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <i class="fas fa-ship"></i>
                                    <h4 class="text-muted mb-3">Tidak ada data karcis kapal</h4>
                                    <p class="text-muted mb-4">Data karcis kapal akan muncul di sini setelah diinput dan diverifikasi</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab 3: Ringkasan -->
                    <div class="tab-pane fade" id="tab-ringkasan">
                        <div class="glass-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                                    <i class="fas fa-chart-pie me-2 text-success"></i>
                                    Ringkasan Transaksi
                                </h5>
                                <div class="text-muted">
                                    <?= $start_date ?> s/d <?= $end_date ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart-container">
                                        <canvas id="pieChartJenisIkan"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="chart-container">
                                        <canvas id="barChartTransaksi"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Statistik -->
                    <div class="tab-pane fade" id="tab-statistik">
                        <div class="glass-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                                    <i class="fas fa-chart-line me-2 text-info"></i>
                                    Statistik & Trend
                                </h5>
                                <div class="d-flex gap-2">
                                    <select class="form-select form-select-sm w-auto" id="statistikFilter">
                                        <option value="7">7 Hari Terakhir</option>
                                        <option value="30" selected>30 Hari Terakhir</option>
                                        <option value="90">3 Bulan Terakhir</option>
                                        <option value="365">1 Tahun Terakhir</option>
                                    </select>
                                    <button class="btn btn-sm btn-modern btn-modern-outline" onclick="updateCharts()">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="chart-container">
                                        <canvas id="lineChartTrend"></canvas>
                                    </div>
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
                <span class="text-primary">v1.0.0</span> | 
                Terakhir diupdate: <?= date('d/m/Y H:i:s') ?>
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script>
        // Data untuk charts
        const pieChartData = {
            labels: ['Tongkol', 'Cakalang', 'Tuna', 'Tenggiri', 'Lainnya'],
            datasets: [{
                data: [40, 25, 20, 10, 5],
                backgroundColor: [
                    '#3498DB', // Biru
                    '#2ECC71', // Hijau
                    '#F39C12', // Orange
                    '#E74C3C', // Merah
                    '#95A5A6'  // Abu-abu
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        };
        
        const barChartData = {
            labels: ['Bakul', 'Kapal', 'Total'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [<?= $total_bakul ?>, <?= $total_kapal ?>, <?= $total_bakul + $total_kapal ?>],
                backgroundColor: [
                    '#3498DB',
                    '#F39C12',
                    '#2ECC71'
                ],
                borderWidth: 1
            }, {
                label: 'Total Nilai (Juta Rp)',
                data: [
                    <?= $total_pembelian / 1000000 ?>,
                    <?= $total_penjualan / 1000000 ?>,
                    <?= ($total_pembelian + $total_penjualan) / 1000000 ?>
                ],
                backgroundColor: [
                    '#2980B9',
                    '#E67E22',
                    '#27AE60'
                ],
                borderWidth: 1,
                type: 'bar'
            }]
        };
        
        // Generate labels untuk line chart (7 hari terakhir)
        const generateLast7Days = () => {
            const labels = [];
            const dataTransaksi = [];
            const dataBerat = [];
            const dataNilai = [];
            
            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                labels.push(date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
                
                // Generate random data untuk demo
                dataTransaksi.push(Math.floor(Math.random() * 10) + 5);
                dataBerat.push(Math.floor(Math.random() * 1000) + 500);
                dataNilai.push(Math.floor(Math.random() * 30000000) + 10000000);
            }
            
            return { labels, dataTransaksi, dataBerat, dataNilai };
        };
        
        const { labels: lineLabels, dataTransaksi, dataBerat, dataNilai } = generateLast7Days();
        
        const lineChartData = {
            labels: lineLabels,
            datasets: [
                {
                    label: 'Jumlah Transaksi',
                    data: dataTransaksi,
                    borderColor: '#3498DB',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Total Berat (kg)',
                    data: dataBerat,
                    borderColor: '#2ECC71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        };
        
        // Inisialisasi charts
        let pieChart, barChartTransaksi, lineChart;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart - Jenis Ikan
            const pieCtx = document.getElementById('pieChartJenisIkan').getContext('2d');
            if (pieCtx) {
                pieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: pieChartData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        return `${label}: ${value}%`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Bar Chart - Transaksi
            const barTransaksiCtx = document.getElementById('barChartTransaksi').getContext('2d');
            if (barTransaksiCtx) {
                barChartTransaksi = new Chart(barTransaksiCtx, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Transaksi'
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Nilai (Juta Rp)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    }
                });
            }
            
            // Line Chart - Trend
            const lineCtx = document.getElementById('lineChartTrend').getContext('2d');
            if (lineCtx) {
                lineChart = new Chart(lineCtx, {
                    type: 'line',
                    data: lineChartData,
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Jumlah Transaksi'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Berat (kg)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    }
                });
            }
            
            // Auto-set end date to start date
            document.getElementById('start_date')?.addEventListener('change', function() {
                const endDateField = document.getElementById('end_date');
                if (!endDateField.value || new Date(endDateField.value) < new Date(this.value)) {
                    endDateField.value = this.value;
                }
            });
            
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
        
        function exportToExcel() {
            alert('Export ke Excel akan diimplementasikan.\nData akan diekspor dalam format .xlsx');
            // Implementasi export Excel bisa menggunakan library seperti SheetJS
        }
        
        function printPage() {
            window.print();
        }
        
        function updateCharts() {
            const filterValue = document.getElementById('statistikFilter').value;
            alert(`Memperbarui chart dengan data ${filterValue} hari terakhir`);
            
            // In real implementation, you would fetch new data from server
            // and update the charts accordingly
        }
        
        // Function untuk mengubah periode otomatis
        document.getElementById('periode')?.addEventListener('change', function() {
            const today = new Date();
            const startDateField = document.getElementById('start_date');
            const endDateField = document.getElementById('end_date');
            
            if (!startDateField || !endDateField) return;
            
            switch(this.value) {
                case 'harian':
                    startDateField.value = today.toISOString().split('T')[0];
                    endDateField.value = today.toISOString().split('T')[0];
                    break;
                case 'bulanan':
                    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                    startDateField.value = firstDay.toISOString().split('T')[0];
                    endDateField.value = today.toISOString().split('T')[0];
                    break;
                case 'tahunan':
                    const firstDayYear = new Date(today.getFullYear(), 0, 1);
                    startDateField.value = firstDayYear.toISOString().split('T')[0];
                    endDateField.value = today.toISOString().split('T')[0];
                    break;
            }
        });
    </script>
</body>
</html>