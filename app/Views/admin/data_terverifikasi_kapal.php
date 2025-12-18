<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kapal Terverifikasi - Sistem Lelang Ikan TPI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
        
        /* Sidebar Modern - SAMA SEPERTI HALAMAN LAIN */
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
        
        /* HIDE SCROLLBAR */
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
        
        /* Badge Colors */
        .badge-success-custom {
            background: linear-gradient(135deg, #27AE60, #2ECC71);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-info-custom {
            background: linear-gradient(135deg, #3498DB, #2980B9);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
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
        
        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border-left: 4px solid #3498DB;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stats-icon-success {
            background: rgba(39, 174, 96, 0.1);
            color: #27AE60;
        }
        
        .stats-icon-primary {
            background: rgba(52, 152, 219, 0.1);
            color: #3498DB;
        }
        
        .stats-icon-warning {
            background: rgba(243, 156, 18, 0.1);
            color: #F39C12;
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
                    <span class="badge"><?= $total_terverifikasi ?? 0 ?></span>
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
            <!-- Sidebar (SAMA SEPERTI HALAMAN LAIN) -->
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
                            <a href="#" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 dropdown-toggle active" 
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
                            <i class="fas fa-ship me-3" style="color: #27AE60;"></i>
                            DATA KAPAL TERVERIFIKASI
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2" style="color: #3498DB;"></i>
                            Daftar lengkap data kapal yang sudah diverifikasi dan siap untuk proses lelang
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-modern-outline" onclick="exportToExcel()">
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
                            <div class="d-flex align-items-center">
                                <div class="stats-icon stats-icon-success me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0"><?= $total_terverifikasi ?></h4>
                                    <p class="text-muted mb-0">Total Terverifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon stats-icon-primary me-3">
                                    <i class="fas fa-database"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0"><?= $table_name ?></h4>
                                    <p class="text-muted mb-0">Sumber Data</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon stats-icon-primary me-3">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0"><?= $primary_key ?></h4>
                                    <p class="text-muted mb-0">Primary Key</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon stats-icon-warning me-3">
                                    <i class="fas fa-weight"></i>
                                </div>
                                <div>
                                    <?php
                                        $totalBerat = 0;
                                        foreach ($karcis_data as $data) {
                                            $totalBerat += $data['berat'] ?? 0;
                                        }
                                    ?>
                                    <h4 class="fw-bold mb-0"><?= number_format($totalBerat, 1) ?></h4>
                                    <p class="text-muted mb-0">Total Berat (Kg)</p>
                                </div>
                            </div>
                        </div>
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

                <!-- Data Table -->
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0" style="color: #2C3E50;">
                            <i class="fas fa-list me-2"></i>
                            Daftar Data Terverifikasi
                        </h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-modern" id="searchInput" 
                                   placeholder="Cari data..." style="min-width: 250px;">
                            <button class="btn btn-modern btn-modern-outline" onclick="filterData()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <?php if (!empty($karcis_data)): ?>
                        <div class="table-responsive">
                            <table class="table table-modern table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No. Karcis</th>
                                        <th>Nama Kapal</th>
                                        <th>Nahkoda</th>
                                        <th>Jenis Ikan</th>
                                        <th>Berat (Kg)</th>
                                        <th>Daerah Tangkapan</th>
                                        <th>Tanggal Datang</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($karcis_data as $index => $data): ?>
                                        <tr>
                                            <td>
                                                <strong><?= $data['no_karcis'] ?? 'N/A' ?></strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-ship me-2 text-primary"></i>
                                                <?= $data['nama_kapal'] ?? 'N/A' ?>
                                            </td>
                                            <td><?= $data['nahkoda'] ?? 'Tidak diketahui' ?></td>
                                            <td>
                                                <span class="badge bg-info bg-opacity-10 text-info">
                                                    <?= $data['jenis_ikan'] ?? 'N/A' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?= $data['berat'] ?? '0' ?></span> kg
                                            </td>
                                            <td>
                                                <?= $data['daerah_tangkapan'] ?? 'Tidak diketahui' ?>
                                            </td>
                                            <td>
                                                <?= isset($data['tanggal_datang']) ? date('d/m/Y', strtotime($data['tanggal_datang'])) : 
                                                   (isset($data['created_at']) ? date('d/m/Y', strtotime($data['created_at'])) : 'N/A') ?>
                                            </td>
                                            <td>
                                                <span class="badge-success-custom">
                                                    <i class="fas fa-check me-1"></i>
                                                    <?= $data['status'] ?? 'diverifikasi' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            onclick="viewDetail(<?= $index ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                                            onclick="printKarcis('<?= $data['no_karcis'] ?? '' ?>')">
                                                        <i class="fas fa-print"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination Info -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Menampilkan <strong><?= count($karcis_data) ?></strong> data terverifikasi
                            </div>
                            <nav>
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-ship fa-4x" style="color: #ECF0F1;"></i>
                            </div>
                            <h4 class="text-muted mb-3">Belum ada data terverifikasi</h4>
                            <p class="text-muted mb-4">Data kapal yang sudah diverifikasi akan muncul di sini</p>
                            <a href="<?= site_url('admin/verifikasi-karcis-kapal') ?>" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Ke Halaman Verifikasi
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer -->
                <div class="mt-4 text-center text-muted">
                    <small>
                        <i class="fas fa-copyright me-1"></i>
                        <?= date('Y') ?> Sistem Lelang Ikan TPI • 
                        <i class="fas fa-ship me-1 ms-3"></i>
                        Data Kapal Terverifikasi • 
                        <i class="fas fa-clock me-1 ms-3"></i>
                        <?= date('H:i') ?> WIB
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Kapal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Detail akan diisi oleh JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modern btn-modern-outline" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // STICKY NAVBAR
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // View Detail Function
        function viewDetail(index) {
            const data = <?= json_encode($karcis_data) ?>;
            const item = data[index];
            
            let detailHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Informasi Kapal</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">No. Karcis</th>
                                <td>${item.no_karcis || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Nama Kapal</th>
                                <td>${item.nama_kapal || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Nahkoda</th>
                                <td>${item.nahkoda || 'Tidak diketahui'}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kapal</th>
                                <td>${item.jenis_kapal || 'Tidak diketahui'}</td>
                            </tr>
                            <tr>
                                <th>No. Registrasi</th>
                                <td>${item.no_registrasi || 'Tidak tersedia'}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Informasi Tangkapan</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Jenis Ikan</th>
                                <td>${item.jenis_ikan || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Berat Tangkapan</th>
                                <td>${item.berat || 0} kg</td>
                            </tr>
                            <tr>
                                <th>Jumlah Peti</th>
                                <td>${item.jumlah_peti || 0} peti</td>
                            </tr>
                            <tr>
                                <th>Daerah Tangkapan</th>
                                <td>${item.daerah_tangkapan || 'Tidak diketahui'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Waktu Pelayaran</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Tanggal Berangkat</th>
                                <td>${item.tanggal_berangkat || 'Tidak diketahui'}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Datang</th>
                                <td>${item.tanggal_datang || 'Tidak diketahui'}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Informasi Tambahan</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Status</th>
                                <td>
                                    <span class="badge bg-success">${item.status || 'diverifikasi'}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Input</th>
                                <td>${item.created_at || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>${item.kondisi_tangkapan || 'Baik'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-muted">Catatan</h6>
                        <div class="border rounded p-3">
                            ${item.catatan || 'Tidak ada catatan tambahan'}
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('modalBody').innerHTML = detailHtml;
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }

        // Search Function
        function filterData() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('dataTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell.textContent.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }
                
                row.style.display = found ? '' : 'none';
            }
        }

        // Print Karcis
        function printKarcis(noKarcis) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Cetak Karcis ${noKarcis}</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        .header { text-align: center; margin-bottom: 30px; }
                        .content { margin: 20px 0; }
                        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                        td, th { padding: 8px; border: 1px solid #ddd; }
                        .footer { margin-top: 50px; text-align: center; font-size: 12px; }
                        @media print {
                            body { padding: 0; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>SISTEM LELANG IKAN TPI</h2>
                        <h3>KARCIS KAPAL TERVERIFIKASI</h3>
                        <h4>No: ${noKarcis}</h4>
                    </div>
                    <div class="content">
                        <p>Karcis ini menunjukkan bahwa data kapal telah diverifikasi dan siap untuk proses lelang.</p>
                        <p><strong>Tanggal Cetak:</strong> ${new Date().toLocaleDateString('id-ID')}</p>
                    </div>
                    <div class="footer">
                        <p>Dicetak oleh: Admin Sistem Lelang Ikan TPI</p>
                        <p>${new Date().toLocaleString('id-ID')}</p>
                    </div>
                    <div class="no-print" style="text-align: center; margin-top: 30px;">
                        <button onclick="window.print()">Cetak</button>
                        <button onclick="window.close()">Tutup</button>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        // Export to Excel
        function exportToExcel() {
            // Simple Excel export simulation
            const table = document.getElementById('dataTable');
            let csv = [];
            
            // Get headers
            const headers = [];
            for (let i = 0; i < table.rows[0].cells.length; i++) {
                headers.push(table.rows[0].cells[i].innerText);
            }
            csv.push(headers.join(','));
            
            // Get rows
            for (let i = 1; i < table.rows.length; i++) {
                const row = table.rows[i];
                if (row.style.display !== 'none') {
                    const rowData = [];
                    for (let j = 0; j < row.cells.length; j++) {
                        rowData.push(row.cells[j].innerText);
                    }
                    csv.push(rowData.join(','));
                }
            }
            
            // Download CSV
            const csvContent = "data:text/csv;charset=utf-8," + csv.join('\n');
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "data_kapal_terverifikasi.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showNotification('Data berhasil di-export!');
        }

        // Print Page
        function printPage() {
            window.print();
        }

        // Show notification
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'position-fixed top-0 end-0 m-4 p-3 glass-card';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 me-3" style="background: rgba(52, 152, 219, 0.1);">
                        <i class="fas fa-check" style="color: #3498DB;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>Notifikasi</strong>
                        <p class="mb-0">${message}</p>
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Search on Enter key
            document.getElementById('searchInput').addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    filterData();
                }
            });
            
            // Show welcome message
            setTimeout(() => {
                if (<?= $total_terverifikasi ?> > 0) {
                    showNotification('Data kapal terverifikasi siap ditampilkan!');
                }
            }, 1000);
        });
    </script>
</body>
</html>