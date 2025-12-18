<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Karcis Kapal - Sistem Lelang Ikan TPI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
            --gradient-gray: linear-gradient(135deg, #34495E 0%, #7F8C8D 100%);
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
        
        /* NAVBAR STICKY - TIDAK HILANG SAAT SCROLL */
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
        
        /* Navbar tetap terlihat saat scroll */
        .navbar-scrolled {
            background: rgba(44, 62, 80, 0.98) !important;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Sidebar Modern - POSISI STICKY SEPERTI NAVBAR */
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
        
        /* Stat Cards */
        .stat-card-modern {
            border-radius: 18px;
            border: none;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        
        .stat-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-icon-modern {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        /* Search & Filter */
        .search-box {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            background: white;
        }
        
        .search-box input {
            border: none;
            padding: 15px 20px 15px 50px;
            background: white;
            width: 100%;
            color: #2C3E50;
        }
        
        .search-box input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .search-box .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-medium);
        }
        
        /* Table Styling */
        .table-modern {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(52, 152, 219, 0.02);
            --bs-table-hover-bg: rgba(52, 152, 219, 0.05);
        }
        
        .table-modern thead th {
            background: rgba(44, 62, 80, 0.08);
            color: var(--dark-color);
            font-weight: 600;
            border: none;
            padding: 18px 20px;
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 2px solid #3498DB;
        }
        
        .table-modern tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(236, 240, 241, 0.8);
            color: #2C3E50;
        }
        
        .table-modern tbody tr {
            transition: all 0.3s ease;
        }
        
        .table-modern tbody tr:hover {
            background: rgba(52, 152, 219, 0.05) !important;
            transform: scale(1.001);
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.05);
        }
        
        /* Badge Modern */
        .badge-modern {
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 2px solid transparent;
        }
        
        .badge-modern.waiting {
            background: linear-gradient(135deg, #FEF9E7, #FDEBD0);
            color: #D35400;
            border-color: #F1C40F;
        }
        
        .badge-modern.verified {
            background: linear-gradient(135deg, #E8F8EF, #D5F5E3);
            color: #27AE60;
            border-color: #2ECC71;
        }
        
        .badge-modern.rejected {
            background: linear-gradient(135deg, #FDEDEC, #FADBD8);
            color: #C0392B;
            border-color: #E74C3C;
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
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar-modern {
                height: auto;
                position: static;
                margin-bottom: 20px;
            }
            
            .stat-card-modern {
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .glass-card {
                border-radius: 15px;
            }
            
            .table-modern {
                font-size: 0.9rem;
            }
            
            .table-modern thead th,
            .table-modern tbody td {
                padding: 12px 15px;
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
                    <span class="badge"><?= isset($total_menunggu) && $total_menunggu > 0 ? $total_menunggu : '' ?></span>
                </div>
                
                <!-- User Profile -->
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-modern-outline d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="bg-white rounded-circle p-2 me-2">
                            <i class="fas fa-user" style="color: #3498DB;"></i>
                        </div>
                        <div class="text-start d-none d-md-block">
                            <div class="fw-bold">Admin</div>
                            <small>Super Admin</small>
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
                        </a>
                        
                        <!-- Verifikasi Kapal -->
                        <a href="<?= site_url('admin/verifikasi-karcis-kapal') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 active">
                            <i class="fas fa-ship me-3"></i>
                            <span>Verifikasi Kapal</span>
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
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('admin/semua-data-terverifikasi') ?>">
                                        <i class="fas fa-list me-2"></i> Semua Data Terverifikasi
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Laporan & Statistik -->
                        <a href="<?= site_url('/laporan') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
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
                            <i class="fas fa-ship me-3" style="color: #3498DB;"></i>
                            VERIFIKASI KARCIS KAPAL
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2" style="color: #3498DB;"></i>
                            Verifikasi dan validasi data karcis dari kapal ikan sebelum diproses dalam sistem lelang
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-modern-outline" onclick="printPage()">
                            <i class="fas fa-print"></i>
                            <span class="d-none d-md-inline">Print</span>
                        </button>
                        <button class="btn btn-modern btn-modern-primary" onclick="refreshData()">
                            <i class="fas fa-sync-alt"></i>
                            <span class="d-none d-md-inline">Refresh</span>
                        </button>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-3 fs-4"></i>
                        <div class="flex-grow-1"><?= session()->getFlashdata('success') ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                        <div class="flex-grow-1"><?= session()->getFlashdata('error') ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Statistics -->
                <div class="row mb-4 g-4">
                    <div class="col-md-4">
                        <div class="stat-card-modern glass-card p-4" style="border-top: 5px solid #F39C12;">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-modern me-3" style="background: rgba(243, 156, 18, 0.1); color: #F39C12;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-1"><?= isset($total_menunggu) ? $total_menunggu : '0' ?></h3>
                                    <p class="text-muted mb-0">Menunggu Verifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card-modern glass-card p-4" style="border-top: 5px solid #27AE60;">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-modern me-3" style="background: rgba(39, 174, 96, 0.1); color: #27AE60;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-1">0</h3>
                                    <p class="text-muted mb-0">Sudah Diverifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card-modern glass-card p-4" style="border-top: 5px solid #E74C3C;">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon-modern me-3" style="background: rgba(231, 76, 60, 0.1); color: #E74C3C;">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-1">0</h3>
                                    <p class="text-muted mb-0">Ditolak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama kapal, nomor karcis, atau jenis ikan...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="statusFilter">
                            <option value="all">Semua Status</option>
                            <option value="waiting">Menunggu</option>
                            <option value="verified">Diverifikasi</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="glass-card p-4">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>No. Karcis</th>
                                    <th>Nama Pemilik</th>
                                    <th>Nama Kapal</th>
                                    <th>Jenis Ikan</th>
                                    <th>Berat (Kg)</th>
                                    <th>Harga (Rp)</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($karcis_data)): ?>
                                    <?php foreach ($karcis_data as $karcis): ?>
                                        <?php 
                                        // DEBUG: Tampilkan struktur data untuk debugging
                                        // echo "<pre>"; print_r($karcis); echo "</pre>";
                                        
                                        // ===== PERBAIKAN: AMBIL ID DENGAN BERBAGAI KEMUNGKINAN =====
                                        // Controller mengirim: $karcis['_primary_value'] atau $karcis['id']
                                        $karcis_id = $karcis['_primary_value'] ?? $karcis['id'] ?? 0;
                                        
                                        // ===== PERBAIKAN: AMBIL PRIMARY KEY =====
                                        $primary_key = $karcis['_primary_key'] ?? 'id';
                                        
                                        // ===== PERBAIKAN: AMBIL STATUS SESUAI DATABASE =====
                                        // Status di database: pending, approved, rejected
                                        $status = $karcis['status_verifikasi'] ?? 'pending';
                                        $badgeClass = ($status === 'approved') ? 'verified' : 
                                                      (($status === 'rejected') ? 'rejected' : 'waiting');
                                        $statusText = ($status === 'approved') ? 'Diverifikasi' : 
                                                      (($status === 'rejected') ? 'Ditolak' : 'Menunggu');
                                        ?>
                                        <tr>
                                            <td><strong><?= $karcis['no_karcis'] ?? 'N/A' ?></strong></td>
                                            <td><?= $karcis['nama_pemilik'] ?? 'N/A' ?></td>
                                            <td><?= $karcis['nama_kapal'] ?? 'N/A' ?></td>
                                            <td><?= $karcis['jenis_ikan'] ?? 'N/A' ?></td>
                                            <td><?= $karcis['berat'] ?? '0' ?></td>
                                            <td>Rp <?= isset($karcis['harga']) ? number_format($karcis['harga'], 0, ',', '.') : '0' ?></td>
                                            <td><?= isset($karcis['tanggal']) ? date('d/m/Y', strtotime($karcis['tanggal'])) : 
                                                (isset($karcis['created_at']) ? date('d/m/Y', strtotime($karcis['created_at'])) : 'N/A') ?></td>
                                            <td>
                                                <span class="badge-modern <?= $badgeClass ?>">
                                                    <i class="fas <?= $badgeClass === 'verified' ? 'fa-check-circle' : 
                                                                     ($badgeClass === 'rejected' ? 'fa-times-circle' : 'fa-clock') ?>"></i> 
                                                    <?= $statusText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <?php if ($status === 'pending'): ?>
                                                    <form method="post" action="<?= site_url('admin/update-status-kapal') ?>" style="display:inline;">
                                                        <input type="hidden" name="karcis_id" value="<?= $karcis_id ?>">
                                                        <input type="hidden" name="primary_key" value="<?= $primary_key ?>">
                                                        <input type="hidden" name="action" value="verify">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Verifikasi karcis ini?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form method="post" action="<?= site_url('admin/update-status-kapal') ?>" style="display:inline;">
                                                        <input type="hidden" name="karcis_id" value="<?= $karcis_id ?>">
                                                        <input type="hidden" name="primary_key" value="<?= $primary_key ?>">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak karcis ini?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                    <button class="btn btn-sm btn-info" onclick="lihatDetail(<?= $karcis_id ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state-modern">
                                                <i class="fas fa-ship fa-4x mb-3" style="color: #3498DB; opacity: 0.5;"></i>
                                                <h4 class="mb-3">Tidak ada data karcis kapal</h4>
                                                <p class="text-muted">Belum ada data karcis kapal yang menunggu verifikasi.</p>
                                                <a href="<?= site_url('admin/input-karcis-kapal') ?>" class="btn btn-modern btn-modern-primary">
                                                    <i class="fas fa-plus me-2"></i> Input Karcis Kapal
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-4 text-center text-muted">
                    <small>
                        <i class="fas fa-copyright me-1"></i>
                        <?= date('Y') ?> Sistem Lelang Ikan TPI • 
                        <i class="fas fa-database me-1 ms-3"></i>
                        Total Data: <?= !empty($karcis_data) ? count($karcis_data) : '0' ?> karcis • 
                        <i class="fas fa-clock me-1 ms-3"></i>
                        <?= date('H:i') ?> WIB
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // STICKY NAVBAR - Tambah efek saat scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        function refreshData() {
            location.reload();
        }
        
        function printPage() {
            window.print();
        }
        
        function lihatDetail(id) {
            // Redirect ke halaman detail
            window.location.href = `<?= site_url('admin/detail-karcis-kapal/') ?>${id}`;
        }
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table-modern tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('.table-modern tbody tr');
            
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    const badgeElement = row.querySelector('.badge-modern');
                    if (badgeElement) {
                        const rowStatus = badgeElement.textContent.toLowerCase();
                        row.style.display = rowStatus.includes(status) ? '' : 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>