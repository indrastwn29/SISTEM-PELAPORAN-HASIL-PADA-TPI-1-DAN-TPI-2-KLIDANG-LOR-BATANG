<?php
$title = 'History Input Karcis';
$nama_lengkap = session()->get('nama_lengkap') ?? 'Petugas TPI';
$tpi_id = session()->get('tpi_id') ?? 1;

// Data dari controller (gunakan variabel yang sesuai dengan controller)
$history_data = $history_data ?? [];
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0066FF;
            --primary-blue-light: #4D94FF;
            --primary-blue-dark: #0052CC;
            --success: #00B894;
            --warning: #FFA502;
            --danger: #FF4757;
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
        
        /* Sidebar - SAMA DENGAN DASHBOARD (PUTIH) */
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
        
        .page-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }
        
        .date-time {
            font-size: 14px;
            color: var(--text-secondary);
            background: var(--light-1);
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .content-wrapper {
            padding: 32px;
            flex: 1;
        }
        
        /* History Container */
        .history-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        .history-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--border-color);
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary-blue);
        }
        
        .badge-count {
            background: var(--primary-blue);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        /* Filter Controls */
        .filter-controls {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            padding: 16px;
            background: var(--light-1);
            border-radius: var(--radius-md);
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-label {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-primary);
        }
        
        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            font-size: 14px;
            min-width: 150px;
        }
        
        .filter-select:focus {
            border-color: var(--primary-blue);
            outline: none;
        }
        
        .btn-filter {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-filter:hover {
            background: var(--primary-blue-dark);
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
        }
        
        .history-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .history-table thead {
            background: var(--light-1);
        }
        
        .history-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            font-size: 14px;
        }
        
        .history-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-primary);
        }
        
        .history-table tbody tr:hover {
            background: var(--light-1);
        }
        
        .history-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-lunas {
            background: rgba(0, 184, 148, 0.1);
            color: var(--success);
        }
        
        .status-belum {
            background: rgba(255, 165, 2, 0.1);
            color: var(--warning);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-view {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-blue);
        }
        
        .btn-view:hover {
            background: rgba(0, 102, 255, 0.2);
        }
        
        .btn-print {
            background: rgba(108, 117, 125, 0.1);
            color: var(--text-secondary);
        }
        
        .btn-print:hover {
            background: rgba(108, 117, 125, 0.2);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--light-2);
        }
        
        .empty-state h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--text-secondary);
        }
        
        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        /* Summary Stats */
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-box {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .stat-icon.blue {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-blue);
        }
        
        .stat-icon.green {
            background: rgba(0, 184, 148, 0.1);
            color: var(--success);
        }
        
        .stat-content h4 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            color: var(--text-primary);
        }
        
        .stat-content p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 5px 0 0;
        }
        
        /* Mobile Responsive */
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
            
            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .history-table th,
            .history-table td {
                padding: 12px 8px;
                font-size: 13px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .summary-stats {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                padding: 16px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .page-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="app-container">
        <!-- SIDEBAR - DENGAN MENU HISTORY AKTIF -->
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
                <a href="<?= site_url('/petugas') ?>" class="nav-item">
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
                
                <!-- MENU DATA KARCIS BAKUL -->
                <a href="<?= site_url('/petugas/daftar-karcis-bakul') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <span class="nav-label">Data Karcis Bakul</span>
                </a>
                
                <!-- MENU DATA KARCIS KAPAL -->
                <a href="<?= site_url('/petugas/daftar-karcis-pemilik-kapal') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-ship"></i>
                    </div>
                    <span class="nav-label">Data Karcis Kapal</span>
                </a>
                
                <!-- MENU HISTORY AKTIF -->
                <a href="<?= site_url('/petugas/history') ?>" class="nav-item active">
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
            <div class="top-bar">
                <h1 class="page-title">History Input Karcis</h1>
                <div class="date-time" id="currentTime">
                    <i class="fas fa-clock me-2"></i>
                    <span id="timeDisplay">Loading...</span>
                </div>
            </div>
            
            <div class="content-wrapper">
                <!-- Summary Stats -->
                <div class="summary-stats">
                    <div class="stat-box">
                        <div class="stat-icon blue">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <div class="stat-content">
                            <h4><?= count(array_filter($history_data, function($item) { return $item['type'] == 'bakul'; })) ?></h4>
                            <p>Total Karcis Bakul</p>
                        </div>
                    </div>
                    
                    <div class="stat-box">
                        <div class="stat-icon green">
                            <i class="fas fa-ship"></i>
                        </div>
                        <div class="stat-content">
                            <h4><?= count(array_filter($history_data, function($item) { return $item['type'] == 'kapal'; })) ?></h4>
                            <p>Total Karcis Kapal</p>
                        </div>
                    </div>
                    
                    <div class="stat-box">
                        <div class="stat-icon blue">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="stat-content">
                            <h4><?= count($history_data) ?></h4>
                            <p>Total Semua Karcis</p>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Controls -->
                <div class="filter-controls">
                    <div class="filter-group">
                        <label class="filter-label">Periode:</label>
                        <select class="filter-select" id="filterPeriod">
                            <option value="all">Semua Waktu</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Jenis:</label>
                        <select class="filter-select" id="filterType">
                            <option value="all">Semua Jenis</option>
                            <option value="bakul">Karcis Bakul</option>
                            <option value="kapal">Karcis Kapal</option>
                        </select>
                    </div>
                    
                    <button class="btn-filter" id="applyFilter">
                        <i class="fas fa-filter me-2"></i> Terapkan Filter
                    </button>
                    
                    <button class="btn-filter" id="resetFilter" style="background: var(--light-2); color: var(--text-secondary);">
                        <i class="fas fa-redo me-2"></i> Reset
                    </button>
                </div>
                
                <!-- History Container -->
                <div class="history-container">
                    <!-- History Table -->
                    <div class="history-section">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-history"></i>
                                History Input Karcis
                                <span class="badge-count"><?= count($history_data) ?></span>
                            </h2>
                        </div>
                        
                        <?php if (!empty($history_data)): ?>
                        <div class="table-container">
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Nama / Pemilik</th>
                                        <th>Jenis Ikan</th>
                                        <th>Berat (kg)</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history_data as $index => $item): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($item['tanggal'])) ?></td>
                                        <td>
                                            <?php if ($item['type'] == 'bakul'): ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <i class="fas fa-shopping-basket me-1"></i> Bakul
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-ship me-1"></i> Kapal
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $item['nama'] ?>
                                            <?php if ($item['type'] == 'kapal'): ?>
                                                <br><small class="text-muted"><?= $item['nama_kapal'] ?? '' ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                <?= ucfirst($item['jenis_ikan']) ?>
                                            </span>
                                        </td>
                                        <td><?= number_format($item['berat'], 1, ',', '.') ?></td>
                                        <td>
                                            <strong>Rp <?= number_format($item['harga'], 0, ',', '.') ?></strong>
                                        </td>
                                        <td>
                                            <?php if ($item['status'] == 'verified'): ?>
                                                <span class="status-badge status-lunas">
                                                    <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                                </span>
                                            <?php elseif ($item['status'] == 'pending'): ?>
                                                <span class="status-badge status-belum">
                                                    <i class="fas fa-clock me-1"></i> Menunggu
                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d;">
                                                    <?= ucfirst($item['status']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action btn-view" onclick="viewDetail('<?= $item['type'] ?>', <?= $item['id'] ?>)">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button class="btn-action btn-print" onclick="printKarcis(<?= $item['id'] ?>, '<?= $item['type'] ?>')">
                                                    <i class="fas fa-print"></i> Cetak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <h3>Belum ada data history</h3>
                            <p>Mulai input karcis untuk melihat history di sini</p>
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <a href="<?= site_url('/petugas/input-bakul') ?>" class="btn-filter">
                                    <i class="fas fa-shopping-basket me-2"></i> Input Bakul
                                </a>
                                <a href="<?= site_url('/petugas/input-kapal') ?>" class="btn-filter">
                                    <i class="fas fa-ship me-2"></i> Input Kapal
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
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
            
            // Update current time
            updateCurrentTime();
            setInterval(updateCurrentTime, 60000);
            
            // Filter functionality
            const applyFilterBtn = document.getElementById('applyFilter');
            const resetFilterBtn = document.getElementById('resetFilter');
            
            if (applyFilterBtn) {
                applyFilterBtn.addEventListener('click', function() {
                    const period = document.getElementById('filterPeriod').value;
                    const type = document.getElementById('filterType').value;
                    
                    // Show loading
                    applyFilterBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memfilter...';
                    applyFilterBtn.disabled = true;
                    
                    // Simulate API call
                    setTimeout(() => {
                        alert(`Filter diterapkan:\nPeriode: ${period}\nJenis: ${type}\n\nDalam aplikasi nyata, data akan difilter dari database.`);
                        
                        // Reset button
                        applyFilterBtn.innerHTML = '<i class="fas fa-filter me-2"></i> Terapkan Filter';
                        applyFilterBtn.disabled = false;
                    }, 1000);
                });
            }
            
            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', function() {
                    document.getElementById('filterPeriod').value = 'all';
                    document.getElementById('filterType').value = 'all';
                    alert('Filter direset ke default');
                });
            }
            
            // Initialize with today's date in filter
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('filterPeriod').value = 'all';
        });
        
        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            const timeDisplay = now.toLocaleDateString('id-ID', options);
            document.getElementById('timeDisplay').textContent = timeDisplay;
        }
        
        // View detail function
        function viewDetail(type, id) {
            if (type === 'bakul') {
                alert(`Melihat detail karcis bakul ID: ${id}\n\nDalam aplikasi nyata, akan menampilkan modal dengan detail lengkap.`);
            } else {
                alert(`Melihat detail karcis kapal ID: ${id}\n\nDalam aplikasi nyata, akan menampilkan modal dengan detail lengkap.`);
            }
        }
        
        // Print karcis function
        function printKarcis(id, type) {
            alert(`Mencetak karcis ${type} ID: ${id}\n\nDalam aplikasi nyata, akan membuka halaman cetak karcis.`);
        }
        
        // Export to Excel function
        function exportToExcel() {
            alert('Mengekspor data ke Excel...\n\nDalam aplikasi nyata, akan mengunduh file Excel.');
        }
        
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>