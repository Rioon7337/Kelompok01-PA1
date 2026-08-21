@extends('layouts.app')

@section('title', 'Berita & Informasi - Geosite Danau Toba')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@400;500;600;700&display=swap');
    
    .berita-hero {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-medium) 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .berita-hero::before {
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
    
    .berita-hero .container { position: relative; z-index: 2; }
    
    .berita-hero .badge {
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
    
    .berita-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    
    .berita-hero p {
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
        gap: 30px;
        max-width: 1100px;
        margin: 0 auto;
    }
    
    .category-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }
    
    .category-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    .card-img-wrapper {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .card-img-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4) 100%);
    }
    
    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }
    
    .category-card:hover .card-img-wrapper img {
        transform: scale(1.1);
    }
    
    .card-content {
        padding: 30px;
        text-align: center;
        background: white;
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-content h3 {
        color: #003366;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .card-content p {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        flex-grow: 1;
    }
    
    @media (max-width: 992px) {
        .category-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 768px) {
        .category-grid { grid-template-columns: 1fr; }
        .berita-hero { padding: 100px 0 40px; }
        .berita-hero h1 { font-size: 1.8rem; }
    }
</style>

<section class="berita-hero">
    <div class="container">
        <span class="badge" data-aos="fade-down">{{ __('app.news.portal_badge') ?? 'Pusat Informasi' }}</span>
        <h1 data-aos="fade-up" data-aos-delay="100">{{ __('app.news.portal_title') ?? 'Berita & Informasi' }}</h1>
        <div class="hero-divider" data-aos="fade-up" data-aos-delay="150"></div>
        <p data-aos="fade-up" data-aos-delay="200">{{ __('app.news.portal_subtitle') ?? 'Dapatkan kabar terbaru, jadwal kegiatan, dan pengumuman resmi seputar Geosite Danau Toba.' }}</p>
    </div>
</section>

<section class="category-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="subtitle">Kategori</span>
            <h2>Jelajahi Informasi</h2>
            <div class="divider"></div>
        </div>
        
        <div class="category-grid">

            {{-- Kartu Berita Terkini --}}
            <a href="{{ route('berita.terkini') }}" class="category-card" data-aos="fade-up">
                <div class="card-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?q=80&w=2070&auto=format&fit=crop" alt="Berita Terkini">
                </div>
                <div class="card-content">
                    <h3>{{ __('app.news.latest') ?? 'Berita Terkini' }}</h3>
                    <p style="margin-bottom: 15px;">{{ __('app.news.latest_desc') ?? 'Kumpulan berita terbaru dan liputan kegiatan di lingkungan Geosite.' }}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #64748b; text-align: left; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                        <div><i class="fas fa-arrow-right" style="color: var(--blue-dark); width: 20px;"></i> {{ app()->getLocale() == 'en' ? 'Click to view latest news' : 'Klik untuk melihat berita' }}</div>
                    </div>
                </div>
            </a>

            {{-- Kartu Agenda / Event --}}
            <a href="{{ route('agenda.index') }}" class="category-card" data-aos="fade-up" data-aos-delay="50">
                <div class="card-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop" alt="Agenda & Event">
                </div>
                <div class="card-content">
                    <h3>{{ __('app.news.agenda') ?? 'Agenda / Event' }}</h3>
                    <p style="margin-bottom: 15px;">{{ __('app.news.agenda_desc') ?? 'Jadwal kegiatan yang akan datang, festival, dan acara spesial.' }}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #64748b; text-align: left; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                        <div><i class="fas fa-arrow-right" style="color: var(--blue-dark); width: 20px;"></i> {{ app()->getLocale() == 'en' ? 'Click to view events' : 'Klik untuk melihat agenda' }}</div>
                    </div>
                </div>
            </a>

            {{-- Kartu Pengumuman --}}
            <a href="{{ route('pengumuman.index') }}" class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1588681664899-f142ff2dc9b1?q=80&w=1974&auto=format&fit=crop" alt="Pengumuman">
                </div>
                <div class="card-content">
                    <h3>{{ __('app.news.announcement') ?? 'Pengumuman' }}</h3>
                    <p style="margin-bottom: 15px;">{{ __('app.news.announcement_desc') ?? 'Informasi resmi, pemberitahuan penting, dan kebijakan dari pengelola.' }}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #64748b; text-align: left; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                        <div><i class="fas fa-arrow-right" style="color: var(--blue-dark); width: 20px;"></i> {{ app()->getLocale() == 'en' ? 'Click to view announcements' : 'Klik untuk melihat pengumuman' }}</div>
                    </div>
                </div>
            </a>

        </div>
    </div>
</section>

@endsection
