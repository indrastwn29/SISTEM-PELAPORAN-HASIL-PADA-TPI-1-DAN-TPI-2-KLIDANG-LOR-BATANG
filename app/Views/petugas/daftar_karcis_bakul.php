<?php
$title = 'Daftar Karcis Bakul';
$nama_lengkap = session()->get('nama_lengkap') ?? 'Petugas TPI';
$tpi_id = session()->get('tpi_id') ?? 1;

// Data dari controller (gunakan variabel yang sesuai)
$karcis = $karcis ?? [];
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            --info: #17a2b8;
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
        
        .nav-item:hover {
            background: rgba(0, 102, 255, 0.08);
            color: var(--primary-blue);
        }
        
        .nav-item.active {
            background: rgba(0, 102, 255, 0.08);
            color: var(--primary-blue);
            font-weight: 600;
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
        
        .content-wrapper {
            padding: 24px 32px;
            flex: 1;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
        
        .stat-icon.primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
        }
        
        .stat-icon.info {
            background: linear-gradient(135deg, var(--info), #5bc0de);
        }
        
        .stat-icon.success {
            background: linear-gradient(135deg, var(--success), #00d68f);
        }
        
        .stat-icon.warning {
            background: linear-gradient(135deg, var(--warning), #ffbe76);
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        
        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Table Container */
        .table-container {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .table-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        
        .table-title i {
            color: var(--info);
            margin-right: 8px;
        }
        
        /* Action Buttons */
        .btn-action {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
            color: white;
        }
        
        .btn-outline-primary {
            background: white;
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
        }
        
        .btn-outline-primary:hover {
            background: rgba(0, 102, 255, 0.05);
            color: var(--primary-blue);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success), #00d68f);
            color: white;
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #00a87a, #00c47a);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #ffbe76);
            color: white;
            border: none;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #ff6b81);
            color: white;
            border: none;
        }
        
        /* Table Styles */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: #f8f9fc;
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #495057;
            padding: 12px 16px;
            white-space: nowrap;
        }
        
        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fc;
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge-success {
            background: rgba(0, 184, 148, 0.1);
            color: var(--success);
            border: 1px solid rgba(0, 184, 148, 0.2);
        }
        
        .badge-warning {
            background: rgba(255, 165, 2, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 165, 2, 0.2);
        }
        
        .badge-danger {
            background: rgba(255, 71, 87, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 71, 87, 0.2);
        }
        
        .badge-info {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
            border: 1px solid rgba(23, 162, 184, 0.2);
        }
        
        .badge-primary {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-blue);
            border: 1px solid rgba(0, 102, 255, 0.2);
        }
        
        /* Action Buttons Group */
        .btn-group-action {
            display: flex;
            gap: 6px;
        }
        
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-icon-view {
            background: rgba(0, 184, 148, 0.1);
            color: var(--success);
        }
        
        .btn-icon-view:hover {
            background: var(--success);
            color: white;
        }
        
        .btn-icon-edit {
            background: rgba(255, 165, 2, 0.1);
            color: var(--warning);
        }
        
        .btn-icon-edit:hover {
            background: var(--warning);
            color: white;
        }
        
        .btn-icon-delete {
            background: rgba(255, 71, 87, 0.1);
            color: var(--danger);
        }
        
        .btn-icon-delete:hover {
            background: var(--danger);
            color: white;
        }
        
        .btn-icon-verify {
            background: rgba(0, 102, 255, 0.1);
            color: var(--primary-blue);
        }
        
        .btn-icon-verify:hover {
            background: var(--primary-blue);
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-state-icon {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 16px;
        }
        
        .empty-state-title {
            font-size: 18px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
        }
        
        .empty-state-description {
            color: #adb5bd;
            margin-bottom: 20px;
        }
        
        /* Search and Filter */
        .search-filter-container {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .search-box {
            flex: 1;
            min-width: 300px;
        }
        
        .search-box .input-group {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        .search-box .input-group-text {
            background: #f8f9fa;
            border: none;
            color: #6c757d;
        }
        
        .search-box .form-control {
            border: none;
            padding-left: 0;
        }
        
        .search-box .form-control:focus {
            box-shadow: none;
        }
        
        .filter-box {
            min-width: 200px;
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
                padding: 16px;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .search-filter-container {
                flex-direction: column;
            }
            
            .search-box, .filter-box {
                min-width: 100%;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .table-container {
                padding: 16px;
            }
        }
        
        /* DataTables Custom */
        .dataTables_wrapper {
            margin-top: 20px;
        }
        
        .dataTables_length select {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }
        
        .dataTables_filter input {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }
        
        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .dataTables_paginate .paginate_button.current {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
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
                <a href="<?= site_url('/petugas') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="nav-label">Dashboard</span>
                </a>
                
                <a href="<?= site_url('/petugas/input-bakul') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <span class="nav-label">Input Karcis Bakul</span>
                </a>
                
                <a href="<?= site_url('/petugas/input-kapal') ?>" class="nav-item">
                    <div class="nav-icon">
                        <i class="fas fa-ship"></i>
                    </div>
                    <span class="nav-label">Input Karcis Kapal</span>
                </a>
                
                <!-- MENU DATA KARCIS BAKUL (AKTIF) -->
                <a href="<?= site_url('/petugas/daftar-karcis-bakul') ?>" class="nav-item active">
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
                <h1 style="margin: 0; font-size: 24px;">
                    <i class="fas fa-shopping-basket me-2" style="color: var(--info);"></i>
                    Daftar Karcis Bakul
                </h1>
                <div>
                    <a href="<?= site_url('/petugas/input-bakul') ?>" class="btn-action btn-primary">
                        <i class="fas fa-plus-circle me-1"></i>
                        Tambah Karcis Bakul
                    </a>
                </div>
            </div>
            
            <!-- CONTENT -->
            <div class="content-wrapper">
                <!-- Stats Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value"><?= count($karcis) ?></div>
                            <div class="stat-label">Total Karcis Bakul</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                <?= count(array_filter($karcis, function($item) {
                                    return ($item['status_verifikasi'] ?? '') == 'verified';
                                })) ?>
                            </div>
                            <div class="stat-label">Terverifikasi</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                <?= count(array_filter($karcis, function($item) {
                                    return ($item['status_verifikasi'] ?? '') == 'pending';
                                })) ?>
                            </div>
                            <div class="stat-label">Menunggu Verifikasi</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon info">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">
                                Rp <?= number_format(array_sum(array_column($karcis, 'total')), 0, ',', '.') ?>
                            </div>
                            <div class="stat-label">Total Nilai</div>
                        </div>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="table-container">
                    <div class="table-header">
                        <h2 class="table-title">
                            <i class="fas fa-list"></i>
                            Data Karcis Bakul
                        </h2>
                        
                        <div class="search-filter-container">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari karcis...">
                                </div>
                            </div>
                            
                            <div class="filter-box">
                                <select class="form-control" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Menunggu Verifikasi</option>
                                    <option value="verified">Terverifikasi</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!empty($karcis)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="karcisTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Nama Bakul</th>
                                        <th>Alamat</th>
                                        <th>Berat Ikan (kg)</th>
                                        <th>Jumlah Pembelian</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($karcis as $item): ?>
                                        <?php
                                        // Safely get data
                                        $id = $item['id_bakul'] ?? $item['id'] ?? 0;
                                        $nama_bakul = $item['nama_bakul'] ?? '-';
                                        $alamat = $item['alamat'] ?? '-';
                                        $berat_ikan = $item['berat_ikan'] ?? 0;
                                        $jumlah_pembelian = $item['jumlah_pembelian'] ?? 0;
                                        $total = $item['total'] ?? $item['jumlah_bayar'] ?? 0;
                                        $status = $item['status_verifikasi'] ?? 'pending';
                                        $tanggal = $item['tanggal_input'] ?? $item['created_at'] ?? date('Y-m-d');
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <span class="badge bg-secondary">#<?= $id ?></span>
                                            </td>
                                            <td><?= $nama_bakul ?></td>
                                            <td>
                                                <small class="text-muted"><?= substr($alamat, 0, 30) ?>...</small>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($berat_ikan, 2) ?> kg
                                            </td>
                                            <td class="text-end">
                                                Rp <?= number_format($jumlah_pembelian, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($status == 'verified'): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                                    </span>
                                                <?php elseif ($status == 'pending'): ?>
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock me-1"></i> Menunggu
                                                    </span>
                                                <?php elseif ($status == 'rejected'): ?>
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Ditolak
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary"><?= $status ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y', strtotime($tanggal)) ?>
                                                <br>
                                                <small class="text-muted"><?= date('H:i', strtotime($tanggal)) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group-action">
                                                    <button class="btn-icon btn-icon-view" title="Lihat Detail" onclick="viewDetailBakul(<?= $id ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <?php if ($status == 'pending'): ?>
                                                        <a href="<?= site_url('/petugas/proses-verifikasi/' . $id . '/bakul') ?>" class="btn-icon btn-icon-verify" title="Verifikasi">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?= site_url('/petugas/edit-bakul/' . $id) ?>" class="btn-icon btn-icon-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <button class="btn-icon btn-icon-delete" title="Hapus" onclick="deleteBakul(<?= $id ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Table Summary -->
                        <div class="mt-3 text-end">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan <?= count($karcis) ?> data karcis bakul
                            </small>
                        </div>
                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-shopping-basket"></i>
                            </div>
                            <h3 class="empty-state-title">Belum ada data karcis bakul</h3>
                            <p class="empty-state-description">
                                Mulai dengan menambahkan karcis bakul pertama Anda
                            </p>
                            <a href="<?= site_url('/petugas/input-bakul') ?>" class="btn-action btn-primary">
                                <i class="fas fa-plus-circle me-1"></i>
                                Tambah Karcis Bakul Pertama
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
            
            // Initialize DataTable if table exists
            const table = document.getElementById('karcisTable');
            if (table) {
                // Simple search functionality
                const searchInput = document.getElementById('searchInput');
                const filterStatus = document.getElementById('filterStatus');
                
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    filterTable(filter, filterStatus.value);
                });
                
                filterStatus.addEventListener('change', function() {
                    const filter = searchInput.value.toLowerCase();
                    filterTable(filter, this.value);
                });
            }
            
            // Auto-refresh page every 30 seconds
            setTimeout(() => {
                window.location.reload();
            }, 30000);
        });
        
        // Filter table function
        function filterTable(searchText, statusFilter) {
            const rows = document.querySelectorAll('#karcisTable tbody tr');
            
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const statusCell = row.querySelector('td:nth-child(8)').textContent.toLowerCase();
                
                const matchesSearch = searchText === '' || rowText.includes(searchText);
                const matchesStatus = statusFilter === '' || 
                    (statusFilter === 'pending' && statusCell.includes('menunggu')) ||
                    (statusFilter === 'verified' && statusCell.includes('terverifikasi')) ||
                    (statusFilter === 'rejected' && statusCell.includes('ditolak'));
                
                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }
        
        // View detail function
        function viewDetailBakul(id) {
            Swal.fire({
                title: 'Detail Karcis Bakul',
                html: 'Loading data...',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    // In a real application, you would fetch data via AJAX
                    Swal.showLoading();
                    
                    setTimeout(() => {
                        Swal.fire({
                            title: 'Detail Karcis Bakul',
                            html: `Fitur detail akan menampilkan informasi lengkap karcis bakul dengan ID: ${id}`,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }, 500);
                }
            });
        }
        
        // Delete karcis bakul function
        function deleteBakul(id) {
            Swal.fire({
                title: 'Hapus Karcis Bakul?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete
                    fetch(`<?= site_url('/petugas/delete-bakul/') ?>${id}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Dihapus!',
                                text: 'Data karcis bakul telah dihapus.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload page after deletion
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Gagal menghapus data.',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error'
                        });
                    });
                }
            });
        }
        
        // Export to Excel
        function exportToExcel() {
            Swal.fire({
                title: 'Ekspor Data',
                text: 'Fitur ekspor ke Excel akan segera hadir',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
        
        // Print table
        function printTable() {
            window.print();
        }
        
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>