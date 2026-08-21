@extends('layouts.app')

@section('title', 'Tentang Geosite - Geopark Danau Toba')

@section('content')

<style>
    /* ==================== FONTS & VARIABLES ==================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    :root {
        --primary: #003366;
        --primary-light: #1a4a7a;
        --gold: #c6a43b;
        --gold-light: #e8c45a;
        --gold-dark: #a8882e;
        --text-dark: #0f172a;
        --text-gray: #475569;
        --text-light: #64748b;
        --white: #ffffff;
        --bg-light: #f8fafc;
        --bg-gray: #f1f5f9;
        --shadow: 0 4px 20px rgba(0,0,0,0.06);
        --shadow-lg: 0 10px 40px rgba(0,0,0,0.1);
        --shadow-xl: 0 20px 60px rgba(0,0,0,0.12);
        --radius: 20px;
    }

    /* ==================== HERO ==================== */
    .hero-tentang {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .hero-tentang::before {
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
    .hero-tentang .container { position: relative; z-index: 2; }
    .hero-tentang .badge {
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
    .hero-tentang h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    .hero-tentang h1 span { color: var(--gold); }
    .hero-tentang p {
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
    .section { padding: 70px 0; }
    .section-white { background: var(--bg-light); }
    .section-light { background: var(--bg-gray); }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

    .section-header {
        text-align: center;
        margin-bottom: 45px;
    }
    .section-header .badge {
        display: inline-block;
        background: rgba(198, 164, 59, 0.1);
        color: var(--gold-dark);
        padding: 4px 16px;
        border-radius: 30px;
        font-size: 0.6rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 12px;
    }
    .section-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 15px;
    }
    .section-header .divider {
        width: 50px;
        height: 2px;
        background: var(--gold);
        margin: 0 auto;
        transition: width 0.4s ease;
    }
    .section-header:hover .divider { width: 80px; }
    .section-header p {
        color: var(--text-light);
        max-width: 600px;
        margin: 18px auto 0;
        font-size: 0.9rem;
        line-height: 1.7;
    }

    /* ==================== GEOSITE LIST ==================== */
    .geosite-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }
    .geosite-card {
        background: white;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.4s ease;
        cursor: pointer;
    }
    .geosite-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }
    .geosite-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .geosite-card:hover img { transform: scale(1.03); }
    .geosite-card .content { padding: 18px 20px; }
    .geosite-card .content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 6px;
    }
    .geosite-card .content .lokasi {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-bottom: 8px;
    }
    .geosite-card .content .lokasi i { color: var(--gold); margin-right: 4px; }
    .geosite-card .content p {
        font-size: 0.8rem;
        color: var(--text-gray);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-align: justify;
    }
    .geosite-card .content .btn-detail {
        display: inline-block;
        margin-top: 10px;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--gold-dark);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .geosite-card .content .btn-detail:hover { color: var(--primary); letter-spacing: 0.5px; }

    /* ==================== PROFILE WILAYAH ==================== */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }
    .profile-text p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 0.95rem;
        margin-bottom: 15px;
        text-align: justify;
    }
    .profile-text ul {
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }
    .profile-text ul li {
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.9rem;
        color: var(--text-gray);
    }
    .profile-text ul li i {
        color: var(--gold);
        width: 20px;
        text-align: center;
    }
    .profile-image {
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        cursor: pointer;
        transition: all 0.4s ease;
    }
    .profile-image:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-xl);
    }
    .profile-image img {
        width: 100%;
        height: 350px;
        object-fit: cover;
    }

    /* ==================== VISI MISI ==================== */
    .visi-misi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 35px;
    }
    .visi-misi-card {
        background: white;
        border-radius: var(--radius);
        padding: 30px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: all 0.4s ease;
        border-top: 4px solid var(--gold);
    }
    .visi-misi-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .visi-misi-card .icon {
        font-size: 2.5rem;
        color: var(--gold);
        margin-bottom: 15px;
        display: block;
    }
    .visi-misi-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 12px;
    }
    .visi-misi-card p {
        color: var(--text-gray);
        line-height: 1.7;
        font-size: 0.9rem;
    }
    .visi-misi-card ul {
        list-style: none;
        padding: 0;
        text-align: left;
        margin-top: 15px;
    }
    .visi-misi-card ul li {
        padding: 8px 0;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.9rem;
        color: var(--text-gray);
        border-bottom: 1px solid #f1f5f9;
    }
    .visi-misi-card ul li:last-child { border-bottom: none; }
    .visi-misi-card ul li i {
        color: var(--gold);
        margin-top: 3px;
        font-size: 0.8rem;
    }

    /* ==================== NILAI GEOSITE ==================== */
    .nilai-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }
    .nilai-card {
        background: white;
        border-radius: var(--radius);
        padding: 25px 20px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.4s ease;
    }
    .nilai-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .nilai-card .icon {
        font-size: 2.2rem;
        color: var(--gold);
        margin-bottom: 12px;
        display: block;
    }
    .nilai-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 6px;
    }
    .nilai-card p {
        font-size: 0.8rem;
        color: var(--text-gray);
        line-height: 1.6;
    }

    /* ==================== PENGELOLA ==================== */
    .pengelola-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }
    .pengelola-card {
        background: white;
        border-radius: var(--radius);
        padding: 25px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.4s ease;
    }
    .pengelola-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .pengelola-card .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }
    .pengelola-card h4 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 4px;
    }
    .pengelola-card .jabatan {
        font-size: 0.75rem;
        color: var(--gold-dark);
        font-weight: 600;
    }
    .pengelola-card p {
        font-size: 0.8rem;
        color: var(--text-gray);
        margin-top: 8px;
        line-height: 1.6;
    }

    /* ==================== MAPS ==================== */
    .maps-container {
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: all 0.4s ease;
        background: white;
    }
    .maps-container:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }
    .maps-container iframe {
        width: 100%;
        height: 400px;
        border: 0;
    }
    .maps-info {
        padding: 20px 25px;
        background: white;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }
    .maps-info .location-list {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .maps-info .location-list a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        background: var(--bg-light);
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .maps-info .location-list a:hover {
        background: var(--gold);
        color: var(--primary);
        border-color: var(--gold);
        transform: translateY(-2px);
    }
    .maps-info .location-list a i { color: var(--gold); }
    .maps-info .location-list a:hover i { color: var(--primary); }
    .maps-note {
        font-size: 0.75rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .maps-note i { color: var(--gold); }

    /* ==================== CTA ==================== */
    .cta-section {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 60px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: rotateSlow 30s linear infinite;
    }
    .cta-content {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .cta-content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
    }
    .cta-content .divider {
        width: 50px;
        height: 2px;
        background: var(--gold);
        margin: 0 auto 20px;
    }
    .cta-content p {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        line-height: 1.7;
        margin-bottom: 25px;
    }
    .cta-btn {
        display: inline-block;
        background: var(--gold);
        color: var(--primary);
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .cta-btn:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        letter-spacing: 2px;
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .geosite-grid { grid-template-columns: repeat(2, 1fr); }
        .profile-grid { grid-template-columns: 1fr; gap: 30px; }
        .visi-misi-grid { grid-template-columns: 1fr; }
        .nilai-grid { grid-template-columns: repeat(2, 1fr); }
        .pengelola-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-tentang h1 { font-size: 2.2rem; }
    }

    @media (max-width: 768px) {
        .hero-tentang { padding: 100px 0 40px; }
        .hero-tentang h1 { font-size: 1.8rem; }
        .section { padding: 50px 0; }
        .section-header h2 { font-size: 1.6rem; }
        .geosite-grid { grid-template-columns: 1fr; }
        .nilai-grid { grid-template-columns: 1fr; }
        .pengelola-grid { grid-template-columns: 1fr; }
        .maps-container iframe { height: 280px; }
        .maps-info { flex-direction: column; text-align: center; }
        .maps-info .location-list { justify-content: center; }
        .profile-image img { height: 250px; }
        .cta-content h3 { font-size: 1.5rem; }
    }

    @media (max-width: 480px) {
        .hero-tentang h1 { font-size: 1.4rem; }
        .container { padding: 0 16px; }
        .section-header h2 { font-size: 1.3rem; }
        .maps-container iframe { height: 220px; }
        .maps-info .location-list a { font-size: 0.65rem; padding: 4px 12px; }
    }

    /* ==================== LIGHTBOX ==================== */
    .lightbox-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 80px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.85);
        backdrop-filter: blur(5px);
    }
    .lightbox-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 80vh;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        animation: zoomIn 0.3s ease;
        object-fit: contain;
    }
    .lightbox-close {
        position: absolute;
        top: 25px;
        right: 40px;
        color: #f1f1f1;
        font-size: 45px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    .lightbox-close:hover {
        color: var(--gold);
    }
    @keyframes zoomIn {
        from {transform:scale(0.8); opacity: 0;} 
        to {transform:scale(1); opacity: 1;}
    }
</style>

<!-- ==================== HERO ==================== -->
<section class="hero-tentang">
    <div class="container">
        <div class="badge">UNESCO Global Geopark</div>
        <h1>{{ app()->getLocale() == 'en' ? 'About' : 'Tentang' }} <span>Geosite</span></h1>
        <div class="hero-divider"></div>
        <p>{{ app()->getLocale() == 'en' ? 'Learn more about Geopark Danau Toba, the world geological heritage recognized by UNESCO' : 'Mengenal lebih dalam tentang Geopark Danau Toba, warisan geologi dunia yang diakui UNESCO' }}</p>
    </div>
</section>


<!-- ==================== PROFIL WILAYAH ==================== -->
<section class="section section-light" id="profil">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="badge">{{ app()->getLocale() == 'en' ? 'Profile' : 'Profil' }}</span>
            <h2>{{ app()->getLocale() == 'en' ? 'Regional Profile' : 'Profil Wilayah' }}</h2>
            <div class="divider"></div>
            <p>{{ app()->getLocale() == 'en' ? 'Getting to know the Geopark Danau Toba area more closely' : 'Mengenal lebih dekat kawasan Geopark Danau Toba' }}</p>
        </div>
        <div class="profile-grid">
            <div class="profile-text" data-aos="fade-right">
                <p><strong>Geopark Danau Toba</strong> {{ app()->getLocale() == 'en' ? 'is located in North Sumatra Province, covering 7 regencies/cities around Lake Toba. This area was recognized as a' : 'terletak di Provinsi Sumatera Utara, mencakup 7 kabupaten/kota di sekitar Danau Toba. Kawasan ini diakui sebagai' }} <strong>UNESCO Global Geopark</strong> {{ app()->getLocale() == 'en' ? 'on July 7, 2020.' : 'pada tanggal 7 Juli 2020.' }}</p>
                <p>{{ app()->getLocale() == 'en' ? 'With an area of approximately 1,930 km2, Geopark Danau Toba has a unique geological feature in the form of the world largest volcanic lake caldera, formed from a supervolcano eruption 74,000 years ago.' : 'Dengan luas area sekitar 1.930 km2, Geopark Danau Toba memiliki keunikan geologi berupa kaldera danau vulkanik terbesar di dunia yang terbentuk dari letusan supervolcano 74.000 tahun lalu.' }}</p>
                <ul>
                    <li><i class="fas fa-check-circle"></i> <strong>{{ app()->getLocale() == 'en' ? 'Area:' : 'Luas Wilayah:' }}</strong> ± 1.930 km²</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Geosite:</strong> {{ app()->getLocale() == 'en' ? '16 geosite points' : '16 titik geosite' }}</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Status:</strong> UNESCO Global Geopark (2020)</li>
                    <li><i class="fas fa-check-circle"></i> <strong>{{ app()->getLocale() == 'en' ? 'Regencies:' : 'Kabupaten:' }}</strong> Toba, Samosir, Tapanuli Utara, Humbang Hasundutan, Dairi, Karo, Simalungun</li>
                </ul>
            </div>
            <div class="profile-image" data-aos="fade-left" onclick="openLightbox('{{ asset('image/meat/danau.jpg') }}')">
                <img src="{{ asset('image/meat/danau.jpg') }}" alt="Danau Toba" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
            </div>
        </div>
    </div>
</section>

<!-- ==================== VISI MISI ==================== -->
<section class="section section-white">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="badge">{{ app()->getLocale() == 'en' ? 'Vision & Mission' : 'Visi & Misi' }}</span>
            <h2>{{ app()->getLocale() == 'en' ? 'Vision & Mission of Geopark' : 'Visi & Misi Geopark' }}</h2>
            <div class="divider"></div>
            <p>{{ app()->getLocale() == 'en' ? 'Commitment to managing Geopark Danau Toba for the future' : 'Komitmen pengelolaan Geopark Danau Toba untuk masa depan' }}</p>
        </div>
        <div class="visi-misi-grid">
            <!-- VISI -->
            <div class="visi-misi-card" data-aos="fade-up">
                <span class="icon"><i class="fas fa-eye"></i></span>
                <h3>{{ app()->getLocale() == 'en' ? 'Vision' : 'Visi' }}</h3>
                <p>{{ app()->getLocale() == 'en' ? 'Making Geopark Danau Toba a sustainable world-class geotourism destination, preserving geological, cultural, and biodiversity heritage for community welfare.' : 'Menjadikan Geopark Danau Toba sebagai destinasi geowisata kelas dunia yang berkelanjutan, melestarikan warisan geologi, budaya, dan keanekaragaman hayati untuk kesejahteraan masyarakat.' }}</p>
            </div>

            <!-- MISI -->
            <div class="visi-misi-card" data-aos="fade-up" data-aos-delay="100">
                <span class="icon"><i class="fas fa-bullseye"></i></span>
                <h3>{{ app()->getLocale() == 'en' ? 'Mission' : 'Misi' }}</h3>
                <ul>
                    <li><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'en' ? 'Preserve and sustainably manage geological heritage' : 'Melestarikan dan mengelola warisan geologi secara berkelanjutan' }}</li>
                    <li><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'en' ? 'Develop tourism potential based on education and conservation' : 'Mengembangkan potensi wisata berbasis edukasi dan konservasi' }}</li>
                    <li><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'en' ? 'Empower local communities through the creative economy' : 'Memberdayakan masyarakat lokal melalui ekonomi kreatif' }}</li>
                    <li><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'en' ? 'Increase awareness of the importance of geoparks' : 'Meningkatkan kesadaran akan pentingnya geopark' }}</li>
                    <li><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'en' ? 'Build global partnerships for geopark development' : 'Membangun kemitraan global untuk pengembangan geopark' }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ==================== NILAI GEOSITE ==================== -->
<section class="section section-light">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="badge">{{ app()->getLocale() == 'en' ? 'Values' : 'Nilai' }}</span>
            <h2>{{ app()->getLocale() == 'en' ? 'Geosite Values' : 'Nilai Geosite' }}</h2>
            <div class="divider"></div>
            <p>{{ app()->getLocale() == 'en' ? 'Four main value pillars of Geopark Danau Toba' : 'Empat pilar nilai utama Geopark Danau Toba' }}</p>
        </div>
        <div class="nilai-grid">
            <div class="nilai-card" data-aos="zoom-in">
                <span class="icon"><i class="fas fa-mountain"></i></span>
                <h4>{{ app()->getLocale() == 'en' ? 'Geological Value' : 'Nilai Geologi' }}</h4>
                <p>{{ app()->getLocale() == 'en' ? 'Unique rock formations, geological structures, and volcanic processes that formed Lake Toba' : 'Keunikan formasi batuan, struktur geologi, dan proses vulkanik yang membentuk Danau Toba' }}</p>
            </div>
            <div class="nilai-card" data-aos="zoom-in" data-aos-delay="100">
                <span class="icon"><i class="fas fa-leaf"></i></span>
                <h4>{{ app()->getLocale() == 'en' ? 'Ecological Value' : 'Nilai Ekologi' }}</h4>
                <p>{{ app()->getLocale() == 'en' ? 'High biodiversity, lake ecosystems, forests, and endemic wildlife' : 'Keanekaragaman hayati yang tinggi, ekosistem danau, hutan, dan satwa endemik' }}</p>
            </div>
            <div class="nilai-card" data-aos="zoom-in" data-aos-delay="200">
                <span class="icon"><i class="fas fa-people-arrows"></i></span>
                <h4>{{ app()->getLocale() == 'en' ? 'Cultural Value' : 'Nilai Budaya' }}</h4>
                <p>{{ app()->getLocale() == 'en' ? 'Rich Batak cultural heritage, traditions, arts, and living local wisdom' : 'Warisan budaya Batak yang kaya, tradisi, seni, dan kearifan lokal yang masih hidup' }}</p>
            </div>
            <div class="nilai-card" data-aos="zoom-in" data-aos-delay="300">
                <span class="icon"><i class="fas fa-gem"></i></span>
                <h4>{{ app()->getLocale() == 'en' ? 'Scientific Value' : 'Nilai Ilmiah' }}</h4>
                <p>{{ app()->getLocale() == 'en' ? 'A natural laboratory for geological, archaeological, and earth science research' : 'Laboratorium alam untuk penelitian geologi, arkeologi, dan ilmu kebumian' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== PENGELOLA GEOSITE ==================== -->
<section class="section section-white">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="badge">{{ app()->getLocale() == 'en' ? 'Management' : 'Pengelola' }}</span>
            <h2>{{ app()->getLocale() == 'en' ? 'Geosite Managers' : 'Pengelola Geosite' }}</h2>
            <div class="divider"></div>
            <p>{{ app()->getLocale() == 'en' ? 'A dedicated management team for Geopark Danau Toba' : 'Tim pengelola yang berdedikasi untuk Geopark Danau Toba' }}</p>
        </div>
        <div class="pengelola-grid">
            @foreach($pengelolas as $index => $pengelola)
                <div class="pengelola-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    @if($pengelola->image)
                        <div class="avatar" style="overflow:hidden; padding:0; background:none; border: 2px solid var(--primary); cursor:pointer;" onclick="openLightbox('{{ asset($pengelola->image) }}')">
                            <img src="{{ asset($pengelola->image) }}" alt="{{ $pengelola->nama }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                        </div>
                    @else
                        @php
                            $words = explode(' ', $pengelola->nama);
                            $initials = '';
                            foreach(array_slice($words, 0, 2) as $w) {
                                $initials .= strtoupper(substr($w, 0, 1));
                            }
                        @endphp
                        <div class="avatar">{{ $initials }}</div>
                    @endif
                    <h4>{{ $pengelola->nama }}</h4>
                    <div class="jabatan">{{ $pengelola->jabatan }}</div>
                    <p>{{ $pengelola->deskripsi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==================== PETA LOKASI ==================== -->
<section class="section section-light">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="badge">{{ app()->getLocale() == 'en' ? 'Location' : 'Lokasi' }}</span>
            <h2>{{ app()->getLocale() == 'en' ? 'Geosite Location Map' : 'Peta Lokasi Geosite' }}</h2>
            <div class="divider"></div>
            <p>{{ app()->getLocale() == 'en' ? 'Strategic location in the Balige area, easily accessible from various points' : 'Lokasi strategis di kawasan Balige, mudah diakses dari berbagai titik' }}</p>
        </div>
        <div class="maps-container" data-aos="zoom-in">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31892.45522108672!2d98.96240686371921!3d2.316828414712955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e1b2618ee6569%3A0x36e2c26fb20124ca!2sMeat%2C%20Kec.%20Tampahan%2C%20Toba%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1779549114075!5m2!1sid!2sid"
                width="600"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
            <div class="maps-info">
                <div class="location-list">
                    <a href="https://www.google.com/maps/search/?api=1&query=Balige+Toba" target="_blank">
                        <i class="fas fa-location-dot"></i> Balige
                    </a>
                    <a href="https://www.google.com/maps/search/?api=1&query=Meat+Village+Toba" target="_blank">
                        <i class="fas fa-location-dot"></i> Meat
                    </a>
                    <a href="https://www.google.com/maps/search/?api=1&query=Batu+Bahisan+Balige" target="_blank">
                        <i class="fas fa-location-dot"></i> Batu Basiha
                    </a>
                    <a href="https://www.google.com/maps/search/?api=1&query=Liang+Sipege+Balige" target="_blank">
                        <i class="fas fa-location-dot"></i> Liang Sipege
                    </a>
                </div>
                <div class="maps-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Klik lokasi untuk melihat detail di Google Maps</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="fade-up">
            <h3>Jelajahi Geopark Danau Toba</h3>
            <div class="divider"></div>
            <p>Temukan keajaiban geologi, kekayaan budaya, dan keindahan alam di Geopark Danau Toba, warisan dunia yang diakui UNESCO.</p>
            <a href="{{ url('/destinasi') }}" class="cta-btn">Mulai Jelajahi</a>
        </div>
    </div>
</section>

<!-- ==================== LIGHTBOX MODAL ==================== -->
<div id="imageLightbox" class="lightbox-modal" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightboxImage">
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 600, once: true, offset: 40, easing: 'ease-out-quad' });

    // Fungsi Lightbox
    function openLightbox(imgSrc) {
        document.getElementById('imageLightbox').style.display = "block";
        document.getElementById('lightboxImage').src = imgSrc;
    }
    
    function closeLightbox() {
        document.getElementById('imageLightbox').style.display = "none";
    }
</script>

@endsection
