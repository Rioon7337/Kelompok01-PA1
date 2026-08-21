<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100%;
            background: #003366;
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .sidebar-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffff;
        }

        .sidebar-header h3 span {
            color: #c6a43b;
        }

        .sidebar-header p {
            font-size: 0.7rem;
            color: #ffff;
            margin-top: 4px;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .sidebar-menu .menu-title {
            padding: 8px 20px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: #ffff;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 2px 8px;
            border-radius: 8px;
        }

        .sidebar-menu a:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .sidebar-menu a.active {
            background: #eef2ff;
            color: #003366;
        }

        .sidebar-menu a i {
            width: 20px;
            font-size: 1rem;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 260px;
            padding: 24px 32px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* ========== TOP BAR ========== */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .menu-toggle {
            display: none;
            background: white;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            color: #475569;
        }

        .menu-toggle:hover {
            background: #f1f5f9;
        }

        .page-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #0f172a;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
            background: white;
            padding: 6px 16px;
            border-radius: 40px;
            border: 1px solid #e2e8f0;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #334155;
        }

        .logout-btn {
            background: #f1f5f9;
            color: #475569;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ========== STATISTICS CARDS ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 16px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-label {
            font-size: 0.7rem;
            color: #64748b;
            margin-top: 4px;
        }

        /* ========== TABLE CARD ========== */
        .card-table {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header h5 {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }

        /* ========== BUTTONS ========== */
        .btn-primary {
            background: #003366;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1a4a7a;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .page-title {
                font-size: 1.1rem;
            }
            
            .top-bar {
                flex-direction: row;
                flex-wrap: wrap;
            }
            
            .user-menu {
                padding: 4px 12px;
            }
            
            .user-name {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .user-menu {
                justify-content: space-between;
            }
            
            .stat-card {
                padding: 12px;
            }
            
            .stat-number {
                font-size: 1.2rem;
            }
            
            .card-table {
                padding: 12px;
            }
        }
    
h1, h2, h3, h4, h5, h6, .page-title, .section-title, .navbar-brand {
    font-family: 'Quincy CF', serif !important;
    font-weight: bold !important;
}
</style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Geo<span>Toba</span></h3>
        <p>Administrator</p>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <div class="menu-title">HOMEPAGE</div>
        <a href="{{ route('admin.slider.index') }}" class="{{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">
            Manajemen Slider
        </a>
        
        <div class="menu-title">Konten</div>

        <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
            Galeri
        </a>
        <a href="{{ route('admin.pengelola-geosite.index') }}" class="{{ request()->routeIs('admin.pengelola-geosite.*') ? 'active' : '' }}">
            Pengelola Geosite
        </a>

        <div class="menu-title">Berita & Informasi</div>
        <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            Berita Terkini
        </a>
        <a href="{{ route('admin.agenda.index') }}" class="{{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">
            Agenda / Event
        </a>
        <a href="{{ route('admin.pengumuman.index') }}" class="{{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
            Pengumuman
        </a>

        {{-- ========== GROUP DESTINASI ========== --}}
        <div class="menu-title">Destinasi</div>
        <a href="{{ route('admin.destination.alam.index') }}"
           class="{{ request()->routeIs('admin.destination.alam.*') ? 'active' : '' }}">
            Destinasi Alam
        </a>
        <a href="{{ route('admin.destination.buatan.index') }}"
           class="{{ request()->routeIs('admin.destination.buatan.*') ? 'active' : '' }}">
            Destinasi Buatan
        </a>
        <a href="{{ route('admin.destination.budaya.index') }}"
           class="{{ request()->routeIs('admin.destination.budaya.*') ? 'active' : '' }}">
            Destinasi Budaya
        </a>

        <div class="menu-title">Keanekaragaman</div>
        <a href="{{ route('admin.biodiversitas.index') }}" class="{{ request()->routeIs('admin.biodiversitas.*') ? 'active' : '' }}">
            Biodiversity
        </a>
        <a href="{{ route('admin.geodiversitas.index') }}" class="{{ request()->routeIs('admin.geodiversitas.*') ? 'active' : '' }}">
            Geodiversity
        </a>
        <a href="{{ route('admin.cultural-diversity.index') }}" class="{{ request()->routeIs('admin.cultural-diversity.*') ? 'active' : '' }}">
            Cultural Diversity
        </a>
        
        <div class="menu-title">Fasilitas</div>
        <a href="{{ route('admin.umkm.index') }}" class="{{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
           Sovenir&UMKM
</a>

        <a href="{{ route('admin.fasilitas.index') }}" class="{{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
            Fasilitas
        </a>

        <a href="{{ route('admin.penginapan.index') }}" class="{{ request()->routeIs('admin.penginapan.*') ? 'active' : '' }}">
            Penginapan
        </a>
        <a href="{{ route('admin.kuliner.index') }}" class="{{ request()->routeIs('admin.kuliner.*') ? 'active' : '' }}">
            Kuliner / Restoran
        </a>
        
        <div class="menu-title">Pengaturan</div>
        <a href="{{ route('admin.kontak.index') }}" class="{{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
            Pengaturan Kontak
        </a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">@yield('title', 'Dashboard')</div>
        </div>
        <div class="user-menu">
            <span class="user-name"><i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Admin' }}</span>
            <form action="{{ url('/logout') }}" method="POST" class="d-inline" id="logoutForm">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    @yield('content')
</div>

<script>
    // Toggle sidebar untuk mobile
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }

    // Tutup sidebar saat klik di luar (untuk mobile)
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth <= 768;
        if (isMobile && sidebar && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('open');
        }
    });

    // Handle resize window
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("logoutForm")?.addEventListener("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Konfirmasi Logout",
            text: "Apakah Anda yakin ingin keluar dari halaman Admin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#003366",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yakin",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logoutForm").submit();
            }
        });
    });
</script>
</body>
</html>




