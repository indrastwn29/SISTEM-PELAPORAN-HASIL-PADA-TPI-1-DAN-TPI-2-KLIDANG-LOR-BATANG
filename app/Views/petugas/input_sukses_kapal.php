<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Berhasil - Karcis Kapal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0066FF;
            --info-blue: #17a2b8;
            --light-bg: #F8F9FA;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        .success-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--info-blue), #5bc0de);
        }
        
        .success-icon {
            font-size: 80px;
            color: var(--info-blue);
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        .success-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 28px;
        }
        
        .success-subtitle {
            color: var(--info-blue);
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .success-message {
            background: rgba(23, 162, 184, 0.1);
            border: 1px solid rgba(23, 162, 184, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            color: #0c5460;
            font-size: 16px;
        }
        
        .kapal-icon {
            font-size: 60px;
            color: var(--info-blue);
            margin: 20px 0;
        }
        
        .status-badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin: 10px 0;
            border: 1px solid #ffeaa7;
        }
        
        .info-card {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            border-left: 4px solid var(--info-blue);
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #dee2e6;
        }
        
        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
            font-weight: 500;
        }
        
        .btn-custom {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 5px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--info-blue), #5bc0de);
            color: white;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
            color: white;
        }
        
        .btn-outline-custom {
            background: white;
            color: var(--info-blue);
            border: 2px solid var(--info-blue);
        }
        
        .btn-outline-custom:hover {
            background: var(--info-blue);
            color: white;
        }
        
        .notice-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #6c757d;
        }
        
        @media (max-width: 576px) {
            .success-card {
                padding: 25px;
                margin: 15px;
            }
            
            .success-title {
                font-size: 24px;
            }
            
            .btn-custom {
                padding: 10px 20px;
                font-size: 14px;
            }
            
            .kapal-icon {
                font-size: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-ship"></i>
        </div>
        
        <!-- Title -->
        <h1 class="success-title">Karcis Kapal Berhasil Disimpan!</h1>
        
        <!-- Subtitle -->
        <div class="success-subtitle">
            <i class="fas fa-anchor me-2"></i>
            Data kapal telah tersimpan
        </div>
        
        <!-- Success Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="success-message">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <!-- Kapal Icon -->
        <div class="kapal-icon">
            <i class="fas fa-ship"></i>
        </div>
        
        <!-- Status Badge -->
        <div class="status-badge">
            <i class="fas fa-clock me-2"></i>
            Menunggu Verifikasi
        </div>
        
        <!-- Info Card -->
        <div class="info-card">
            <div class="info-item">
                <span class="info-label">Petugas Input:</span>
                <span class="info-value"><?= session()->get('nama_lengkap') ?? 'Petugas TPI' ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Input:</span>
                <span class="info-value"><?= date('d/m/Y H:i:s') ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value" style="color: var(--info-blue); font-weight: bold;">
                    <i class="fas fa-hourglass-half me-1"></i> Pending Verification
                </span>
            </div>
        </div>
        
        <!-- Notice -->
        <div class="notice-box">
            <i class="fas fa-info-circle me-2"></i>
            Data karcis kapal memerlukan verifikasi dari administrator sebelum diproses lebih lanjut.
        </div>
        
        <!-- Buttons -->
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="<?= base_url('petugas/input-kapal') ?>" class="btn-custom btn-primary-custom">
                <i class="fas fa-plus-circle me-2"></i> Input Kapal Baru
            </a>
            <a href="<?= base_url('petugas/verifikasi') ?>" class="btn-custom btn-outline-custom">
                <i class="fas fa-clipboard-check me-2"></i> Halaman Verifikasi
            </a>
            <a href="<?= base_url('petugas') ?>" class="btn-custom btn-outline-custom">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>