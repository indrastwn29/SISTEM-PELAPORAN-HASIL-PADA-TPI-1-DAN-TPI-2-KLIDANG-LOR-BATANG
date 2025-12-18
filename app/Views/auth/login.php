<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Lelang Ikan TPI</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }
        
        .login-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.5s ease;
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--white);
            font-size: 36px;
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.3);
        }
        
        .logo-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 5px;
        }
        
        .logo-text p {
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control {
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }
        
        .input-group-text {
            background: var(--white);
            border: 2px solid var(--border-color);
            border-right: none;
            border-radius: var(--radius-md) 0 0 var(--radius-md);
            color: var(--text-muted);
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            color: var(--white);
            border: none;
            padding: 14px;
            border-radius: var(--radius-round);
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 102, 255, 0.2);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: rgba(255, 71, 87, 0.1);
            color: var(--danger);
            padding: 12px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
            border: 1px solid var(--danger);
        }
        
        .error-message i {
            font-size: 18px;
        }
        
        .success-message {
            background: rgba(0, 184, 148, 0.1);
            color: var(--success);
            padding: 12px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
            border: 1px solid var(--success);
        }
        
        .loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--white);
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }
        
        .login-info {
            background: var(--light-1);
            border-radius: var(--radius-md);
            padding: 16px;
            margin-top: 20px;
            font-size: 13px;
            color: var(--text-secondary);
        }
        
        .login-info h6 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .login-info ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .login-info li {
            margin-bottom: 4px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }
            
            .logo-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }
            
            .logo-text h1 {
                font-size: 20px;
            }
            
            .login-info {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-fish"></i>
                </div>
                <div class="logo-text">
                    <h1>Sistem TPI</h1>
                    <p>Dashboard Petugas</p>
                </div>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <!-- FORM LOGIN YANG DIPERBAIKI -->
            <form method="POST" action="<?= base_url('/auth/login') ?>" id="loginForm">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="username" 
                               name="username" 
                               placeholder="Masukkan username"
                               required
                               value="<?= old('username') ?>"
                               autocomplete="username">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan password"
                               required
                               autocomplete="current-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn-login" id="loginButton">
                    <span id="buttonText">Login</span>
                </button>
            </form>
            
            <div class="login-info">
                <h6>Informasi Login Testing:</h6>
                <ul>
                    <li><strong>Petugas TPI:</strong> username: <code>petugas</code> | password: <code>petugas123</code></li>
                    <li><strong>Admin:</strong> username: <code>admin</code> | password: <code>admin123</code></li>
                </ul>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
            
            // Form submission
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');
            
            loginForm.addEventListener('submit', function(e) {
                // Show loading state
                loginButton.disabled = true;
                buttonText.innerHTML = '<div class="loader"></div> Memproses...';
            });
            
            // Focus username field on load
            document.getElementById('username').focus();
        });
    </script>
</body>
</html>