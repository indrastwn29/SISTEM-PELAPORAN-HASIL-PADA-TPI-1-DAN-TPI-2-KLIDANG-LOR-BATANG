<?php
$title = 'Dashboard Petugas - Sistem TPI';
$nama_lengkap = session()->get('nama_lengkap') ?? 'Petugas TPI';
$tpi_id = session()->get('tpi_id') ?? 1;

// Prepare chart data safely
$defaultChartData = [
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    'bakul' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    'kapal' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    'distribution' => [
        ['type' => 'Karcis Bakul', 'count' => 0],
        ['type' => 'Karcis Kapal', 'count' => 0]
    ]
];

$chartData = $chartData ?? $defaultChartData;
$chartDataJson = json_encode($chartData);

// Calculate stats with safe defaults - SESUAI MODEL BARU
$total_harian = $total_harian ?? 0;
$bakul_hari_ini = $total_bakul_harian ?? 0;  // Dari controller baru
$kapal_hari_ini = $total_kapal_harian ?? 0;  // Dari controller baru
$pendapatan_harian = $pendapatan_harian ?? 0;
$menungguVerifikasi = $menungguVerifikasi ?? 0;
$percentageIncrease = $percentageIncrease ?? 0;
$total_semua_bakul = $total_semua_bakul ?? 0;
$total_semua_kapal = $total_semua_kapal ?? 0;
$totalSemuaKarcis = $total_semua_bakul + $total_semua_kapal;

// Data untuk widget baru
$totalPendapatanSemua = $totalPendapatanSemua ?? 0;
$distribusiJam = $distribusiJam ?? [];
$topPemilik = $topPemilik ?? [];

// Data terbaru
$bakul_terbaru = $bakul_terbaru ?? [];
$kapal_terbaru = $kapal_terbaru ?? [];
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0066FF;
            --primary-blue-light: #4D94FF;
            --primary-blue-dark: #0052CC;
            --success: #00B894;
            --warning: #FFA502;
            --danger: #FF4757;
            --info: #17A2B8;
            --white: #FFFFFF;
            --light-1: #F8F9FA;
            --light-2: #E9ECEF;
            --border-color: #E9ECEF;
            --text-primary: #212529;
            --text-secondary: #6C757D;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-round: 50px;
        }
        
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            background-color: #F5F7FB;
            color: var(--text-primary);
            min-height: 100vh;
        }
        
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--white);
            border-right: 1px solid var(--border-color);
            padding: 24px 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 0 20px 24px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 18px;
        }
        
        .logo-text h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            line-height: 1.3;
        }
        
        .logo-text p {
            font-size: 12px;
            color: var(--text-secondary);
            margin: 0;
        }
        
        .user-profile {
            background: var(--light-1);
            border-radius: var(--radius-md);
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 16px;
        }
        
        .user-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .user-info p {
            font-size: 12px;
            color: var(--text-secondary);
            margin: 0;
        }
        
        .nav-container {
            padding: 0 20px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            color: var(--text-secondary);
            text-decoration: none;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(0, 102, 255, 0.08);
            color: var(--primary-blue);
        }
        
        .nav-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
        }
        
        .nav-label {
            flex: 1;
            font-weight: 500;
            font-size: 14px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .top-bar {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .welcome-section h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        
        .welcome-section p {
            color: var(--text-secondary);
            margin: 4px 0 0;
            font-size: 14px;
        }
        
        .date-time {
            text-align: right;
        }
        
        .current-date {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .current-time {
            font-size: 14px;
            color: var(--text-secondary);
        }
        
        .content-wrapper {
            padding: 24px 32px;
            flex: 1;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .stat-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .stat-icon.primary {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-blue);
        }
        
        .stat-icon.success {
            background: rgba(0, 184, 148, 0.1);
            color: var(--success);
        }
        
        .stat-icon.warning {
            background: rgba(255, 165, 2, 0.1);
            color: var(--warning);
        }
        
        .stat-icon.danger {
            background: rgba(255, 71, 87, 0.1);
            color: var(--danger);
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-primary);
        }
        
        .stat-change {
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
        }
        
        .stat-change.positive {
            color: var(--success);
        }
        
        .stat-change.negative {
            color: var(--danger);
        }
        
        /* Charts Section */
        .charts-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 1200px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
        }
        
        .chart-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .chart-actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-chart {
            padding: 8px 16px;
            border-radius: var(--radius-round);
            font-size: 12px;
            font-weight: 500;
            border: 1px solid var(--border-color);
            background: var(--white);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-chart:hover, .btn-chart.active {
            background: var(--primary-blue);
            color: var(--white);
            border-color: var(--primary-blue);
        }
        
        .chart-container {
            height: 300px;
            position: relative;
        }
        
        /* Recent Activity */
        .recent-activity {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
        }
        
        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .activity-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: var(--radius-md);
            background: var(--light-1);
            border-left: 4px solid var(--primary-blue);
            transition: all 0.3s ease;
        }
        
        .activity-item:hover {
            background: var(--white);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            color: var(--primary-blue);
            font-size: 16px;
            flex-shrink: 0;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-text {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        
        .activity-text a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
        }
        
        .activity-text a:hover {
            text-decoration: underline;
        }
        
        .activity-time {
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        /* Footer */
        .footer {
            background: var(--white);
            border-top: 1px solid var(--border-color);
            padding: 20px 32px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }
        
        /* Mobile Menu */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
                background: var(--primary-blue);
                color: white;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                border: none;
                font-size: 18px;
            }
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 20px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .date-time {
                text-align: left;
            }
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Data Terbaru Cards */
        .data-terbaru-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .data-terbaru-container {
                grid-template-columns: 1fr;
            }
        }
        
        .data-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            border: 1px solid var(--border-color);
        }
        
        .data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
        }
        
        .data-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .data-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .data-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-radius: var(--radius-md);
            background: var(--light-1);
        }
        
        .data-info {
            display: flex;
            flex-direction: column;
        }
        
        .data-name {
            font-weight: 500;
            font-size: 14px;
        }
        
        .data-meta {
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .data-value {
            font-weight: 600;
            color: var(--primary-blue);
        }
        
        .empty-data {
            text-align: center;
            padding: 20px;
            color: var(--text-secondary);
        }
        
        .empty-data i {
            font-size: 32px;
            margin-bottom: 10px;
            color: var(--light-2);
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <div class="logo-text">
                        <h3>TPI Dashboard</h3>
                        <p>Petugas <?= $tpi_id ?></p>
                    </div>
                </div>
                
                <div class="user-profile">
                    <div class="user-avatar">
                        <?= strtoupper(substr($nama_lengkap, 0, 1)) ?>
                    </div>
                    <div class="user-info">
                        <h4><?= $nama_lengkap ?></h4>
                        <p>Petugas Aktif</p>
                    </div>
                </div>
            </div>
            
            <nav class="nav-container">
                <a href="<?= site_url('/petugas') ?>" class="nav-item active">
                    <div class="nav-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="nav-label">Dashboard</span>
                </a>
                
                <a href="<?= site_url('/petugas/input-bakul') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <span class="nav-label">Input Karcis Bakul</span>
                </a>
                
                <a href="<?= site_url('/petugas/input-kapal') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-ship"></i>
                    </div>
                    <span class="nav-label">Input Karcis Kapal</span>
                </a>
                
                <!-- MENU DATA KARCIS BAKUL (BARU) -->
                <a href="<?= site_url('/petugas/daftar-karcis-bakul') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <span class="nav-label">Data Karcis Bakul</span>
                </a>
                
                <!-- MENU DATA KARCIS KAPAL (BARU) -->
                <a href="<?= site_url('/petugas/daftar-karcis-pemilik-kapal') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-ship"></i>
                    </div>
                    <span class="nav-label">Data Karcis Kapal</span>
                </a>
                
                <a href="<?= site_url('/petugas/history') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <span class="nav-label">History Input</span>
                </a>
                
                <a href="<?= site_url('/auth/logout') ?>" class="nav-item" style="color: var(--danger);">
                    <div class="nav-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span class="nav-label">Logout</span>
                </a>
            </nav>
        </aside>
        
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOP BAR -->
            <div class="top-bar">
                <div class="welcome-section">
                    <h1>Dashboard Analytics - Sistem TPI</h1>
                    <p>Data real-time dari database | <?= $nama_lengkap ?></p>
                </div>
                
                <div class="date-time">
                    <div class="current-date" id="currentDate"></div>
                    <div class="current-time" id="currentTime"></div>
                </div>
            </div>
            
            <!-- CONTENT -->
            <div class="content-wrapper">
                <!-- Stats Cards -->
                <div class="stats-container">
                    <!-- Total Karcis Hari Ini -->
                    <div class="stat-card fade-in">
                        <div class="stat-header">
                            <div class="stat-title">Total Karcis Hari Ini</div>
                            <div class="stat-icon primary">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </div>
                        <div class="stat-value"><?= $total_harian ?></div>
                        <div class="stat-change <?= $percentageIncrease >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-arrow-<?= $percentageIncrease >= 0 ? 'up' : 'down' ?> me-1"></i>
                            <?= abs($percentageIncrease) ?>% dari kemarin
                        </div>
                    </div>
                    
                    <!-- Karcis Bakul -->
                    <div class="stat-card fade-in" style="animation-delay: 0.1s;">
                        <div class="stat-header">
                            <div class="stat-title">Karcis Bakul</div>
                            <div class="stat-icon success">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                        </div>
                        <div class="stat-value"><?= $bakul_hari_ini ?></div>
                        <div class="stat-change positive">
                            <i class="fas fa-check-circle me-1"></i>
                            Data real database
                        </div>
                    </div>
                    
                    <!-- Karcis Kapal -->
                    <div class="stat-card fade-in" style="animation-delay: 0.2s;">
                        <div class="stat-header">
                            <div class="stat-title">Karcis Kapal</div>
                            <div class="stat-icon warning">
                                <i class="fas fa-ship"></i>
                            </div>
                        </div>
                        <div class="stat-value"><?= $kapal_hari_ini ?></div>
                        <div class="stat-change positive">
                            <i class="fas fa-anchor me-1"></i>
                            Data real database
                        </div>
                    </div>
                    
                    <!-- Menunggu Verifikasi -->
                    <div class="stat-card fade-in" style="animation-delay: 0.3s;">
                        <div class="stat-header">
                            <div class="stat-title">Menunggu Verifikasi</div>
                            <div class="stat-icon danger">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="stat-value"><?= $menungguVerifikasi ?></div>
                        <div class="stat-change negative">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Perlu tindakan
                        </div>
                    </div>
                </div>
                
                <!-- Data Terbaru -->
                <div class="data-terbaru-container">
                    <!-- Data Bakul Terbaru -->
                    <div class="data-card fade-in">
                        <div class="data-header">
                            <div class="data-title">
                                <i class="fas fa-shopping-basket"></i>
                                Karcis Bakul Terbaru
                            </div>
                            <span class="badge bg-primary"><?= count($bakul_terbaru) ?></span>
                        </div>
                        
                        <?php if (!empty($bakul_terbaru)): ?>
                            <div class="data-list">
                                <?php foreach ($bakul_terbaru as $item): ?>
                                <div class="data-item">
                                    <div class="data-info">
                                        <div class="data-name"><?= $item['nama_bakul'] ?? 'N/A' ?></div>
                                        <div class="data-meta">
                                            <?= date('d/m/Y H:i', strtotime($item['tanggal_input'] ?? 'now')) ?>
                                        </div>
                                    </div>
                                    <div class="data-value">
                                        Rp <?= number_format($item['total'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-data">
                                <i class="fas fa-shopping-basket"></i>
                                <p>Belum ada data bakul</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Data Kapal Terbaru -->
                    <div class="data-card fade-in" style="animation-delay: 0.1s;">
                        <div class="data-header">
                            <div class="data-title">
                                <i class="fas fa-ship"></i>
                                Karcis Kapal Terbaru
                            </div>
                            <span class="badge bg-success"><?= count($kapal_terbaru) ?></span>
                        </div>
                        
                        <?php if (!empty($kapal_terbaru)): ?>
                            <div class="data-list">
                                <?php foreach ($kapal_terbaru as $item): ?>
                                <div class="data-item">
                                    <div class="data-info">
                                        <div class="data-name"><?= $item['nama_pemilik'] ?? 'N/A' ?></div>
                                        <div class="data-meta">
                                            <?= date('d/m/Y H:i', strtotime($item['created_at'] ?? 'now')) ?>
                                        </div>
                                    </div>
                                    <div class="data-value">
                                        Rp <?= number_format($item['harga'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-data">
                                <i class="fas fa-ship"></i>
                                <p>Belum ada data kapal</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Charts Section -->
                <div class="charts-container mb-4">
                    <!-- Monthly Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Statistik Bulanan Karcis</div>
                            <div class="chart-actions">
                                <button class="btn-chart active" data-period="month">Bulanan</button>
                                <button class="btn-chart" data-period="week">Mingguan</button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Distribution Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Distribusi Karcis</div>
                        </div>
                        <div class="chart-container">
                            <canvas id="distributionChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="recent-activity fade-in">
                    <div class="activity-header">
                        <div class="activity-title">Aktivitas & Informasi</div>
                        <a href="<?= site_url('/petugas/history') ?>" class="btn-chart">
                            Lihat History Lengkap
                        </a>
                    </div>
                    
                    <div class="activity-list">
                        <!-- Activity 1: Data Real -->
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    Dashboard menampilkan <strong>data real</strong> dari database
                                </div>
                                <div class="activity-time">
                                    <i class="far fa-clock me-1"></i>
                                    Total <?= $totalSemuaKarcis ?> karcis tersimpan
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity 2: Performance -->
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    <?php if($percentageIncrease > 0): ?>
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            Peningkatan <?= $percentageIncrease ?>% dari kemarin
                                        </span>
                                    <?php elseif($percentageIncrease < 0): ?>
                                        <span class="text-danger">
                                            <i class="fas fa-arrow-down me-1"></i>
                                            Penurunan <?= abs($percentageIncrease) ?>% dari kemarin
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">
                                            <i class="fas fa-minus me-1"></i>
                                            Stabil dari kemarin
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="activity-time">
                                    <i class="far fa-clock me-1"></i>
                                    <?= $total_harian ?> karcis hari ini
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity 3: Bakul vs Kapal -->
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    Rasio Bakul:Kapal = 
                                    <strong><?= $bakul_hari_ini ?></strong>:<strong><?= $kapal_hari_ini ?></strong>
                                </div>
                                <div class="activity-time">
                                    <i class="far fa-clock me-1"></i>
                                    <?= $bakul_hari_ini + $kapal_hari_ini ?> total karcis hari ini
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity 4: Pendapatan -->
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    Total pendapatan hari ini: 
                                    <strong>Rp <?= number_format($pendapatan_harian, 0, ',', '.') ?></strong>
                                </div>
                                <div class="activity-time">
                                    <i class="far fa-clock me-1"></i>
                                    Data dari database real
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity 5: Verifikasi -->
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    <?php if($menungguVerifikasi > 0): ?>
                                        <span class="text-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <strong><?= $menungguVerifikasi ?></strong> karcis menunggu verifikasi
                                        </span>
                                    <?php else: ?>
                                        <span class="text-success">
                                            <i class="fas fa-check me-1"></i>
                                            Semua karcis sudah diverifikasi
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="activity-time">
                                    <i class="far fa-clock me-1"></i>
                                    Status verifikasi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FOOTER -->
            <div class="footer">
                <p>&copy; <?= date('Y') ?> Sistem Tempat Pelelangan Ikan (TPI). Dashboard Analytics v2.1</p>
                <p class="mb-0">Data real-time | Terakhir diperbarui: <?= date('d/m/Y H:i:s') ?></p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');
            
            if (mobileMenuBtn && sidebar) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
                
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(event) {
                    if (window.innerWidth <= 1024) {
                        if (!sidebar.contains(event.target) && 
                            !mobileMenuBtn.contains(event.target) && 
                            sidebar.classList.contains('active')) {
                            sidebar.classList.remove('active');
                        }
                    }
                });
            }
            
            // Update current date and time
            function updateDateTime() {
                const now = new Date();
                
                // Format date
                const optionsDate = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                
                // Format time
                const optionsTime = { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                };
                const formattedTime = now.toLocaleTimeString('id-ID', optionsTime);
                
                document.getElementById('currentDate').textContent = formattedDate;
                document.getElementById('currentTime').textContent = formattedTime;
            }
            
            // Update immediately and every second
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Chart data from PHP
            const chartData = <?= $chartDataJson ?>;
            
            // Format distribution data for chart
            const distributionLabels = chartData.distribution.map(item => item.type);
            const distributionData = chartData.distribution.map(item => item.count);
            
            // Initialize Monthly Chart
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Karcis Bakul',
                            data: chartData.bakul,
                            backgroundColor: 'rgba(0, 102, 255, 0.7)',
                            borderColor: 'rgba(0, 102, 255, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Karcis Kapal',
                            data: chartData.kapal,
                            backgroundColor: 'rgba(0, 184, 148, 0.7)',
                            borderColor: 'rgba(0, 184, 148, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
            
            // Initialize Distribution Chart
            const distributionCtx = document.getElementById('distributionChart').getContext('2d');
            const distributionChart = new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: distributionLabels,
                    datasets: [{
                        data: distributionData,
                        backgroundColor: [
                            'rgba(0, 102, 255, 0.8)',
                            'rgba(0, 184, 148, 0.8)'
                        ],
                        borderColor: [
                            'rgba(0, 102, 255, 1)',
                            'rgba(0, 184, 148, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '60%'
                }
            });
            
            // Chart period toggle
            document.querySelectorAll('.btn-chart').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.btn-chart').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Here you could fetch new data based on period
                    // For now, just update the chart title
                    const chartTitle = document.querySelector('.chart-card .chart-title');
                    const period = this.getAttribute('data-period');
                    
                    if (period === 'month') {
                        chartTitle.textContent = 'Statistik Bulanan Karcis';
                    } else if (period === 'week') {
                        chartTitle.textContent = 'Statistik Mingguan Karcis';
                    }
                });
            });
            
            // Auto-refresh dashboard every 5 minutes
            setTimeout(function() {
                location.reload();
            }, 5 * 60 * 1000);
        });
    </script>
</body>
</html>