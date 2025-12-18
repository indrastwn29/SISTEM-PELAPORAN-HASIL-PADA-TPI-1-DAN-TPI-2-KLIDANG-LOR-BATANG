<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Berhasil - Sistem Lelang Ikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .success-animation { animation: bounce 2s infinite; }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }
        
        @keyframes gentlePulse {
            0% { transform: scale(1); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
            50% { transform: scale(1.03); box-shadow: 0 12px 25px rgba(0,0,0,0.15); }
            100% { transform: scale(1); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        }
        
        .custom-success-card {
            max-width: 500px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
            position: relative;
            overflow: hidden;
        }
        
        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(108, 117, 125, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(52, 58, 64, 0.05) 0%, transparent 50%);
            z-index: 0;
        }
        
        .success-icon-circle {
            background: #fff;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            color: #28a745;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border: 3px solid #28a745;
            animation: gentlePulse 2s infinite;
        }
        
        .info-card {
            text-align: left;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
        
        .redirect-container {
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
        
        .progress-bar-custom {
            background: #e9ecef;
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #6c757d, #495057);
            width: 0%;
            transition: width 1s ease;
            border-radius: 3px;
        }
    </style>
</head>
<body style="background: #f8f9fa; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('admin') ?>">
                <i class="fas fa-fish"></i> Sistem Lelang Ikan - Admin
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="custom-success-card">
                    <div class="background-pattern"></div>
                    
                    <div class="p-4 text-center" style="position: relative; z-index: 1;">
                        <!-- Success Icon -->
                        <div class="success-icon-circle mx-auto mb-4">
                            <i class="fas fa-check-circle success-animation"></i>
                        </div>
                        
                        <!-- Title -->
                        <h2 class="text-dark mb-4" style="font-size: 28px; font-weight: 700;">
                            <?= $success_data['status'] == 'approved' ? 'Karcis Disetujui!' : 'Karcis Ditolak!' ?>
                        </h2>
                        
                        <!-- Info Card -->
                        <div class="info-card mb-4">
                            <div class="mb-3">
                                <strong class="d-inline-block" style="width: 120px;">ID Karcis:</strong> 
                                <span style="color: #212529; font-weight: 600; background: #f8f9fa; padding: 4px 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                    #<?= $success_data['id_karcis'] ?>
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-inline-block" style="width: 120px;">Nama Bakul:</strong> 
                                <span style="color: #212529; font-weight: 600; background: #f8f9fa; padding: 4px 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                    <?= $success_data['nama_bakul'] ?>
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-inline-block" style="width: 120px;">Status:</strong> 
                                <span style="color: <?= $success_data['status'] == 'approved' ? '#28a745' : '#dc3545' ?>; font-weight: 600; background: #f8f9fa; padding: 4px 12px; border-radius: 6px; border: 1px solid <?= $success_data['status'] == 'approved' ? '#d4edda' : '#f8d7da' ?>;">
                                    <?= $success_data['status'] == 'approved' ? '✓ Disetujui' : '✗ Ditolak' ?>
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong class="d-inline-block" style="width: 120px;">Total:</strong> 
                                <span style="color: #212529; font-weight: 600; background: #f8f9fa; padding: 4px 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                    Rp <?= number_format($success_data['harga_total'], 0, ',', '.') ?>
                                </span>
                            </div>
                            <div>
                                <strong class="d-inline-block" style="width: 120px;">Waktu:</strong> 
                                <span style="color: #6c757d; font-weight: 500; background: #f8f9fa; padding: 4px 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                    <?= date('H:i:s') ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Message -->
                        <p class="text-muted mb-4">
                            <?= $success_data['status'] == 'approved' 
                                ? 'Karcis telah berhasil disetujui dan diverifikasi.' 
                                : 'Karcis telah ditolak dan tidak akan diproses lebih lanjut.' 
                            ?>
                        </p>
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="<?= base_url('admin/verifikasi-karcis-bakul') ?>" class="btn btn-primary">
                                <i class="fas fa-list"></i> Kembali ke Verifikasi
                            </a>
                            <a href="<?= base_url('admin') ?>" class="btn btn-outline-success">
                                <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                            </a>
                        </div>
                        
                        <!-- Redirect Timer -->
                        <div class="redirect-container">
                            <p class="text-muted mb-2" style="font-size: 14px; font-weight: 500;">
                                Redirect otomatis dalam 
                                <span id="timer" style="color: #495057; font-weight: bold; font-size: 16px; background: #f8f9fa; padding: 2px 8px; border-radius: 4px; border: 1px solid #e9ecef;">5</span> 
                                detik
                            </p>
                            <div class="progress-bar-custom">
                                <div id="progress-bar" class="progress-fill"></div>
                            </div>
                        </div>
                    </div>
                </div>
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
                window.location.href = '<?= base_url('admin/verifikasi-karcis-bakul') ?>';
            }
        }, 1000);
    </script>
</body>
</html>