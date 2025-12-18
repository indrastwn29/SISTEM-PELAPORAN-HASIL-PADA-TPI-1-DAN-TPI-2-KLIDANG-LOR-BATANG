<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Karcis Bakul - Sistem Lelang Ikan TPI</title>
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
        
        /* Form Styling */
        .form-modern {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow-md);
        }
        
        .form-control-modern {
            border: 2px solid #ECF0F1;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control-modern:focus {
            border-color: #3498DB;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .form-label-modern {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 8px;
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
            
            .form-modern {
                padding: 15px;
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
                    <span class="badge">3</span>
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
                            <a href="#" class="list-group-item list-group-item-action border-0 nav-item-modern mb-2 dropdown-toggle active" 
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
                            <i class="fas fa-users me-3" style="color: #3498DB;"></i>
                            INPUT KARCIS BAKUL
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-2" style="color: #3498DB;"></i>
                            Input data karcis dari pedagang ikan (bakul) untuk diproses dalam sistem lelang
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-modern-outline" onclick="resetForm()">
                            <i class="fas fa-redo"></i>
                            <span class="d-none d-md-inline">Reset Form</span>
                        </button>
                        <button class="btn btn-modern btn-modern-primary" onclick="saveData()">
                            <i class="fas fa-save"></i>
                            <span class="d-none d-md-inline">Simpan Data</span>
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

                <!-- Error Messages -->
                <?php if (session()->get('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div class="flex-grow-1">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                <?php foreach (session()->get('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Input -->
                <div class="glass-card p-4">
                    <form id="inputKarcisForm" method="POST" action="<?= site_url('admin/simpan-karcis-bakul') ?>">
                        <div class="row g-4">
                            <!-- Data Bakul -->
                            <div class="col-lg-6">
                                <h5 class="fw-bold mb-3" style="color: #2C3E50; border-bottom: 2px solid #3498DB; padding-bottom: 10px;">
                                    <i class="fas fa-user me-2"></i> Data Bakul
                                </h5>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Nomor Karcis</label>
                                    <input type="text" class="form-control form-control-modern" name="no_karcis" 
                                           value="<?= 'KB-' . date('Ymd') . '-' . rand(1000, 9999) ?>" readonly>
                                    <small class="text-muted">Nomor karcis otomatis di-generate</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Nama Bakul <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-modern" name="nama_bakul" 
                                           value="<?= old('nama_bakul') ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Alamat Bakul</label>
                                    <textarea class="form-control form-control-modern" name="alamat_bakul" rows="2"><?= old('alamat_bakul') ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Nomor Telepon</label>
                                    <input type="tel" class="form-control form-control-modern" name="telepon" value="<?= old('telepon') ?>">
                                </div>
                            </div>
                            
                            <!-- Data Ikan -->
                            <div class="col-lg-6">
                                <h5 class="fw-bold mb-3" style="color: #2C3E50; border-bottom: 2px solid #3498DB; padding-bottom: 10px;">
                                    <i class="fas fa-fish me-2"></i> Data Ikan
                                </h5>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Jenis Ikan <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-modern" name="jenis_ikan" required>
                                        <option value="">Pilih Jenis Ikan</option>
                                        <option value="Tongkol" <?= old('jenis_ikan') == 'Tongkol' ? 'selected' : '' ?>>Tongkol</option>
                                        <option value="Tenggiri" <?= old('jenis_ikan') == 'Tenggiri' ? 'selected' : '' ?>>Tenggiri</option>
                                        <option value="Kakap" <?= old('jenis_ikan') == 'Kakap' ? 'selected' : '' ?>>Kakap</option>
                                        <option value="Kerapu" <?= old('jenis_ikan') == 'Kerapu' ? 'selected' : '' ?>>Kerapu</option>
                                        <option value="Baronang" <?= old('jenis_ikan') == 'Baronang' ? 'selected' : '' ?>>Baronang</option>
                                        <option value="Cakalang" <?= old('jenis_ikan') == 'Cakalang' ? 'selected' : '' ?>>Cakalang</option>
                                        <option value="Tuna" <?= old('jenis_ikan') == 'Tuna' ? 'selected' : '' ?>>Tuna</option>
                                        <option value="Lemuru" <?= old('jenis_ikan') == 'Lemuru' ? 'selected' : '' ?>>Lemuru</option>
                                        <option value="Teri" <?= old('jenis_ikan') == 'Teri' ? 'selected' : '' ?>>Teri</option>
                                        <option value="Lainnya" <?= old('jenis_ikan') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-modern">Berat (Kg) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-modern" name="berat" 
                                               step="0.1" min="0" value="<?= old('berat') ?>" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-modern">Harga per Kg (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-modern" name="harga_per_kg" 
                                               min="0" value="<?= old('harga_per_kg') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Kualitas Ikan</label>
                                    <select class="form-control form-control-modern" name="kualitas">
                                        <option value="A" <?= old('kualitas') == 'A' ? 'selected' : '' ?>>A (Sangat Baik)</option>
                                        <option value="B" <?= old('kualitas') == 'B' || !old('kualitas') ? 'selected' : '' ?>>B (Baik)</option>
                                        <option value="C" <?= old('kualitas') == 'C' ? 'selected' : '' ?>>C (Cukup)</option>
                                        <option value="D" <?= old('kualitas') == 'D' ? 'selected' : '' ?>>D (Kurang)</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Tanggal Input <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-modern" name="tanggal" 
                                           value="<?= old('tanggal') ? old('tanggal') : date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            
                            <!-- Catatan -->
                            <div class="col-12">
                                <h5 class="fw-bold mb-3" style="color: #2C3E50; border-bottom: 2px solid #3498DB; padding-bottom: 10px;">
                                    <i class="fas fa-sticky-note me-2"></i> Catatan
                                </h5>
                                
                                <div class="mb-3">
                                    <label class="form-label-modern">Catatan Tambahan</label>
                                    <textarea class="form-control form-control-modern" name="catatan" rows="3" 
                                              placeholder="Masukkan catatan tambahan jika diperlukan..."><?= old('catatan') ?></textarea>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="konfirmasi" required>
                                    <label class="form-check-label" for="konfirmasi">
                                        Saya menyatakan bahwa data yang diinput adalah benar dan dapat dipertanggungjawabkan
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-modern btn-modern-outline" onclick="resetForm()">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-modern btn-modern-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Recent Inputs -->
                <div class="glass-card p-4 mt-4">
                    <h5 class="fw-bold mb-3" style="color: #2C3E50;">
                        <i class="fas fa-history me-2" style="color: #3498DB;"></i>
                        Data Terakhir Diinput
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Karcis</th>
                                    <th>Nama Bakul</th>
                                    <th>Jenis Ikan</th>
                                    <th>Berat (Kg)</th>
                                    <th>Harga (Rp)</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($recent_inputs) && !empty($recent_inputs)): ?>
                                    <?php foreach ($recent_inputs as $data): ?>
                                        <tr>
                                            <td><strong><?= $data['no_karcis'] ?></strong></td>
                                            <td><?= $data['nama_bakul'] ?></td>
                                            <td><?= $data['jenis_ikan'] ?></td>
                                            <td><?= $data['berat'] ?></td>
                                            <td>Rp <?= number_format($data['harga'] ?? 0, 0, ',', '.') ?></td>
                                            <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                                            <td>
                                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-database fa-2x mb-3" style="color: #ECF0F1;"></i>
                                            <p class="text-muted">Belum ada data yang diinput hari ini</p>
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
                        <i class="fas fa-users me-1 ms-3"></i>
                        Input Karcis Bakul • 
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
        
        // Form Validation
        function validateForm() {
            const form = document.getElementById('inputKarcisForm');
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!document.getElementById('konfirmasi').checked) {
                alert('Harap konfirmasi data dengan mencentang kotak persetujuan!');
                return false;
            }
            
            return isValid;
        }
        
        // Reset Form
        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang diisi akan hilang.')) {
                document.getElementById('inputKarcisForm').reset();
                // Reset nomor karcis ke default
                const noKarcisField = document.querySelector('[name="no_karcis"]');
                noKarcisField.value = 'KB-' + new Date().toISOString().slice(0,10).replace(/-/g, '') + '-' + 
                                      Math.floor(1000 + Math.random() * 9000);
                
                // Reset tanggal ke hari ini
                document.querySelector('[name="tanggal"]').value = new Date().toISOString().slice(0,10);
                
                showNotification('Form berhasil di-reset!');
            }
        }
        
        // Save Data
        function saveData() {
            if (validateForm()) {
                // Show loading
                const submitBtn = document.querySelector('[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    document.getElementById('inputKarcisForm').submit();
                }, 1500);
            }
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
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
        
        // Calculate total price
        document.addEventListener('DOMContentLoaded', function() {
            const beratField = document.querySelector('[name="berat"]');
            const hargaField = document.querySelector('[name="harga_per_kg"]');
            
            function calculateTotal() {
                const berat = parseFloat(beratField.value) || 0;
                const harga = parseFloat(hargaField.value) || 0;
                const total = berat * harga;
                
                // In a real app, you might display the total somewhere
                console.log('Total harga: Rp', total.toLocaleString('id-ID'));
            }
            
            beratField.addEventListener('input', calculateTotal);
            hargaField.addEventListener('input', calculateTotal);
            
            // Show welcome message
            setTimeout(() => {
                showNotification('Form input karcis bakul siap digunakan!');
            }, 1000);
        });
    </script>
</body>
</html>