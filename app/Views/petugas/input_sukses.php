<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Berhasil - Sistem TPI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0066FF;
            --success-green: #28a745;
            --light-bg: #F8F9FA;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(90deg, var(--success-green), #20c997);
        }
        
        .success-icon {
            font-size: 80px;
            color: var(--success-green);
            margin-bottom: 20px;
            animation: bounce 1s ease infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .success-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 28px;
        }
        
        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            color: #155724;
            font-size: 16px;
        }
        
        .success-info {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
            border-left: 4px solid var(--primary-blue);
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
            background: linear-gradient(135deg, var(--primary-blue), #4D94FF);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 102, 255, 0.4);
            color: white;
        }
        
        .btn-outline-custom {
            background: white;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }
        
        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: white;
        }
        
        .redirect-timer {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .progress-bar-custom {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success-green), #20c997);
            width: 0%;
            transition: width 1s linear;
            border-radius: 3px;
        }
        
        #timer {
            background: var(--success-green);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            margin: 0 5px;
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
        }
    </style>
</head>
<body>
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <!-- Title -->
        <h1 class="success-title">Input Berhasil!</h1>
        
        <!-- Success Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="success-message">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <!-- Info Card -->
        <div class="success-info">
            <div class="info-item">
                <span class="info-label">Petugas:</span>
                <span class="info-value"><?= session()->get('nama_lengkap') ?? 'Petugas TPI' ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal:</span>
                <span class="info-value"><?= date('d/m/Y') ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Waktu:</span>
                <span class="info-value"><?= date('H:i:s') ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value" style="color: var(--success-green); font-weight: bold;">
                    <i class="fas fa-check-circle me-1"></i> Berhasil Disimpan
                </span>
            </div>
        </div>
        
        <!-- Buttons -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
            <a href="<?= base_url('petugas/input-bakul') ?>" class="btn-custom btn-primary-custom">
                <i class="fas fa-plus-circle me-2"></i> Input Baru
            </a>
            <a href="<?= base_url('petugas/data-karcis') ?>" class="btn-custom btn-outline-custom">
                <i class="fas fa-list me-2"></i> Lihat Data
            </a>
            <a href="<?= base_url('petugas') ?>" class="btn-custom btn-outline-custom">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </div>
        
        <!-- Redirect Timer -->
        <div class="redirect-timer">
            <p class="mb-2">
                Redirect otomatis ke halaman data dalam 
                <span id="timer">5</span> detik
            </p>
            <div class="progress-bar-custom">
                <div id="progress-bar" class="progress-fill"></div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let time = 5;
        const timerElement = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');
        
        const interval = setInterval(() => {
            time--;
            timerElement.textContent = time;
            progressBar.style.width = ((5 - time) / 5 * 100) + '%';
            
            if(time <= 0) {
                clearInterval(interval);
                window.location.href = "<?= base_url('petugas/data-karcis') ?>";
            }
        }, 1000);
        
        // Hentikan redirect jika user mengklik tombol
        document.querySelectorAll('.btn-custom').forEach(btn => {
            btn.addEventListener('click', function() {
                clearInterval(interval);
                progressBar.style.width = '100%';
                timerElement.textContent = '0';
            });
        });
    </script>
</body>
</html>