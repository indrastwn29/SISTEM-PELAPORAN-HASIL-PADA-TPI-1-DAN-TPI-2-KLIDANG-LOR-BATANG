<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Lelang Ikan TPI' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4e73df;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --secondary: #858796;
            --light: #f8f9fc;
            --dark: #5a5c69;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 225px;
            z-index: 100;
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 1rem;
            border-left: 3px solid transparent;
            font-weight: 400;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.1);
            border-left-color: #fff;
            font-weight: 700;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.1);
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 0.75rem 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            color: #5a5c69;
        }

        #layoutSidenav_content {
            margin-left: 225px;
            padding-top: 76px;
        }

        .dropdown-menu {
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <!-- Sidebar Toggle -->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <i class="bi bi-fish me-2"></i>Sistem Lelang Ikan TPI
            </a>

            <!-- Navbar Links -->
            <ul class="navbar-nav ms-auto me-4">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            <?= session()->get('nama_lengkap') ?>
                        </span>
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" 
                        aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>Profile
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= site_url('/auth/logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidebar" id="sidenavAccordion">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <?php if (session()->get('role') === 'petugas'): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('/petugas') ?>">
                                <i class="bi bi-speedometer2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/petugas/input-karcis-bakul') ?>">
                                <i class="bi bi-cart-plus"></i>Input Karcis Bakul
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/petugas/input-karcis-pemilik-kapal') ?>">
                                <i class="bi bi-boat"></i>Input Karcis Kapal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/petugas/daftar-karcis-bakul') ?>">
                                <i class="bi bi-list-ul"></i>Daftar Karcis
                            </a>
                        </li>
                        <?php else: ?>
                        <!-- ADMIN MENU -->
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('/admin') ?>">
                                <i class="bi bi-speedometer2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/admin/input-karcis-bakul') ?>">
                                <i class="bi bi-cart-plus"></i>Input Karcis
                            </a>
                        </li>

                        <!-- ✅ MENU VERIFIKASI TERPISAH -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/admin/verifikasi-karcis-bakul') ?>">
                                <i class="bi bi-person-badge"></i>Verifikasi Bakul
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- Menu Verifikasi Kapal - PASTIKAN SEPERTI INI -->
                            <a href="<?= base_url('admin/verifikasi-karcis-kapal') ?>" class="nav-link">
                                <i class="fas fa-ship"></i>
                                <span>Verifikasi Karcis Kapal</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/data-terverifikasi') ?>">
                                <i class="bi bi-check-circle-fill"></i>Data Terverifikasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/admin/laporan') ?>">
                                <i class="bi bi-file-earmark-text"></i>Laporan
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Main content -->
        <div id="layoutSidenav_content">
            <main>