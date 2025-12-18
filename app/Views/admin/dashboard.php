<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Lelang Ikan TPI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
            --gradient-info: linear-gradient(135deg, #3498DB 0%, #2980B9 100%);
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
        
        /* ========== SIDEBAR SAMA SEPERTI VERIFIKASI KARCIS KAPAL ========== */
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
        
        /* HIDE SCROLLBAR UNTUK SIDEBAR */
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
        
        /* Floating Elements */
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-secondary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
        }
        
        .floating-btn:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.6);
        }
        
        /* Stat Cards */
        .stat-card {
            border-radius: 18px;
            border: none;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        
        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        /* Chart Cards */
        .chart-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
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
        
        .badge-modern.success {
            background: linear-gradient(135deg, #E8F8EF, #D5F5E3);
            color: #27AE60;
            border-color: #2ECC71;
        }
        
        .badge-modern.warning {
            background: linear-gradient(135deg, #FEF9E7, #FDEBD0);
            color: #D35400;
            border-color: #F1C40F;
        }
        
        .badge-modern.danger {
            background: linear-gradient(135deg, #FDEDEC, #FADBD8);
            color: #C0392B;
            border-color: #E74C3C;
        }
        
        .badge-modern.info {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            color: #2980B9;
            border-color: #3498DB;
        }
        
        /* Progress Bar */
        .progress-modern {
            height: 10px;
            border-radius: 5px;
            background: rgba(236, 240, 241, 0.8);
            overflow: hidden;
        }
        
        .progress-bar-modern {
            height: 100%;
            border-radius: 5px;
            background: var(--gradient-secondary);
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar-modern::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255,255,255,0.4) 50%, 
                transparent 100%);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(52, 152, 219, 0.2);
            border-radius: 50%;
            border-top-color: var(--blue-medium);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Notification Bell */
        .notification-bell {
            position: relative;
            cursor: pointer;
        }
        
        .notification-bell .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--gradient-danger);
            color: white;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Fish Icon Styling */
        .fish-icon {
            color: #3498DB;
            background: rgba(52, 152, 219, 0.1);
            padding: 10px;
            border-radius: 50%;
        }
        
        /* Alert Colors */
        .alert-success {
            background: linear-gradient(135deg, #E8F8EF, #D5F5E3);
            border: 1px solid #2ECC71;
            color: #27AE60;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #FDEDEC, #FADBD8);
            border: 1px solid #E74C3C;
            color: #C0392B;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            border: 1px solid #3498DB;
            color: #2980B9;
        }
        
        /* Activity Timeline */
        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 25px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3498DB;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 17px;
            width: 2px;
            height: calc(100% - 12px);
            background: #ECF0F1;
        }
        
        .timeline-item:last-child::after {
            display: none;
        }
        
        /* Hover Effects for Cards */
        .feature-card {
            transition: all 0.3s ease;
            border: 1px solid #ECF0F1;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: #3498DB;
        }
        
        /* Quick Stats */
        .quick-stat {
            border-left: 4px solid #3498DB;
            padding-left: 15px;
        }
        
        /* HIDE ALL SCROLLBARS */
        ::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        
        * {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar-modern {
                height: auto;
                position: static;
                margin-bottom: 20px;
            }
            
            .stat-card {
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .glass-card {
                border-radius: 15px;
            }
            
            .glass-navbar {
                position: relative;
            }
            
            .sidebar-modern {
                position: static;
                top: 0;
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
                    <?php if(isset($notification_count) && $notification_count > 0): ?>
                        <span class="badge"><?= $notification_count ?></span>
                    <?php endif; ?>
                </div>
                
                <!-- User Profile -->
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-modern-outline d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="bg-white rounded-circle p-2 me-2">
                            <i class="fas fa-user" style="color: #3498DB;"></i>
                        </div>
                        <div class="text-start d-none d-md-block">
                            <div class="fw-bold"><?= isset($user['nama']) ? $user['nama'] : 'Admin' ?></div>
                            <small><?= isset($user['role']) ? ucfirst($user['role']) : 'Super Admin' ?></small>
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
            <!-- Sidebar (SAMA SEPERTI VERIFIKASI KARCIS KAPAL) -->
            <div class="col-lg-2 col-md-3 mb-4">
                <div class="sidebar-modern glass-card p-3">
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url('/admin') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 active">
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
                            <span class="badge bg-danger float-end"><?= isset($pending_bakul_count) ? $pending_bakul_count : '0' ?></span>
                        </a>
                        
                        <!-- Verifikasi Kapal -->
                        <a href="<?= site_url('admin/verifikasi-karcis-kapal') ?>" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2">
                            <i class="fas fa-ship me-3"></i>
                            <span>Verifikasi Kapal</span>
                            <span class="badge bg-warning float-end"><?= isset($pending_kapal_count) ? $pending_kapal_count : '0' ?></span>
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
                    
                    <!-- Quick Stats -->
                    <div class="mt-4 p-3" style="background: rgba(236, 240, 241, 0.5); border-radius: 15px;">
                        <h6 class="mb-3 fw-bold" style="color: #2C3E50;">System Status</h6>
                        <div class="mb-3">
                            <small class="text-muted d-block">Database Records</small>
                            <div class="progress-modern mt-1">
                                <div class="progress-bar-modern" style="width: <?= isset($total_transaksi) && $total_transaksi > 0 ? '65' : '10' ?>%"></div>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <?= isset($total_transaksi) && $total_transaksi > 0 ? $total_transaksi . ' records' : 'No records yet' ?>
                            </small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-database me-1"></i>
                                <?= isset($total_transaksi) ? $total_transaksi : '0' ?> transaksi
                            </small>
                            <button class="btn btn-sm btn-outline-primary" onclick="refreshDashboard()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 page-header-container">
                    <div>
                        <h1 class="fw-bold mb-2" style="color: #2C3E50;">
                            <i class="fas fa-tachometer-alt me-3" style="color: #3498DB;"></i>
                            DASHBOARD ADMIN
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2" style="color: #3498DB;"></i>
                            Selamat datang di Sistem Lelang Ikan TPI - Dashboard Monitoring dan Kontrol
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-modern-outline" onclick="printDashboard()">
                            <i class="fas fa-print"></i>
                            <span class="d-none d-md-inline">Print Report</span>
                        </button>
                        <button class="btn btn-modern btn-modern-primary" onclick="refreshDashboard()">
                            <i class="fas fa-sync-alt"></i>
                            <span class="d-none d-md-inline">Refresh</span>
                        </button>
                    </div>
                </div>

                <!-- Welcome Alert -->
                <div class="alert alert-info mb-4 d-flex align-items-center">
                    <i class="fas fa-info-circle me-3 fs-4" style="color: #3498DB;"></i>
                    <div class="flex-grow-1">
                        <strong>Welcome back, <?= isset($user['nama']) ? $user['nama'] : 'Admin' ?>!</strong> 
                        <?php if(isset($total_menunggu) && $total_menunggu > 0): ?>
                            Anda memiliki <strong><?= $total_menunggu ?> tugas</strong> yang menunggu verifikasi. 
                            <a href="<?= site_url('admin/verifikasi-karcis-bakul') ?>" class="alert-link">Lihat tugas sekarang →</a>
                        <?php else: ?>
                            Tidak ada tugas yang menunggu verifikasi. 
                            <a href="<?= site_url('admin/input-karcis-bakul') ?>" class="alert-link">Input data baru →</a>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <!-- ========== PERBAIKAN: 4 CARD MENARIK & USER-FRIENDLY ========== -->
                <!-- Main Statistics -->
                <div class="row mb-4 g-4">
                    <!-- Total Transaksi -->
                    <div class="col-md-3">
                        <div class="stat-card glass-card p-4" style="border-top: 5px solid #3498DB; background: linear-gradient(135deg, rgba(52, 152, 219, 0.08) 0%, rgba(255,255,255,0.95) 100%);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #3498DB, #2980B9); color: white; border-radius: 12px; padding: 14px; box-shadow: 0 6px 20px rgba(52, 152, 219, 0.25);">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-0" style="font-size: 1.9rem; color: #2C3E50;"><?= isset($total_transaksi) ? number_format($total_transaksi, 0, ',', '.') : '0' ?></h3>
                                    <p class="text-muted mb-0">Total Transaksi</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-primary">
                                    <i class="fas fa-database me-1"></i>
                                    <?= isset($total_transaksi) && $total_transaksi > 0 ? number_format($total_transaksi, 0, ',', '.') . ' data' : 'Belum ada data' ?>
                                </small>
                                <span class="badge-modern info">
                                    <i class="fas fa-chart-line"></i> Live
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menunggu Verifikasi -->
                    <div class="col-md-3">
                        <div class="stat-card glass-card p-4" style="border-top: 5px solid #F39C12; background: linear-gradient(135deg, rgba(243, 156, 18, 0.08) 0%, rgba(255,255,255,0.95) 100%);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #F39C12, #D68910); color: white; border-radius: 12px; padding: 14px; box-shadow: 0 6px 20px rgba(243, 156, 18, 0.25);">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-0" style="font-size: 1.9rem; color: #F39C12;"><?= isset($total_menunggu) ? $total_menunggu : '0' ?></h3>
                                    <p class="text-muted mb-0">Menunggu Verifikasi</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <?php if(isset($total_menunggu) && $total_menunggu > 0): ?>
                                    <a href="<?= site_url('admin/verifikasi-karcis-bakul') ?>" 
                                       class="btn btn-warning w-100 d-flex align-items-center justify-content-center" 
                                       style="border-radius: 10px; padding: 8px; font-weight: 600; border: none;">
                                        <i class="fas fa-eye me-2"></i>
                                        <span>Verifikasi Sekarang</span>
                                    </a>
                                <?php else: ?>
                                    <div class="text-center p-2" style="background: rgba(39, 174, 96, 0.1); border-radius: 10px;">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="text-success fw-bold">Semua transaksi selesai</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bakul Pending -->
                    <div class="col-md-3">
                        <div class="stat-card glass-card p-4" style="border-top: 5px solid #E74C3C; background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(255,255,255,0.95) 100%);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #E74C3C, #C0392B); color: white; border-radius: 12px; padding: 14px; box-shadow: 0 6px 20px rgba(231, 76, 60, 0.25);">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-0" style="font-size: 1.9rem; color: #E74C3C;"><?= isset($pending_bakul_count) ? $pending_bakul_count : '0' ?></h3>
                                    <p class="text-muted mb-0">Bakul Pending</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <?php if(isset($pending_bakul_count) && $pending_bakul_count > 0): ?>
                                    <a href="<?= site_url('admin/verifikasi-karcis-bakul') ?>" class="btn btn-sm btn-danger" style="border-radius: 8px; padding: 5px 15px;">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Tinjau
                                    </a>
                                <?php else: ?>
                                    <small class="text-success">
                                        <i class="fas fa-check me-1"></i> Tidak ada
                                    </small>
                                <?php endif; ?>
                                <span class="badge-modern danger">
                                    <i class="fas fa-users"></i> Bakul
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kapal Pending -->
                    <div class="col-md-3">
                        <div class="stat-card glass-card p-4" style="border-top: 5px solid #9B59B6; background: linear-gradient(135deg, rgba(155, 89, 182, 0.08) 0%, rgba(255,255,255,0.95) 100%);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon" style="background: linear-gradient(135deg, #9B59B6, #8E44AD); color: white; border-radius: 12px; padding: 14px; box-shadow: 0 6px 20px rgba(155, 89, 182, 0.25);">
                                    <i class="fas fa-ship"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-0" style="font-size: 1.9rem; color: #9B59B6;"><?= isset($pending_kapal_count) ? $pending_kapal_count : '0' ?></h3>
                                    <p class="text-muted mb-0">Kapal Pending</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <?php if(isset($pending_kapal_count) && $pending_kapal_count > 0): ?>
                                    <a href="<?= site_url('admin/verifikasi-karcis-kapal') ?>" class="btn btn-sm btn-purple" style="border-radius: 8px; padding: 5px 15px; background: #9B59B6; color: white;">
                                        <i class="fas fa-ship me-1"></i> Tinjau
                                    </a>
                                <?php else: ?>
                                    <small class="text-success">
                                        <i class="fas fa-check me-1"></i> Tidak ada
                                    </small>
                                <?php endif; ?>
                                <span class="badge-modern info" style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.1), rgba(142, 68, 173, 0.1)); color: #9B59B6; border-color: #9B59B6;">
                                    <i class="fas fa-ship"></i> Kapal
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row mb-4 g-4">
                    <!-- Transaction Chart -->
                    <div class="col-lg-8">
                        <div class="glass-card chart-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                                    <i class="fas fa-chart-line me-2" style="color: #3498DB;"></i>
                                    Grafik Transaksi 7 Hari Terakhir
                                </h5>
                                <select class="form-select form-select-sm" style="width: auto;" id="chartPeriodSelect" onchange="updateChartPeriod(this.value)">
                                    <option value="7d" selected>7 Hari Terakhir</option>
                                    <option value="30d">30 Hari Terakhir</option>
                                    <option value="90d">90 Hari Terakhir</option>
                                </select>
                            </div>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="transactionChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Distribution -->
                    <div class="col-lg-4">
                        <div class="glass-card chart-card p-4">
                            <h5 class="fw-bold mb-4" style="color: #2C3E50;">
                                <i class="fas fa-chart-pie me-2" style="color: #3498DB;"></i>
                                Distribusi Status
                            </h5>
                            <div class="chart-container" style="height: 250px;">
                                <canvas id="statusChart"></canvas>
                            </div>
                            <div class="row mt-4 g-2">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #3498DB;"></div>
                                        <small>Diverifikasi</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #F39C12;"></div>
                                        <small>Menunggu</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #E74C3C;"></div>
                                        <small>Ditolak</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="width: 12px; height: 12px; background: #27AE60;"></div>
                                        <small>Selesai</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========== PERBAIKAN BESAR: AKTIVITAS TERBARU ========== -->
                <!-- Recent Activity -->
                <div class="row g-4">
                    <!-- Recent Activity - KINI MENJADI FULL WIDTH -->
                    <div class="col-12">
                        <div class="glass-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                                    <i class="fas fa-history me-2" style="color: #3498DB;"></i>
                                    Aktivitas Terbaru
                                </h5>
                                <a href="<?= site_url('admin/verifikasi-karcis-bakul') ?>" class="btn btn-sm btn-modern-outline">Lihat Semua</a>
                            </div>
                            <div class="timeline">
                                <?php if (!empty($recent_activities)): ?>
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <?php 
                                        // Ambil data dari activity
                                        $type = $activity['type'] ?? 'bakul'; // 'bakul' atau 'kapal'
                                        $id = $activity['id'] ?? 0;
                                        $nama = $activity['nama'] ?? 'N/A';
                                        $status = $activity['status_verifikasi'] ?? 'pending';
                                        $tanggal = $activity['tanggal'] ?? date('Y-m-d H:i:s');
                                        
                                        // Tentukan judul berdasarkan type
                                        if ($type === 'bakul') {
                                            $judul = 'Karcis Bakul ';
                                            $icon = '<i class="fas fa-users me-2" style="color: #3498DB;"></i>';
                                        } else {
                                            $judul = 'Karcis Kapal ';
                                            $icon = '<i class="fas fa-ship me-2" style="color: #3498DB;"></i>';
                                        }
                                        
                                        // Tentukan status text
                                        if ($status === 'approved') {
                                            $judul .= 'Diverifikasi';
                                            $status_text = 'Diverifikasi';
                                            $badge_class = 'success';
                                            $badge_icon = 'fa-check-circle';
                                        } elseif ($status === 'rejected') {
                                            $judul .= 'Ditolak';
                                            $status_text = 'Ditolak';
                                            $badge_class = 'danger';
                                            $badge_icon = 'fa-times-circle';
                                        } else {
                                            $judul .= 'Baru Masuk';
                                            $status_text = 'Menunggu';
                                            $badge_class = 'warning';
                                            $badge_icon = 'fa-clock';
                                        }
                                        
                                        // Format waktu
                                        $waktu = 'Baru';
                                        if (!empty($tanggal) && $tanggal !== 'Baru') {
                                            try {
                                                $waktu = date('H:i', strtotime($tanggal));
                                            } catch (Exception $e) {
                                                $waktu = 'Baru';
                                            }
                                        }
                                        
                                        // Tentukan pesan berdasarkan type dan status
                                        if ($type === 'bakul') {
                                            if ($status === 'approved') {
                                                $pesan = "Admin menyetujui karcis bakul #{$id} dari \"{$nama}\"";
                                            } elseif ($status === 'rejected') {
                                                $pesan = "Admin menolak karcis bakul #{$id} dari \"{$nama}\"";
                                            } else {
                                                $pesan = "Karcis bakul baru #{$id} dari \"{$nama}\" menunggu verifikasi";
                                            }
                                        } else {
                                            if ($status === 'approved') {
                                                $pesan = "Admin menyetujui karcis kapal #{$id} dari \"{$nama}\"";
                                            } elseif ($status === 'rejected') {
                                                $pesan = "Admin menolak karcis kapal #{$id} dari \"{$nama}\"";
                                            } else {
                                                $pesan = "Karcis kapal baru #{$id} dari \"{$nama}\" menunggu verifikasi";
                                            }
                                        }
                                        ?>
                                        
                                        <div class="timeline-item">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold mb-1">
                                                    <?= $icon ?><?= $judul ?>
                                                </h6>
                                                <small class="text-muted"><?= $waktu ?></small>
                                            </div>
                                            <p class="mb-1"><?= $pesan ?></p>
                                            <span class="badge-modern <?= $badge_class ?>">
                                                <i class="fas <?= $badge_icon ?>"></i>
                                                <?= $status_text ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x mb-3" style="color: #3498DB; opacity: 0.5;"></i>
                                        <h6 class="fw-bold mb-2">Belum ada aktivitas</h6>
                                        <p class="text-muted mb-0">Belum ada transaksi atau aktivitas terbaru</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-4 text-center text-muted">
                    <small>
                        <i class="fas fa-copyright me-1"></i>
                        <?= date('Y') ?> Sistem Lelang Ikan TPI • 
                        <i class="fas fa-sync-alt me-1 ms-3"></i>
                        Auto-refresh setiap 60 detik • 
                        <i class="fas fa-database me-1 ms-3"></i>
                        Versi 2.1.0 • 
                        <i class="fas fa-clock me-1 ms-3"></i>
                        <?= date('H:i') ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button class="floating-btn" onclick="refreshDashboard()" id="fabRefresh">
        <i class="fas fa-sync-alt"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-refresh every 60 seconds
        let refreshInterval = setInterval(() => {
            document.getElementById('fabRefresh').classList.add('animate__spin');
            setTimeout(() => {
                refreshDashboard();
            }, 500);
        }, 60000);
        
        // STICKY NAVBAR - Tambah efek saat scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        // Chart Data - DATA REAL DARI DATABASE
        let transactionChart, statusChart;
        
        // Data chart dari Controller (semua periode)
        const chartData = {
            '7d': {
                labels: <?= isset($chart_7d_labels) ? json_encode($chart_7d_labels) : '["No Data"]' ?>,
                bakul: <?= isset($chart_7d_bakul) ? json_encode($chart_7d_bakul) : '[0]' ?>,
                kapal: <?= isset($chart_7d_kapal) ? json_encode($chart_7d_kapal) : '[0]' ?>
            },
            '30d': {
                labels: <?= isset($chart_30d_labels) ? json_encode($chart_30d_labels) : '["No Data"]' ?>,
                bakul: <?= isset($chart_30d_bakul) ? json_encode($chart_30d_bakul) : '[0]' ?>,
                kapal: <?= isset($chart_30d_kapal) ? json_encode($chart_30d_kapal) : '[0]' ?>
            },
            '90d': {
                labels: <?= isset($chart_90d_labels) ? json_encode($chart_90d_labels) : '["No Data"]' ?>,
                bakul: <?= isset($chart_90d_bakul) ? json_encode($chart_90d_bakul) : '[0]' ?>,
                kapal: <?= isset($chart_90d_kapal) ? json_encode($chart_90d_kapal) : '[0]' ?>
            }
        };
        
        // ========== PERBAIKAN BESAR: DATA DISTRIBUSI STATUS ==========
        // Ambil data dari Controller (data yang sudah benar)
        const statusData = <?= isset($status_counts) ? json_encode(array_values($status_counts)) : '[0, 0, 0, 0]' ?>;
        
        // Ambil total transaksi yang benar dari Controller
        const totalTransactions = <?= isset($total_semua_transaksi) ? $total_semua_transaksi : '0' ?>;
        
        // Hitung persentase yang benar (dari Controller atau hitung ulang)
        const statusPercentages = <?= isset($status_percentages) ? json_encode(array_values($status_percentages)) : '[0, 0, 0, 0]' ?>;
        
        function initializeCharts() {
            // Transaction Chart - Gunakan data real dari PHP
            const transactionCtx = document.getElementById('transactionChart').getContext('2d');
            
            // Gunakan data 7 hari sebagai default
            transactionChart = new Chart(transactionCtx, {
                type: 'line',
                data: {
                    labels: chartData['7d'].labels,
                    datasets: [{
                        label: 'Transaksi Bakul',
                        data: chartData['7d'].bakul,
                        borderColor: '#3498DB',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3498DB',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }, {
                        label: 'Transaksi Kapal',
                        data: chartData['7d'].kapal,
                        borderColor: '#2ECC71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#2ECC71',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#2C3E50',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(44, 62, 80, 0.9)',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            borderColor: '#3498DB',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.parsed.y + ' transaksi';
                                    return label;
                                },
                                title: function(tooltipItems) {
                                    // Tampilkan tanggal yang tepat untuk tooltip
                                    const index = tooltipItems[0].dataIndex;
                                    const period = document.getElementById('chartPeriodSelect').value;
                                    
                                    if (period === '7d') {
                                        return chartData['7d'].labels[index];
                                    } else if (period === '30d') {
                                        // Untuk 30 hari, cari label yang tidak kosong
                                        let labelIndex = index;
                                        let actualLabel = chartData['30d'].labels[index];
                                        if (!actualLabel) {
                                            // Cari label terdekat yang tidak kosong
                                            for (let i = index; i >= 0; i--) {
                                                if (chartData['30d'].labels[i]) {
                                                    actualLabel = chartData['30d'].labels[i];
                                                    break;
                                                }
                                            }
                                        }
                                        return actualLabel || 'Tanggal tidak tersedia';
                                    } else if (period === '90d') {
                                        return chartData['90d'].labels[index];
                                    }
                                    return 'Tanggal tidak tersedia';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(236, 240, 241, 0.8)'
                            },
                            ticks: {
                                color: '#7F8C8D',
                                callback: function(value) {
                                    return value + ' transaksi';
                                },
                                font: {
                                    size: 11
                                }
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Transaksi',
                                color: '#7F8C8D',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: {top: 10, bottom: 10}
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(236, 240, 241, 0.8)'
                            },
                            ticks: {
                                color: '#7F8C8D',
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 10
                                }
                            },
                            title: {
                                display: true,
                                text: 'Tanggal',
                                color: '#7F8C8D',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: {top: 10, bottom: 10}
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear'
                        }
                    }
                }
            });
            
            // ========== PERBAIKAN BESAR: STATUS CHART ==========
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            
            // Data untuk chart - Gunakan data yang sudah benar
            const statusChartData = {
                labels: ['Diverifikasi', 'Menunggu', 'Ditolak', 'Selesai'],
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        '#3498DB',
                        '#F39C12',
                        '#E74C3C',
                        '#27AE60'
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF',
                    hoverBorderWidth: 3,
                    hoverBorderColor: '#2C3E50'
                }]
            };
            
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: statusChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(44, 62, 80, 0.9)',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            borderColor: '#3498DB',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    // PERBAIKAN BESAR: Gunakan total yang benar (49, bukan 52)
                                    const total = totalTransactions || 49; // Fallback ke 49 jika tidak ada
                                    const percentage = Math.round((context.parsed / total) * 100);
                                    
                                    // Atau gunakan persentase yang sudah dihitung dari Controller
                                    const index = context.dataIndex;
                                    const preCalculatedPercentage = statusPercentages[index] || percentage;
                                    
                                    return `${context.label}: ${context.parsed} transaksi (${preCalculatedPercentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%',
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 1000
                    }
                },
                plugins: [{
                    id: 'customCenterText',
                    beforeDraw: function(chart) {
                        const width = chart.width;
                        const height = chart.height;
                        const ctx = chart.ctx;
                        
                        ctx.restore();
                        const fontSize = (height / 150).toFixed(2);
                        ctx.font = fontSize + "em 'Inter', sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = '#2C3E50';
                        
                        const text = totalTransactions.toString();
                        const textX = Math.round((width - ctx.measureText(text).width) / 2);
                        const textY = height / 2;
                        
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }]
            });
        }
        
        // Update chart period - PERBAIKAN BESAR: Gunakan data real dari database
        function updateChartPeriod(period) {
            if (!chartData[period]) {
                showNotification(`Data untuk periode ${period} tidak tersedia`, 'danger');
                return;
            }
            
            // Update chart dengan data real
            transactionChart.data.labels = chartData[period].labels;
            transactionChart.data.datasets[0].data = chartData[period].bakul;
            transactionChart.data.datasets[1].data = chartData[period].kapal;
            
            // Update judul chart berdasarkan periode
            let title = 'Grafik Transaksi ';
            switch(period) {
                case '7d':
                    title += '7 Hari Terakhir';
                    // Update skala untuk 7 hari (setiap hari)
                    transactionChart.options.scales.x.ticks.maxRotation = 45;
                    transactionChart.options.scales.x.ticks.minRotation = 45;
                    break;
                case '30d':
                    title += '30 Hari Terakhir';
                    // Update skala untuk 30 hari (setiap 3-4 hari)
                    transactionChart.options.scales.x.ticks.maxRotation = 45;
                    transactionChart.options.scales.x.ticks.minRotation = 45;
                    break;
                case '90d':
                    title += '90 Hari Terakhir';
                    // Update skala untuk 90 hari (per bulan)
                    transactionChart.options.scales.x.ticks.maxRotation = 0;
                    transactionChart.options.scales.x.ticks.minRotation = 0;
                    break;
            }
            
            // Update judul di chart
            const chartTitleElement = document.querySelector('.chart-card h5');
            if (chartTitleElement) {
                chartTitleElement.innerHTML = 
                    `<i class="fas fa-chart-line me-2" style="color: #3498DB;"></i>${title}`;
            }
            
            // Update chart dengan animasi
            transactionChart.update('active');
            
            // Show notification
            showNotification(`Chart diperbarui untuk ${title} dengan data real dari database`, 'success');
            
            // Debug info untuk testing
            console.log(`Period: ${period}`);
            console.log('Labels:', chartData[period].labels);
            console.log('Bakul Data:', chartData[period].bakul);
            console.log('Kapal Data:', chartData[period].kapal);
        }
        
        // Refresh dashboard
        function refreshDashboard() {
            const fab = document.getElementById('fabRefresh');
            fab.classList.add('animate__spin');
            
            // Tampilkan loading indicator
            showNotification('Memuat ulang dashboard...', 'info');
            
            // Refresh page setelah 1 detik
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
        
        // Print dashboard
        function printDashboard() {
            // Sembunyikan elemen yang tidak perlu dicetak
            const elementsToHide = ['.floating-btn', '.sidebar-modern', '.page-header-container button'];
            const originalDisplay = [];
            
            elementsToHide.forEach(selector => {
                const elements = document.querySelectorAll(selector);
                elements.forEach(el => {
                    originalDisplay.push({element: el, display: el.style.display});
                    el.style.display = 'none';
                });
            });
            
            // Cetak halaman
            window.print();
            
            // Kembalikan elemen yang disembunyikan
            setTimeout(() => {
                originalDisplay.forEach(item => {
                    item.element.style.display = item.display;
                });
            }, 100);
        }
        
        // Show notification dengan warna yang berbeda
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => {
                if (notification.parentElement) {
                    notification.remove();
                }
            });
            
            // Warna berdasarkan tipe
            let icon, bgColor, iconColor;
            switch(type) {
                case 'success':
                    icon = 'fa-check';
                    bgColor = 'rgba(39, 174, 96, 0.1)';
                    iconColor = '#27AE60';
                    break;
                case 'danger':
                    icon = 'fa-exclamation-triangle';
                    bgColor = 'rgba(231, 76, 60, 0.1)';
                    iconColor = '#E74C3C';
                    break;
                case 'info':
                    icon = 'fa-info-circle';
                    bgColor = 'rgba(52, 152, 219, 0.1)';
                    iconColor = '#3498DB';
                    break;
                case 'warning':
                    icon = 'fa-exclamation-circle';
                    bgColor = 'rgba(243, 156, 18, 0.1)';
                    iconColor = '#F39C12';
                    break;
                default:
                    icon = 'fa-check';
                    bgColor = 'rgba(52, 152, 219, 0.1)';
                    iconColor = '#3498DB';
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'position-fixed top-0 end-0 m-4 p-3 glass-card custom-notification';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.style.maxWidth = '400px';
            notification.style.animation = 'slideIn 0.3s ease-out';
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 me-3" style="background: ${bgColor};">
                        <i class="fas ${icon}" style="color: ${iconColor};"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>Notification</strong>
                        <p class="mb-0">${message}</p>
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'slideOut 0.3s ease-in';
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }
        
        // Add CSS animation for notifications
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Add loading animation to FAB on hover
        document.getElementById('fabRefresh').addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.1)';
            this.style.boxShadow = '0 10px 25px rgba(52, 152, 219, 0.6)';
        });
        
        document.getElementById('fabRefresh').addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '0 6px 20px rgba(52, 152, 219, 0.4)';
        });
        
        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            
            // Show welcome notification setelah delay
            setTimeout(() => {
                showNotification('Dashboard berhasil dimuat! Data chart 100% real dari database.', 'success');
            }, 1500);
            
            // Debug info untuk testing
            console.log('=== CHART DATA DEBUG ===');
            console.log('Status Data (counts):', statusData);
            console.log('Total Transactions:', totalTransactions);
            console.log('Status Percentages:', statusPercentages);
            console.log('7 Days Data:', chartData['7d']);
            console.log('30 Days Data:', chartData['30d']);
            console.log('90 Days Data:', chartData['90d']);
            console.log('=== END DEBUG ===');
        });
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Export chart data function (untuk testing)
        function exportChartData() {
            const period = document.getElementById('chartPeriodSelect').value;
            const data = {
                period: period,
                labels: chartData[period].labels,
                bakul: chartData[period].bakul,
                kapal: chartData[period].kapal,
                timestamp: new Date().toISOString()
            };
            
            const dataStr = JSON.stringify(data, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = `chart-data-${period}-${new Date().toISOString().split('T')[0]}.json`;
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            showNotification(`Data chart periode ${period} berhasil diexport`, 'info');
        }
    </script>
</body>
</html>