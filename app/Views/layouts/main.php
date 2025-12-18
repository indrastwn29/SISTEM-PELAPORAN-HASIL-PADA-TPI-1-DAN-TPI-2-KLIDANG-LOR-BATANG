<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?? 'Sistem Karcis TPI' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ===== VARIABLES ===== */
        :root {
            /* Navy Blue Colors - Biru Laut untuk header & buttons */
            --navy-50: #f0f9ff;
            --navy-100: #e0f2fe;
            --navy-200: #bae6fd;
            --navy-300: #7dd3fc;
            --navy-400: #38bdf8;
            --navy-500: #0ea5e9;  /* Biru laut medium */
            --navy-600: #0284c7;  /* Biru laut utama */
            --navy-700: #0369a1;  /* Biru laut gelap */
            --navy-800: #075985;
            --navy-900: #0c4a6e;
            
            /* Gray Colors - Abu-abu untuk borders & backgrounds */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Accent Colors */
            --teal-500: #14b8a6;
            --teal-600: #0d9488;
            --teal-700: #0f766e;
            
            --amber-500: #f59e0b;
            --amber-600: #d97706;
            --amber-700: #b45309;
            
            --emerald-500: #10b981;
            --emerald-600: #059669;
            --emerald-700: #047857;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            
            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* ===== RESET & BASE STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color var(--transition-fast), border-color var(--transition-fast);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fc;
            color: var(--gray-800);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }
        
        html {
            height: 100%;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            line-height: 1.2;
        }
        
        /* ===== LAYOUT CONTAINER ===== */
        .app-container {
            min-height: 100vh;
            display: flex;
            position: relative;
        }
        
        /* ===== SIDEBAR - UKURAN 280px ===== */
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--gray-200);
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem 1.75rem;
            border-bottom: 1px solid var(--gray-200);
            background: white;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            text-decoration: none;
        }
        
        /* Logo Icon */
        .logo-icon {
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, var(--navy-600), var(--navy-700));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.375rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(2, 132, 199, 0.2);
        }
        
        /* Animasi untuk logo orang */
        .logo-icon i {
            position: relative;
            z-index: 1;
            animation: bounce 2s infinite ease-in-out;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-4px);
            }
        }
        
        .logo-text {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
        }
        
        .logo-subtext {
            font-size: 0.75rem;
            color: var(--navy-600);
            margin-top: 0.125rem;
            font-weight: 500;
            line-height: 1;
        }
        
        /* User Profile */
        .user-profile {
            padding: 1.5rem 1.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid var(--gray-200);
            background: white;
            position: sticky;
            top: 78px; /* Height of sidebar-header */
            z-index: 2;
            text-align: center;
        }
        
        /* Avatar */
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--navy-600), var(--navy-700));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.75rem;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(2, 132, 199, 0.2);
            transition: all 0.3s ease;
        }
        
        .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.3);
        }
        
        /* Petugas TPI */
        .user-role {
            font-size: 1rem;
            color: var(--navy-700);
            font-weight: 700;
            background: var(--navy-50);
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius);
            display: inline-block;
            border: 2px solid var(--navy-300);
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
            white-space: nowrap;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
            width: 100%;
        }
        
        /* Navigation di Sidebar */
        .nav-container {
            flex: 1;
            padding: 1.5rem 1.25rem;
            overflow-y: auto;
            background: white;
            position: relative;
        }
        
        .nav-container::-webkit-scrollbar {
            width: 5px;
        }
        
        .nav-container::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .nav-container::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }
        
        .nav-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--gray-500);
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            padding: 0 0.625rem;
        }
        
        .nav-group {
            margin-bottom: 1.5rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 0.375rem;
            background: white;
            font-size: 0.95rem;
        }
        
        .nav-link:hover {
            background-color: var(--gray-100);
            color: var(--navy-600);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background-color: var(--navy-50);
            color: var(--navy-600);
            font-weight: 500;
            border-left: 3px solid var(--navy-600);
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.15);
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.125rem;
            color: inherit;
            flex-shrink: 0;
        }
        
        .nav-link span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }
        
        /* Badge di nav link */
        .nav-link .badge {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            margin-left: auto;
            flex-shrink: 0;
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1.25rem 1rem;
            border-top: 1px solid var(--gray-200);
            background: white;
            text-align: center;
            position: sticky;
            bottom: 0;
            z-index: 2;
        }
        
        .sidebar-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--teal-500);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(20, 184, 166, 0.7);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(20, 184, 166, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(20, 184, 166, 0);
            }
        }
        
        .sidebar-footer .text-xs {
            font-size: 0.75rem;
            line-height: 1.3;
        }
        
        .sidebar-footer i {
            font-size: 0.7rem;
        }
        
        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fc;
            position: relative;
            width: calc(100% - 280px);
        }
        
        /* ===== TOPBAR - STICKY ===== */
        .topbar {
            background: white;
            color: var(--gray-900);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--gray-200);
            height: 64px;
            flex-shrink: 0;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            color: var(--gray-700);
            font-size: 1.25rem;
            cursor: pointer;
            display: none;
            width: 40px;
            height: 40px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-toggle:hover {
            background-color: var(--gray-100);
        }
        
        .topbar-search {
            flex: 1;
            max-width: 400px;
            margin: 0 1rem;
        }
        
        .search-input {
            width: 100%;
            padding: 0.625rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.9rem;
            transition: var(--transition-fast);
            background-color: white;
            color: var(--gray-900);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 0.75rem center;
            background-size: 1rem;
        }
        
        .search-input::placeholder {
            color: var(--gray-500);
            font-size: 0.9rem;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--navy-500);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
        }
        
        /* ===== TOPBAR ACTIONS - DIUBAH: Hanya Notifikasi ===== */
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .topbar-action {
            position: relative;
            background: var(--gray-100);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-700);
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-size: 1.125rem;
        }
        
        .topbar-action:hover {
            background-color: var(--gray-200);
            color: var(--navy-600);
        }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* ===== PAGE CONTENT - SCROLLABLE AREA ===== */
        .page-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            position: relative;
            min-height: 0; /* PENTING untuk flex scroll */
        }
        
        /* ===== CARDS ===== */
        .card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        
        .card:hover {
            box-shadow: var(--shadow-lg);
            border-color: var(--navy-500);
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background-color: white;
        }
        
        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }
        
        .card-title i {
            color: var(--navy-600);
            font-size: 1.125rem;
        }
        
        .card-body {
            padding: 1.5rem;
            position: relative;
        }
        
        /* ===== BUTTONS ===== */
        .btn {
            border-radius: var(--radius);
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.95rem;
            cursor: pointer;
        }
        
        .btn-sm {
            padding: 0.375rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--navy-600), var(--navy-700));
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--navy-700), var(--navy-800));
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(2, 132, 199, 0.25);
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--teal-600), var(--teal-700));
            color: white;
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--navy-500), var(--navy-600));
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--amber-500), var(--amber-600));
            color: white;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--navy-600);
            color: var(--navy-600);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--navy-600);
            color: white;
        }
        
        /* ===== BADGES ===== */
        .badge {
            border-radius: var(--radius);
            padding: 0.35em 0.7em;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-block;
        }
        
        .badge.bg-primary {
            background-color: var(--navy-600);
            color: white;
        }
        
        .badge.bg-success {
            background-color: var(--teal-600);
            color: white;
        }
        
        .badge.bg-warning {
            background-color: var(--amber-500);
            color: white;
        }
        
        .badge.bg-danger {
            background-color: #ef4444;
            color: white;
        }
        
        /* ===== ALERTS ===== */
        .alert {
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1.25rem;
            border: 1px solid transparent;
            font-size: 0.95rem;
        }
        
        .alert-success {
            background-color: rgba(20, 184, 166, 0.1);
            border-color: var(--teal-500);
            color: var(--teal-700);
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #dc2626;
        }
        
        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border-color: var(--amber-500);
            color: var(--amber-700);
        }
        
        .alert-info {
            background-color: rgba(2, 132, 199, 0.1);
            border-color: var(--navy-500);
            color: var(--navy-700);
        }
        
        .alert i {
            color: inherit;
            font-size: 1rem;
            margin-right: 0.5rem;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: white;
            border-top: 1px solid var(--gray-200);
            padding: 1.5rem 2rem;
            flex-shrink: 0;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--gray-600);
            font-size: 0.875rem;
        }
        
        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .menu-toggle {
                display: flex;
            }
            
            .topbar-search {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .page-content {
                padding: 1.5rem;
            }
            
            .topbar {
                padding: 0.75rem 1.25rem;
                height: 60px;
            }
            
            .footer-content {
                flex-direction: column;
                gap: 0.625rem;
                text-align: center;
            }
            
            .user-profile {
                padding: 1.25rem 1.5rem;
            }
            
            .avatar {
                width: 70px;
                height: 70px;
                font-size: 1.5rem;
            }
            
            .user-role {
                font-size: 0.875rem;
                padding: 0.375rem 1rem;
            }
            
            .sidebar {
                width: 240px;
            }
            
            .topbar-search {
                max-width: 250px;
            }
            
            .topbar-actions {
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .page-content {
                padding: 1rem;
            }
            
            .topbar {
                padding: 0.5rem 1rem;
            }
            
            .topbar-search {
                display: none;
            }
        }
        
        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: var(--radius-full);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: var(--radius-full);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }
        
        /* ===== UTILITY CLASSES ===== */
        .text-xs {
            font-size: 0.75rem;
        }
        
        .text-sm {
            font-size: 0.875rem;
        }
        
        .text-gray-500 {
            color: var(--gray-500);
        }
        
        .text-gray-600 {
            color: var(--gray-600);
        }
        
        .text-success {
            color: var(--teal-600);
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        .mr-1 { margin-right: 0.25rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mx-1 { margin-left: 0.25rem; margin-right: 0.25rem; }
        
        .d-lg-none {
            display: none;
        }
        
        @media (max-width: 1024px) {
            .d-lg-none {
                display: flex;
            }
        }
        
        /* ===== FIXES FOR SCROLLING ===== */
        .main-content {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        .page-content {
            flex: 1;
            overflow-y: auto;
            min-height: 0; /* CRITICAL: Allows proper scrolling in flex container */
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="app-container">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar" id="sidebar">
            <!-- Logo dengan animasi orang -->
            <div class="sidebar-header">
                <a href="<?= base_url('petugas') ?>" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="logo-text">Sistem TPI</div>
                        <div class="logo-subtext">Dashboard Petugas</div>
                    </div>
                </a>
            </div>

            <!-- User Profile -->
            <div class="user-profile">
                <div class="avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <!-- HANYA MENAMPILKAN "PETUGAS TPI" -->
                    <div class="user-role">Petugas TPI</div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="nav-container">
                <!-- Menu Utama -->
                <div class="nav-group">
                    <div class="nav-title">Menu Utama</div>
                    <a href="<?= base_url('petugas') ?>" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('petugas/profile') ?>" class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil Saya</span>
                    </a>
                </div>

                <!-- Input Data -->
                <div class="nav-group">
                    <div class="nav-title">Input Data</div>
                    <a href="<?= base_url('petugas/input-bakul') ?>" class="nav-link">
                        <i class="fas fa-shopping-basket"></i>
                        <span>Karcis Bakul</span>
                        <span class="badge bg-success">Baru</span>
                    </a>
                    <a href="<?= base_url('petugas/input-kapal') ?>" class="nav-link">
                        <i class="fas fa-ship"></i>
                        <span>Karcis Kapal</span>
                    </a>
                </div>

                <!-- Manajemen Data -->
                <div class="nav-group">
                    <div class="nav-title">Manajemen Data</div>
                    <a href="<?= base_url('petugas/data-karcis') ?>" class="nav-link">
                        <i class="fas fa-database"></i>
                        <span>Data Karcis</span>
                        <span class="badge bg-primary">24</span>
                    </a>
                    <a href="<?= base_url('petugas/riwayat') ?>" class="nav-link">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Input</span>
                    </a>
                </div>

                <!-- Aksi -->
                <div class="nav-group">
                    <div class="nav-title">Aksi</div>
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger" 
                       onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout Sistem</span>
                    </a>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <div class="sidebar-status">
                    <div class="status-dot"></div>
                    <span class="text-xs text-success font-medium">Sistem Aktif</span>
                </div>
                <div class="text-gray-500 text-xs">
                    <div class="mb-1">
                        <i class="fas fa-clock mr-1"></i>
                        <span id="sidebarTime"><?= date('H:i') ?></span>
                        <span class="mx-1">•</span>
                        <span id="sidebarDate"><?= date('d/m/Y') ?></span>
                    </div>
                    <div>Shift: Pagi (08:00-16:00)</div>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="main-content">
            <!-- ===== TOPBAR - STICKY ===== -->
            <header class="topbar">
                <button class="menu-toggle d-lg-none" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="topbar-search">
                    <input type="text" 
                           class="search-input" 
                           placeholder="Cari data karcis...">
                </div>

                <!-- ===== TOPBAR ACTIONS - DIUBAH: Hanya Notifikasi ===== -->
                <div class="topbar-actions">
                    <button class="topbar-action" title="Notifikasi">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                </div>
            </header>

            <!-- ===== PAGE CONTENT - SCROLLABLE AREA ===== -->
            <div class="page-content">
                <!-- Flash Messages -->
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success fade-in" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger fade-in" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Main Content Area -->
                <?= $this->renderSection('content') ?>
            </div>

            <!-- ===== FOOTER ===== -->
            <footer class="footer">
                <div class="footer-content">
                    <div>
                        &copy; <?= date('Y') ?> Sistem Karcis TPI - Himpunan Nelayan
                    </div>
                    <div>
                        <span class="mr-3">v2.1</span>
                        <span>Sistem Aktif</span>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ===== TOGGLE SIDEBAR =====
        document.getElementById('menuToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
            
            // Update aria-label for accessibility
            const isExpanded = sidebar.classList.contains('active');
            this.setAttribute('aria-expanded', isExpanded);
        });

        // ===== UPDATE TIME IN SIDEBAR =====
        function updateSidebarTime() {
            const now = new Date();
            const timeElement = document.getElementById('sidebarTime');
            const dateElement = document.getElementById('sidebarDate');
            
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('id-ID', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: false
                });
            }
            
            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }
        }

        // Update time every minute
        setInterval(updateSidebarTime, 60000);
        updateSidebarTime();

        // ===== CLOSE SIDEBAR ON MOBILE =====
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 1024 && 
                sidebar.classList.contains('active') &&
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // ===== ENHANCE SEARCH INPUT =====
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && this.value.trim()) {
                    // Handle search here
                    console.log('Searching for:', this.value);
                    // You can add AJAX search functionality here
                }
            });
        }

        // ===== ACTIVE NAV LINK =====
        function setActiveNavLink() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                // Remove active class from all links
                link.classList.remove('active');
                
                // Get the href attribute
                const href = link.getAttribute('href');
                
                // Check if current path contains the href
                if (href && currentPath.includes(href.replace('<?= base_url() ?>', ''))) {
                    link.classList.add('active');
                }
            });
        }

        // ===== PAGE LOAD ANIMATION =====
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in page content
            const pageContent = document.querySelector('.page-content');
            if (pageContent) {
                pageContent.style.opacity = '0';
                pageContent.style.animation = 'fadeIn 0.5s ease-out forwards';
            }
            
            // Set active nav link
            setActiveNavLink();
            
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // ===== RESPONSIVE HANDLING =====
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize();

        // ===== NOTIFICATION BELL FUNCTIONALITY =====
        const notificationBell = document.querySelector('.topbar-action[title="Notifikasi"]');
        if (notificationBell) {
            // Add pulse animation if there are notifications
            setTimeout(() => {
                notificationBell.style.animation = 'pulse 2s infinite';
            }, 2000);
            
            notificationBell.addEventListener('click', function() {
                // Stop animation when clicked
                this.style.animation = 'none';
                
                // Clear notification badge
                const badge = this.querySelector('.notification-badge');
                if (badge) {
                    badge.remove();
                }
                
                // Show notification dropdown (you can implement this)
                console.log('Notifications clicked');
                alert('Fitur notifikasi akan segera hadir!');
            });
        }

        // ===== FIX SCROLLING BEHAVIOR =====
        document.addEventListener('DOMContentLoaded', function() {
            // Enable smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId !== '#') {
                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });
        });

        // ===== FORM VALIDATION ENHANCEMENT =====
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        
                        // Add error message if not exists
                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'Field ini wajib diisi';
                            field.parentNode.appendChild(errorDiv);
                        }
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Scroll to first error
                    const firstError = this.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }
                }
            });
        });

        // ===== KEYBOARD SHORTCUTS =====
        document.addEventListener('keydown', function(e) {
            // Ctrl + K for search focus
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.querySelector('.search-input');
                if (searchInput) {
                    searchInput.focus();
                }
            }
            
            // Escape to close sidebar on mobile
            if (e.key === 'Escape' && window.innerWidth <= 1024) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    document.getElementById('menuToggle').setAttribute('aria-expanded', 'false');
                }
            }
            
            // Alt + M to toggle sidebar
            if (e.altKey && e.key === 'm') {
                e.preventDefault();
                document.getElementById('menuToggle').click();
            }
        });

        // ===== COPYRIGHT YEAR UPDATE =====
        const copyrightYear = document.querySelector('.footer-content div:first-child');
        if (copyrightYear) {
            const currentYear = new Date().getFullYear();
            copyrightYear.innerHTML = copyrightYear.innerHTML.replace(/© \d{4}/, `© ${currentYear}`);
        }

        // ===== NETWORK STATUS MONITOR =====
        window.addEventListener('online', function() {
            showNotification('Koneksi internet telah pulih', 'success');
        });

        window.addEventListener('offline', function() {
            showNotification('Koneksi internet terputus', 'warning');
        });

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} fade-in`;
            notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i> ${message}`;
            notification.style.position = 'fixed';
            notification.style.top = '80px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.maxWidth = '300px';
            
            document.body.appendChild(notification);
            
            // Remove after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>