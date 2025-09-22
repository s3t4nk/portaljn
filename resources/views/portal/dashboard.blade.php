<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Jembatan Nusantara</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1579546929518-9e396f52b9f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(3px);
        }
        .overlay {
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.6); /* Gelap transparan */
            color: white;
        }
        .app-header {
            background-color: rgba(0, 31, 63, 0.95);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .app-title h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 600;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
        }
        .user-info i {
            color: #17a2b8;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s;
            margin-left: 15px;
        }
        .logout-btn:hover {
            background: #c82333;
        }
        .container {
            padding: 2rem;
        }
        .widget-card {
            display: block;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            border-left: 5px solid #007bff;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s;
            height: 100%;
            backdrop-filter: blur(5px);
        }
        .widget-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.2);
            border-left-color: #0056b3;
        }
        .widget-card i {
            font-size: 2.5rem;
            color: #007bff;
            margin-bottom: 0.5rem;
        }
        .widget-card h5 {
            margin: 0.5rem 0 0.25rem;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .widget-card small {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .no-access {
            opacity: 0.5;
            pointer-events: none;
            cursor: not-allowed;
        }
        .footer {
            text-align: center;
            margin-top: 3rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            padding: 1rem;
        }
        .footer strong {
            color: #fff;
        }
    </style>
</head>
<body>
<div class="overlay">
    <!-- Header -->
    <header class="app-header">
        <div class="app-title">
            <h1><i class="fas fa-globe-asia"></i> Portal Jembatan Nusantara</h1>
        </div>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Content -->
    <div class="container">
        <div class="row">
            <!-- Widget HRIS -->
            @can('access-hris')
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="{{ route('hris.dashboard') }}" class="widget-card">
                        <i class="fas fa-users"></i>
                        <h5>Aplikasi HRIS</h5>
                        <small>Kelola karyawan, struktur organisasi, gaji</small>
                    </a>
                </div>
            @else
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="widget-card no-access">
                        <i class="fas fa-users"></i>
                        <h5>HRIS</h5>
                        <small>Tidak ada akses</small>
                    </div>
                </div>
            @endcan

            <!-- Widget Keuangan -->
            @can('access-finance')
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="{{ route('finance.dashboard') }}" class="widget-card">
                        <i class="fas fa-coins"></i>
                        <h5>Keuangan & Pendapatan</h5>
                        <small>Laporan keuangan & operasi kapal</small>
                    </a>
                </div>
            @else
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="widget-card no-access">
                        <i class="fas fa-coins"></i>
                        <h5>Keuangan & Pendapatan</h5>
                        <small>Tidak ada akses</small>
                    </div>
                </div>
            @endcan

            <!-- Widget Teknik Kapal -->
            @can('access-engineering')
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="{{ route('engineering.dashboard') }}" class="widget-card">
                        <i class="fas fa-ship"></i>
                        <h5>Teknik Kapal</h5>
                        <small>Pemeliharaan, inspeksi, perbaikan</small>
                    </a>
                </div>
            @else
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="widget-card no-access">
                        <i class="fas fa-ship"></i>
                        <h5>Teknik Kapal</h5>
                        <small>Tidak ada akses</small>
                    </div>
                </div>
            @endcan

            <!-- Widget Pengadaan -->
            @can('access-procurement')
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="{{ route('procurement.dashboard') }}" class="widget-card">
                        <i class="fas fa-truck"></i>
                        <h5>Pengadaan</h5>
                        <small>Pengadaan barang & jasa</small>
                    </a>
                </div>
            @else
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="widget-card no-access">
                        <i class="fas fa-truck"></i>
                        <h5>Pengadaan</h5>
                        <small>Tidak ada akses</small>
                    </div>
                </div>
            @endcan

            <!-- Widget Lainnya (Contoh) -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="widget-card no-access">
                    <i class="fas fa-chart-line"></i>
                    <h5>Business Intelligence</h5>
                    <small>Analisis data korporat</small>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="widget-card no-access">
                    <i class="fas fa-shield-alt"></i>
                    <h5>Sistem Keamanan</h5>
                    <small>Monitoring & audit internal</small>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="widget-card no-access">
                    <i class="fas fa-graduation-cap"></i>
                    <h5>E-Learning</h5>
                    <small>Pelatihan karyawan & pelaut</small>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="widget-card no-access">
                    <i class="fas fa-envelope"></i>
                    <h5>Surat Elektronik Internal</h5>
                    <small>Komunikasi antar departemen</small>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4" style="background: rgba(0, 123, 255, 0.15); border: none; color: #d1ecf1;">
            🔔 <strong>Info:</strong> Semua aplikasi dikelola dalam satu ekosistem terintegrasi. Hak akses ditentukan berdasarkan peran dan departemen.
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} <strong>PT Jembatan Nusantara</strong>. Meningkatkan Konektivitas Maritim Indonesia.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>