<?php
$title = 'Input Karcis Bakul - Sistem TPI';
$nama_lengkap = session()->get('nama_lengkap') ?? 'Petugas TPI';
$tpi_id = session()->get('tpi_id') ?? 1;
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
    
    <style>
        /* ===== RESET & GLOBAL STYLES ===== */
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }
        
        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }
        
        body {
            background-color: #F5F7FB;
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
        }
        
        /* ===== APP CONTAINER ===== */
        .app-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
            position: relative;
        }
        
        /* ===== SIDEBAR - FIXED ===== */
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
            transition: transform 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
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
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
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
            text-align: left;
        }
        
        /* ===== MAIN CONTENT - FIXED ===== */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - 260px);
            position: relative;
        }
        
        /* ===== TOP BAR - FIXED ===== */
        .top-bar {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
        
        /* ===== FORM CONTAINER ===== */
        .form-container {
            flex: 1;
            padding: 30px;
            width: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .form-card {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--light-1);
        }
        
        .form-header h2 {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: var(--text-secondary);
            margin: 0;
        }
        
        .form-section {
            margin-bottom: 30px;
            width: 100%;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-blue);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary-blue);
        }
        
        /* ===== FORM STYLES ===== */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .form-label .required {
            color: #dc3545;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 255, 0.25);
        }
        
        .input-group {
            width: 100%;
        }
        
        .input-group-text {
            background-color: var(--light-1);
            border: 2px solid #e9ecef;
            border-right: none;
        }
        
        /* ===== CALCULATION SECTION ===== */
        .calculation-section {
            background: linear-gradient(135deg, #f0f7ff, #e6f0ff);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border-left: 5px solid var(--primary-blue);
            width: 100%;
        }
        
        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 102, 255, 0.1);
        }
        
        .calculation-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 18px;
            color: var(--primary-blue);
        }
        
        /* ===== ACTION BUTTONS ===== */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid var(--light-1);
            width: 100%;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-blue), #4D94FF);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            flex: 1;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 102, 255, 0.3);
        }
        
        .btn-reset {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            flex: 1;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .btn-reset:hover {
            background: #5a6268;
            transform: translateY(-3px);
        }
        
        /* ===== ALERT MESSAGES ===== */
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: none;
            border-radius: 10px;
            padding: 20px;
            border-left: 5px solid var(--success);
            width: 100%;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border: none;
            border-radius: 10px;
            padding: 20px;
            border-left: 5px solid #dc3545;
            width: 100%;
        }
        
        /* ===== MOBILE MENU ===== */
        .mobile-menu-btn {
            display: none;
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
            cursor: pointer;
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }
            
            .form-card {
                padding: 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px 20px;
            }
            
            .date-time {
                text-align: left;
            }
            
            .welcome-section h1 {
                font-size: 20px;
            }
        }
        
        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        * {
            scrollbar-width: thin;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }
        
        /* Prevent horizontal scroll */
        body, .main-content, .form-container, .form-card, .form-section {
            overflow-x: hidden !important;
        }
        
        /* Contoh Data Card */
        .contoh-data-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            border: 1px solid var(--border-color);
            margin-top: 20px;
            width: 100%;
        }
        
        /* Row fixes */
        .row {
            margin-left: 0;
            margin-right: 0;
            width: 100%;
        }
        
        .col-md-6, .col-md-4, .col-12 {
            padding-left: 12px;
            padding-right: 12px;
        }
        
        .mb-3 {
            margin-bottom: 1rem !important;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn">
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
                
                <a href="<?= site_url('/petugas/input-bakul') ?>" class="nav-item active">
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
                    <h1>Input Karcis Bakul</h1>
                    <p>Form input data karcis untuk bakul ikan | <?= $nama_lengkap ?></p>
                </div>
                
                <div class="date-time">
                    <div class="current-date" id="currentDate"></div>
                    <div class="current-time" id="currentTime"></div>
                </div>
            </div>
            
            <!-- FORM CONTAINER -->
            <div class="form-container">
                <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Periksa kesalahan berikut:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-shopping-basket me-2"></i> Form Input Karcis Bakul</h2>
                        <p>Isi data karcis bakul ikan dengan lengkap dan benar</p>
                    </div>
                    
                    <form id="karcisBakulForm" action="<?= site_url('/petugas/save-bakul') ?>" method="POST">
                        <!-- Section 1: Data Pemilik Bakul -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-user"></i> Data Pemilik Bakul
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user-tag"></i> Nama Pemilik Bakul
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" id="nama_bakul" name="nama_bakul" 
                                           class="form-control" placeholder="Contoh: Ahmad Supriyadi" 
                                           value="<?= old('nama_bakul') ?>" required>
                                    <small class="text-muted">Nama pemilik bakul ikan</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt"></i> Alamat
                                        <span class="required">*</span>
                                    </label>
                                    <textarea id="alamat" name="alamat" class="form-control" 
                                              rows="2" placeholder="Contoh: Jl. Pelabuhan No. 12, RT 01/RW 03" 
                                              required><?= old('alamat') ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section 2: Data Ikan & Transaksi -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-fish"></i> Data Ikan & Transaksi
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-balance-scale"></i> Berat Ikan (kg)
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" id="berat_ikan" name="berat_ikan" 
                                               class="form-control" step="0.1" min="0.1" max="1000" 
                                               placeholder="Contoh: 25.5" 
                                               value="<?= old('berat_ikan') ?>" required>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-receipt"></i> Jumlah Karcis
                                        <span class="required">*</span>
                                    </label>
                                    <input type="number" id="jumlah_karcis" name="jumlah_karcis" 
                                           class="form-control" min="1" max="100" 
                                           placeholder="Contoh: 2" 
                                           value="<?= old('jumlah_karcis', 1) ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-money-bill-wave"></i> Jumlah Pembelian (Rp)
                                        <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" id="jumlah_pembelian" name="jumlah_pembelian" 
                                               class="form-control" step="1000" min="1000" 
                                               placeholder="Contoh: 2500000" 
                                               value="<?= old('jumlah_pembelian') ?>" required>
                                    </div>
                                    <small class="text-muted">Harga total ikan</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-handshake"></i> Jasa Lelang (Rp)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" id="jasa_lelang" name="jasa_lelang" 
                                               class="form-control" step="1000" min="0" 
                                               placeholder="Contoh: 125000" 
                                               value="<?= old('jasa_lelang', 0) ?>">
                                    </div>
                                    <small class="text-muted">Biaya jasa lelang (opsional)</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-list-alt"></i> Biaya Lain-lain (Rp)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" id="lain_lain" name="lain_lain" 
                                               class="form-control" step="1000" min="0" 
                                               placeholder="Contoh: 50000" 
                                               value="<?= old('lain_lain', 0) ?>">
                                    </div>
                                    <small class="text-muted">Biaya tambahan lainnya (opsional)</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section 3: Perhitungan Total -->
                        <div class="calculation-section">
                            <h5 class="mb-3"><i class="fas fa-calculator me-2"></i> Perhitungan Total</h5>
                            
                            <div class="calculation-row">
                                <span>Jumlah Pembelian:</span>
                                <span id="displayJumlahPembelian">Rp 0</span>
                            </div>
                            
                            <div class="calculation-row">
                                <span>Jasa Lelang:</span>
                                <span id="displayJasaLelang">Rp 0</span>
                            </div>
                            
                            <div class="calculation-row">
                                <span>Biaya Lain-lain:</span>
                                <span id="displayLainLain">Rp 0</span>
                            </div>
                            
                            <div class="calculation-row">
                                <span><strong>Total Bayar:</strong></span>
                                <span id="displayTotal" style="font-size: 20px; color: #0066FF;">Rp 0</span>
                                <input type="hidden" id="total" name="total" value="0">
                                <input type="hidden" id="jumlah_bayar" name="jumlah_bayar" value="0">
                            </div>
                        </div>
                        
                        <!-- Hidden Fields -->
                        <input type="hidden" name="status_verifikasi" value="pending">
                        <input type="hidden" name="petugas_id" value="<?= session()->get('user_id') ?? 1 ?>">
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save me-2"></i> Simpan Karcis Bakul
                            </button>
                            <button type="button" class="btn-reset" id="resetForm">
                                <i class="fas fa-redo me-2"></i> Reset Form
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Contoh Data -->
                <div class="contoh-data-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i> Contoh Data untuk Testing</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Klik tombol di bawah untuk mengisi form dengan data contoh:</p>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="fillExample1()">
                                    <i class="fas fa-user me-1"></i> Contoh 1
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-success w-100" onclick="fillExample2()">
                                    <i class="fas fa-user me-1"></i> Contoh 2
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-warning w-100" onclick="fillExample3()">
                                    <i class="fas fa-user me-1"></i> Contoh 3
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
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
            
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Format number to Rupiah
            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            
            // Auto calculate total
            function calculateTotal() {
                const jumlahPembelian = parseFloat(document.getElementById('jumlah_pembelian').value) || 0;
                const jasaLelang = parseFloat(document.getElementById('jasa_lelang').value) || 0;
                const lainLain = parseFloat(document.getElementById('lain_lain').value) || 0;
                
                // Update display
                document.getElementById('displayJumlahPembelian').textContent = formatRupiah(jumlahPembelian);
                document.getElementById('displayJasaLelang').textContent = formatRupiah(jasaLelang);
                document.getElementById('displayLainLain').textContent = formatRupiah(lainLain);
                
                // Calculate total
                const total = jumlahPembelian + jasaLelang + lainLain;
                document.getElementById('displayTotal').textContent = formatRupiah(total);
                document.getElementById('total').value = total;
                document.getElementById('jumlah_bayar').value = total;
            }
            
            // Add event listeners for calculation
            document.getElementById('jumlah_pembelian').addEventListener('input', calculateTotal);
            document.getElementById('jasa_lelang').addEventListener('input', calculateTotal);
            document.getElementById('lain_lain').addEventListener('input', calculateTotal);
            
            // Initial calculation
            calculateTotal();
            
            // Reset form
            document.getElementById('resetForm').addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang sudah diisi akan hilang.')) {
                    document.getElementById('karcisBakulForm').reset();
                    calculateTotal();
                }
            });
            
            // Form validation before submit
            document.getElementById('karcisBakulForm').addEventListener('submit', function(e) {
                // Check if total is zero
                const total = parseFloat(document.getElementById('total').value) || 0;
                if (total <= 0) {
                    e.preventDefault();
                    alert('Total harus lebih dari 0. Periksa kembali data yang diisi.');
                    return false;
                }
                
                // Check required fields
                const requiredFields = ['nama_bakul', 'alamat', 'berat_ikan', 'jumlah_karcis', 'jumlah_pembelian'];
                for (let field of requiredFields) {
                    const element = document.getElementById(field);
                    if (!element.value.trim()) {
                        e.preventDefault();
                        alert(`Field ${element.previousElementSibling.textContent} harus diisi!`);
                        element.focus();
                        return false;
                    }
                }
                
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                submitBtn.disabled = true;
                
                // Re-enable after 3 seconds (in case of error)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            });
            
            // Auto fill contoh data
            window.fillExample1 = function() {
                document.getElementById('nama_bakul').value = 'Ahmad Supriyadi';
                document.getElementById('alamat').value = 'Jl. Pelabuhan No. 12, RT 01/RW 03, Kelurahan Tambakrejo, Kecamatan Semarang Utara';
                document.getElementById('berat_ikan').value = '25.5';
                document.getElementById('jumlah_karcis').value = '2';
                document.getElementById('jumlah_pembelian').value = '2500000';
                document.getElementById('jasa_lelang').value = '125000';
                document.getElementById('lain_lain').value = '0';
                calculateTotal();
            };
            
            window.fillExample2 = function() {
                document.getElementById('nama_bakul').value = 'Siti Rahayu';
                document.getElementById('alamat').value = 'Dusun Sumberagung, Desa Wonosari, Kecamatan Jepara';
                document.getElementById('berat_ikan').value = '18.2';
                document.getElementById('jumlah_karcis').value = '1';
                document.getElementById('jumlah_pembelian').value = '1500000';
                document.getElementById('jasa_lelang').value = '75000';
                document.getElementById('lain_lain').value = '25000';
                calculateTotal();
            };
            
            window.fillExample3 = function() {
                document.getElementById('nama_bakul').value = 'Budi Santoso';
                document.getElementById('alamat').value = 'Perumahan Griya Asri Blok C No. 5, Kota Tegal';
                document.getElementById('berat_ikan').value = '35.8';
                document.getElementById('jumlah_karcis').value = '3';
                document.getElementById('jumlah_pembelian').value = '3500000';
                document.getElementById('jasa_lelang').value = '175000';
                document.getElementById('lain_lain').value = '50000';
                calculateTotal();
            };
            
            // Prevent horizontal scroll on window resize
            window.addEventListener('resize', function() {
                document.body.style.overflowX = 'hidden';
                document.querySelector('.main-content').style.overflowX = 'hidden';
            });
        });
    </script>
</body>
</html>