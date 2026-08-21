@extends('layouts.app')

@section('title', 'Sovenir & UMKM - Geosite Danau Toba')

@section('content')

<style>
    /* ==================== FONTS & VARIABLES ==================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap');
    
    :root {
        --primary: #003366;
        --primary-light: #1a4a7a;
        --primary-dark: #001f3f;
        --gold: #c6a43b;
        --gold-light: #f1d26b;
        --gold-dark: #967a28;
        --text-dark: #0f172a;
        --text-gray: #334155;
        --text-light: #64748b;
        --white: #ffffff;
        --bg-light: #f8fafc;
        --bg-gray: #f1f5f9;
        
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 10px 30px rgba(0,0,0,0.06);
        --shadow-xl: 0 25px 50px -12px rgba(15, 23, 42, 0.15);
        
        --radius-lg: 20px;
        --radius-md: 14px;
        --radius-sm: 8px;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
        background-color: var(--bg-light);
        -webkit-font-smoothing: antialiased;
    }
    
    /* ==================== HERO SECTION ==================== */
    .hero-umkm {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-medium) 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .hero-umkm::before {
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
    .hero-umkm .container { position: relative; z-index: 2; }
    .hero-umkm .badge {
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
    .hero-umkm h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    .hero-umkm h1 span { color: var(--gold); }
    .hero-umkm p {
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
    
    /* ==================== SECTION ==================== */
    .berita-section {
        padding: 80px 0;
        background: var(--bg-light);
    }
    
    .container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
    }
    
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 380px));
        gap: 35px;
        justify-content: center;
    }
    
    .berita-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(15, 23, 42, 0.04);
        text-decoration: none;
        color: inherit;
    }
    
    .berita-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(198, 164, 59, 0.15);
    }
    
    .card-image-wrapper {
        position: relative;
        height: 230px;
        overflow: hidden;
    }
    
    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .berita-card:hover .card-image-wrapper img {
        transform: scale(1.05);
    }
    
    .card-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.3);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(2px);
    }
    
    .card-image-overlay i {
        color: var(--white);
        font-size: 1.25rem;
        background: var(--gold);
        padding: 12px;
        border-radius: 50%;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }
    
    .berita-card:hover .card-image-overlay {
        opacity: 1;
    }
    
    .berita-card:hover .card-image-overlay i {
        transform: scale(1);
    }
    
    .card-category {
        position: absolute;
        top: 16px;
        left: 16px;
        background: var(--white);
        color: var(--primary-dark);
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.68rem;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 2px 6px rgba(15,23,42,0.06);
    }
    
    .card-content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        font-family: 'Playfair Display', serif;
        margin-bottom: 12px;
        line-height: 1.4;
        transition: color 0.2s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-title:hover {
        color: var(--gold-dark);
    }
    
    .card-excerpt {
        font-size: 0.88rem;
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid var(--bg-gray);
    }
    
    .read-more {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--gold-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }
    
    .read-more:hover {
        gap: 10px;
        color: var(--primary);
    }

    .empty-state { grid-column: 1 / -1; text-align: center; padding: 80px 20px; }
    .empty-state i { font-size: 3rem; color: var(--gold); opacity: 0.25; display: block; margin-bottom: 16px; }
    .empty-state p { color: var(--text-light); }
    .pagination-wrapper { display: flex; justify-content: center; margin-top: 50px; }

    @media (max-width: 992px) { .hero-umkm h1 { font-size: 2.4rem; } }
    @media (max-width: 768px) { 
        .hero-umkm { padding: 100px 0 40px; } 
        .hero-umkm h1 { font-size: 1.8rem; } 
        .berita-section { padding: 60px 0; } 
    }
    @media (max-width: 576px) { 
        .hero-umkm h1 { font-size: 1.4rem; } 
        .card-content { padding: 20px; } 
    }
</style>

<div class="hero-umkm">
    <div class="container">
        <div class="badge">UNESCO Global Geopark</div>
        <h1>{{ app()->getLocale() == 'en' ? 'Explore Souvenirs & MSMEs' : 'Jelajahi Sovenir & UMKM' }}</h1>
        <div class="hero-divider"></div>
        <p>{{ __('app.umkm.subtitle') }}</p>
    </div>
</div>

<section class="berita-section">
    <div class="container">
        <div class="berita-grid">
            @forelse($umkm as $item)
            <a href="{{ route('fasilitas.umkm.detail', $item->id) }}" class="berita-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="card-image-wrapper">
                    <img src="{{ $item->foto_utama ? asset($item->foto_utama) : asset('image/default.jpg') }}" alt="{{ $item->nama_usaha_trans }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                    <div class="card-image-overlay">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <span class="card-category">UMKM</span>
                </div>
                
                <div class="card-content">
                    <h3 class="card-title">{{ $item->nama_usaha_trans }}</h3>
                    <p class="card-excerpt">{{ Str::limit(strip_tags($item->deskripsi_trans ?? '-'), 110) }}</p>
                    <div class="card-footer">
                        <span class="read-more">
                            {{ __('app.common.read_more') }} <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-store"></i>
                <p>{{ __('app.umkm.no_data') }}</p>
            </div>
            @endforelse
        </div>
        
        @if($umkm->hasPages())
        <div class="pagination-wrapper mt-5 d-flex justify-content-center">
            {{ $umkm->links() }}
        </div>
        @endif
    </div>
</section>

@endsection
