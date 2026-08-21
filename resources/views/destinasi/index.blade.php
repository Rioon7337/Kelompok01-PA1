@extends('layouts.app')

@section('title', 'Destinasi - Geosite Danau Toba')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@400;500;600;700&display=swap');
    
    .destinasi-hero {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-medium) 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .destinasi-hero::before {
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
    
    .destinasi-hero .container { position: relative; z-index: 2; }
    
    .destinasi-hero .badge {
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
    
    .destinasi-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    
    .destinasi-hero p {
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
        height: 260px;
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
        font-size: 28px;
        color: #c6a43b;
    }
    
    .card-content h3 {
        font-size: 1.5rem;
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
    
    .stats-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #c6a43b, #e8c45a, #c6a43b);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }
    
    .stat-item {
        text-align: center;
        padding: 25px;
        background: rgba(255,255,255,0.08);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-8px);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #c6a43b;
        margin-bottom: 10px;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .stat-label {
        font-size: 0.7rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.8);
    }
    .stat-number {
    display: block !important;
    visibility: visible !important;
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
    font-size: 2.5rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    letter-spacing: 1px;
}
    
    @media (max-width: 992px) {
        .category-grid { grid-template-columns: repeat(2, 1fr); gap: 25px; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 768px) {
        .destinasi-hero { padding: 100px 0 40px; }
        .destinasi-hero h1 { font-size: 1.8rem; }
        .category-section { padding: 50px 0; }
        .section-header h2 { font-size: 1.6rem; }
        .category-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; gap: 15px; }
    }
    @media (max-width: 480px) {
        .destinasi-hero h1 { font-size: 1.4rem; }
    }
</style>

<section class="destinasi-hero">
    <div class="container" data-aos="fade-up">
        <div class="badge">UNESCO Global Geopark</div>
        <h1>Destinasi Geosite</h1>
        <div class="hero-divider"></div>
        <p>Jelajahi Pesona Caldera Danau Toba</p>
    </div>
</section>

<section class="category-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="subtitle">PILIH KATEGORI</span>
            <h2>Temukan Destinasi Favoritmu</h2>
            <div class="divider"></div>
            <p>Nikmati pengalaman wisata yang berbeda di setiap kategorinya</p>
        </div>
        
        <div class="category-grid">
            <a href="{{ url('/destinasi/alam') }}" class="category-card" data-aos="fade-up" data-aos-delay="0">
                <div class="card-image">
                    <img src="{{ asset('image/meat/batubasiha1.png') }}" alt="Destinasi Alam">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-mountain"></i></div>
                    <h3>Destinasi Alam</h3>
                    <p>Goa alami, formasi batuan unik, dan keindahan alam Danau Toba</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="{{ url('/destinasi/buatan') }}" class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-image">
                    <img src="{{ asset('image/meat/slide2.jpg') }}" alt="Destinasi Buatan">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-building"></i></div>
                    <h3>Destinasi Buatan</h3>
                    <p>Spot pantai, homestay, trekking, dan fasilitas wisata modern</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="{{ url('/destinasi/budaya') }}" class="category-card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-image">
                    <img src="{{ asset('image/meat/ulos.jpg') }}" alt="Destinasi Budaya">
                    <div class="card-overlay"></div>
                </div>
                <div class="card-content">
                    <div class="card-icon"><i class="fas fa-landmark"></i></div>
                    <h3>Destinasi Budaya</h3>
                    <p>Tenun ulos, rumah adat, dan kearifan lokal Batak Toba</p>
                    <span class="btn-explore">Jelajahi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </div>
</section>
<div class="stats-grid">
    <div class="stat-item" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-number">16</div>
        <div class="stat-label">GEOSITES</div>
    </div>
    <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-number">74.000+</div>
        <div class="stat-label">TAHUN SEJARAH</div>
    </div>
    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-number">15+</div>
        <div class="stat-label">WARISAN BUDAYA</div>
    </div>
    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-number">100+</div>
        <div class="stat-label">UMKM LOKAL</div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 });
</script>

@endsection