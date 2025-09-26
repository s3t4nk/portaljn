<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HRIS - Portal Jembatan Nusantara</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .content-header h1 { color: #007bff; }
        .card { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/portal" class="nav-link">Portal Jembatan Nusantara</a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/portal" class="brand-link text-center">
            <span class="brand-text font-weight-light">HRIS</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a href="/hris" class="nav-link active">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Dashboard Teknik Kapal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/portal" class="nav-link">
                            <i class="nav-icon fas fa-arrow-left"></i>
                            <p>Kembali ke Portal</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-4">
        <div class="content-header">
            <h1>Selamat Datang di Aplikasi HRIS</h1>
            <p>Modul ini akan digunakan untuk mengelola karyawan, struktur organisasi, gaji, dan jabatan.</p>
        </div>

        <section class="content">
            <div class="card">
                <div class="card-body">
                    <h5>Fitur yang Akan Dibangun:</h5>
                    <ul>
                        <li>Manajemen Karyawan</li>
                        <li>Struktur Organisasi (Branch → Department → Unit)</li>
                        <li>Jabatan & Grade Gaji</li>
                        <li>Auto-create User</li>
                        <li>Laporan HR</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>