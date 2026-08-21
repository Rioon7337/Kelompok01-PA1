@extends('layouts.app')

@section('title', 'Fasilitas & Layanan - Geosite Danau Toba')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@400;500;600;700&display=swap');
    
    .fasilitas-hero {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-medium) 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .fasilitas-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: rotateSlow 25s linear infinite;
    }
    
    @keyframes rotateSlow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .fasilitas-hero .container { position: relative; z-index: 2; }
    
    .fasilitas-hero .badge {
        display: inline-block;
        background: rgba(198, 164, 59, 0.15);
        border: 1px solid rgba(198, 164, 59, 0.3);
        color: var(--gold-light);
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 0.6rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .fasilitas-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    
    .fasilitas-hero p {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .hero-divider {
        width: 60px;
        height: 2px;
        background: var(--gold);
        margin: 15px auto 20px;
        border-radius: 2px;
    }
    
    .category-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-header .subtitle {
        display: inline-block;
        font-size: 0.75rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #c6a43b;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #003366;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .section-header .divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #c6a43b, #e8c45a);
        margin: 0 auto 20px;
        border-radius: 3px;
    }
    
    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 35px;
    }
    
    .category-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        transition: all 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        text-decoration: none;
        display: block;
    }
    
    .category-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 50px rgba(0,0,0,0.2);
    }
    
    .card-image {
        position: relative;
        height: 240px;
        overflow: hidden;
    }
    
    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }
    
    .category-card:hover .card-image img {
        transform: scale(1.1);
    }
    
    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5));
    }
    
    .card-content {
        padding: 25px;
        text-align: center;
    }
    
    .card-icon {
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #003366, #1a4a7a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -45px auto 15px;
        position: relative;
        z-index: 2;
        box-shadow: 0 8px 20px rgba(0,51,102,0.3);
    }
    
    .card-icon i {
        font-size: 26px;
        color: #c6a43b;
    }
    
    .card-content h3 {
        font-size: 1.45rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #003366;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .card-content p {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.7;
        margin-bottom: 15px;
    }
    
    .btn-explore {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #c6a43b;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    .category-card:hover .btn-explore {
        gap: 12px;
        color: #003366;
    }
    
    .stats-section {
        background: linear-gradient(135deg, #003366, #0a2a4a);
        padding: 70px 0;
        position: relative;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        text-align: center;
        padding: 2rem;
    }
    
    .stat-item {
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    
    .stat-item:hover {
        transform: translateY(-5px);
    }
    
    .stat-number {
        display: block !important;
        visibility: visible !important;
        font-size: 2.5rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #7f8c8d;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    
    @media (max-width: 992px) {
        .category-grid { grid-template-columns: repeat(2, 1fr); gap: 25px; }
    }
    
    @media (max-width: 768px) {
        .fasilitas-hero { padding: 100px 0 40px; }
        .fasilitas-hero h1 { font-size: 1.8rem; }
        .category-section { padding: 50px 0; }
        .section-header h2 { font-size: 1.6rem; }
        .category-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; gap: 15px; }
    }
    @media (max-width: 480px) {
        .fasilitas-hero h1 { font-size: 1.4rem; }
    }
</style>

{{-- HERO --}}
<section class="fasilitas-hero">
    <div class="container" data-aos="fade-up">
        <div class="badge">UNESCO Global Geopark</div>
        <h1>Fasilitas Geosite</h1>
        <div class="hero-divider"></div>
        <p>Layanan & Fasilitas Lengkap untuk Kenyamanan Wisatawan Geosite</p>
    </div>
</section>

{{-- KATEGORI FASILITAS --}}
<section class="category-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="subtitle">PILIH KATEGORI</span>
            <h2>Temukan Fasilitas Favoritmu</h2>
            <div class="divider"></div>
            <p>Nikmati pelayanan dan fasilitas terbaik di setiap kategorinya</p>
        </div>
        
        <div class="category-grid">

            {{-- 1. Akomodasi --}}
            <a href="{{ route('penginapan.index') }}" class="category-card" data-aos="fade-up" data-aos-delay="0">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop" alt="Akomodasi">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-bed"></i></div>
                    <h3>Akomodasi</h3>
                    <p>Penginapan nyaman, homestay, dan hotel di kawasan Geosite Danau Toba</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            {{-- 2. Kuliner --}}
            <a href="{{ route('kuliner.index') }}" class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2074&auto=format&fit=crop" alt="Kuliner">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-utensils"></i></div>
                    <h3>Kuliner</h3>
                    <p>Rumah makan, kuliner khas Batak, cafe, dan tempat bersantai</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            {{-- 3. Pusat Informasi --}}
            <a href="{{ route('fasilitas.kategori', 'pusat-informasi') }}" class="category-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=2070&auto=format&fit=crop" alt="Pusat Informasi">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-info-circle"></i></div>
                    <h3>Pusat Informasi</h3>
                    <p>Pusat informasi wisatawan, peta rute, dan layanan bantuan Geosite</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            {{-- 4. Toilet --}}
            <a href="{{ route('fasilitas.kategori', 'toilet') }}" class="category-card" data-aos="fade-up" data-aos-delay="300">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=2070&auto=format&fit=crop" alt="Toilet">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-restroom"></i></div>
                    <h3>Toilet</h3>
                    <p>Fasilitas toilet umum dan tempat bilas yang bersih dan terawat</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            {{-- 5. Parkir --}}
            <a href="{{ route('fasilitas.kategori', 'parkir') }}" class="category-card" data-aos="fade-up" data-aos-delay="400">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1506521781263-d8422e82f27a?q=80&w=2070&auto=format&fit=crop" alt="Parkir">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-parking"></i></div>
                    <h3>Parkir</h3>
                    <p>Area parkir luas dan aman untuk kendaraan pribadi maupun bus pariwisata</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            {{-- 6. Akses Jalan --}}
            <a href="{{ route('fasilitas.kategori', 'akses-jalan') }}" class="category-card" data-aos="fade-up" data-aos-delay="500">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2070&auto=format&fit=crop" alt="Akses Jalan">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-road"></i></div>
                    <h3>Akses Jalan</h3>
                    <p>Kondisi akses jalan, rute lokasi, dan informasi transportasi umum</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            {{-- 7. Pemandu Lokal --}}
            <a href="{{ route('fasilitas.kategori', 'pemandu-lokal') }}" class="category-card" data-aos="fade-up" data-aos-delay="600">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1530789253388-582c481c54b0?q=80&w=2070&auto=format&fit=crop" alt="Pemandu Lokal">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-user-tie"></i></div>
                    <h3>Pemandu Lokal</h3>
                    <p>Layanan pemandu wisata lokal ramah dan berpengalaman di kawasan Geosite</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

        </div>
    </div>
</section>

{{-- STATISTIK FASILITAS --}}
<div class="stats-grid">
    <div class="stat-item" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-number">{{ $totalPenginapan ?? 0 }}</div>
        <div class="stat-label">AKOMODASI & HOMESTAY</div>
    </div>
    <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-number">{{ $totalKuliner ?? 0 }}</div>
        <div class="stat-label">RESTORAN & KULINER</div>
    </div>
    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-number">{{ $totalFasilitas ?? 0 }}</div>
        <div class="stat-label">FASILITAS UMUM</div>
    </div>
    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-number">7</div>
        <div class="stat-label">KATEGORI UTAMA</div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 });
</script>

@endsection
