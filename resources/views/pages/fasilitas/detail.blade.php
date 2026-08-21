@extends('layouts.app')

@section('title', $item->nama_trans . ' - Geosite Danau Toba')

@section('content')

<style>
    :root {
        --primary:      #003366;
        --primary-light:#1a4a7a;
        --primary-dark: #001f3f;
        --gold:         #c6a43b;
        --gold-light:   #f1d26b;
        --gold-dark:    #967a28;
        --text-dark:    #0f172a;
        --text-gray:    #334155;
        --text-light:   #64748b;
        --white:        #ffffff;
        --bg-main:      #f4f7f6;
        --shadow-sm:    0 4px 6px rgba(0,0,0,0.05);
        --shadow-md:    0 10px 20px rgba(0,0,0,0.05);
    }
    body { font-family: 'Inter', sans-serif; background: var(--bg-main); }

    /* ── Hero ── */
    .hero-section {
        position: relative;
        height: 380px;
        margin-top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .hero-bg {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
        z-index: 0;
    }
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 31, 63, 0.6);
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .hero-subtitle {
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 2px;
        color: var(--gold-light);
        text-transform: uppercase;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }

    /* ── Breadcrumb ── */
    .breadcrumb-bar {
        background: var(--white);
        padding: 15px 0;
        border-bottom: 1px solid #eaeaea;
        font-size: 0.85rem;
        color: var(--text-light);
    }
    .breadcrumb-bar a {
        color: var(--text-gray);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb-bar a:hover {
        color: var(--primary);
    }
    .breadcrumb-bar span {
        margin: 0 8px;
        color: #ccc;
    }
    .breadcrumb-current {
        color: var(--gold-dark);
        font-weight: 600;
    }

    /* ── Container Utama ── */
    .main-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* ── Card Top (Foto & Info Singkat) ── */
    .top-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        margin-bottom: 30px;
    }
    .top-card-left {
        position: relative;
    }
    .top-card-left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-height: 380px;
    }
    .photo-badge {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: rgba(0, 31, 63, 0.8);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(4px);
    }

    .top-card-right {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--gold-light);
        color: var(--primary-dark);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        width: fit-content;
    }
    .top-card-right h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }
    .location-text {
        font-size: 0.9rem;
        color: var(--gold-dark);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .short-desc {
        font-size: 0.95rem;
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 25px;
    }

    /* Kotak Info Jam & Harga & Kontak */
    .info-boxes {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
    }
    .info-box {
        flex: 1;
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px 12px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .info-box i {
        color: var(--gold);
        font-size: 1.2rem;
        margin-bottom: 8px;
    }
    .info-box span {
        font-size: 0.68rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
        font-weight: 600;
    }
    .info-box strong {
        font-size: 0.9rem;
        color: var(--primary-dark);
        font-weight: 700;
    }

    /* ── Card Bottom (Deskripsi Lengkap) ── */
    .desc-card {
        background: var(--white);
        border-radius: 20px;
        padding: 40px;
        box-shadow: var(--shadow-md);
        margin-bottom: 40px;
    }
    .desc-card h3 {
        font-size: 1.4rem;
        color: var(--primary-dark);
        font-weight: 700;
        margin-bottom: 20px;
    }
    .desc-card p {
        font-size: 0.95rem;
        color: var(--text-gray);
        line-height: 1.8;
        white-space: pre-line;
        text-align: justify;
    }

    /* ── Rekomendasi ── */
    .rekomendasi-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 25px;
        text-align: center;
    }
    .rekomendasi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    /* ── Action Button ── */
    .action-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 60px;
    }
    .btn-return {
        background: var(--primary-dark);
        color: white;
        padding: 14px 32px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,31,63,0.3);
    }
    .btn-return:hover {
        background: var(--primary);
        transform: translateY(-2px);
        color: white;
    }
    .btn-contact {
        background: #25d366;
        color: white;
        padding: 14px 32px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(37,211,102,0.3);
    }
    .btn-contact:hover {
        background: #1eb854;
        transform: translateY(-2px);
        color: white;
    }

    /* ── Responsif ── */
    @media (max-width: 768px) {
        .top-card { grid-template-columns: 1fr; }
        .top-card-left img { min-height: 250px; height: 250px; }
        .top-card-right { padding: 30px 20px; }
        .hero-title { font-size: 2.2rem; }
        .desc-card { padding: 30px 20px; }
        .action-container { flex-direction: column; align-items: center; }
    }
</style>

{{-- HERO SECTION --}}
<section class="hero-section">
    <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_trans }}" class="hero-bg" onerror="this.onerror=null; this.src='{{ asset('image/fasilitas/default.jpg') }}'">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">{{ $item->nama_trans }}</h1>
        <div class="hero-subtitle">Fasilitas {{ ucwords($item->jenis ?? 'Geosite') }} - Geosite Danau Toba</div>
    </div>
</section>

{{-- BREADCRUMB --}}
<div class="breadcrumb-bar">
    <div class="container" style="max-width:1000px; padding:0 20px; margin:0 auto;">
        <a href="{{ url('/') }}">Beranda</a> <span>></span>
        <a href="{{ route('fasilitas.index') }}">Fasilitas</a> <span>></span>
        @if($item->jenis)
        <a href="{{ route('fasilitas.kategori', Str::slug($item->jenis)) }}">{{ ucwords($item->jenis) }}</a> <span>></span>
        @endif
        <span class="breadcrumb-current">{{ $item->nama_trans }}</span>
    </div>
</div>

{{-- KONTEN UTAMA --}}
<main class="main-container">
    
    {{-- Card Atas: Foto & Info Singkat --}}
    <div class="top-card">
        <div class="top-card-left">
            <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_trans }}" onerror="this.onerror=null; this.src='{{ asset('image/fasilitas/default.jpg') }}'">
            <div class="photo-badge">
                <i class="fas fa-camera"></i> 1 Foto
            </div>
        </div>
        <div class="top-card-right">
            <div class="cat-badge">
                {{ ucwords($item->jenis ?? 'Fasilitas') }}
            </div>
            
            <h2>{{ $item->nama_trans }}</h2>
            
            <div class="location-text">
                <i class="fas fa-map-marker-alt"></i>
                {{ $item->lokasi ?? 'Geosite Danau Toba, Desa Meat' }}
            </div>
            
            <div class="short-desc">
                {{ Str::limit(strip_tags($item->deskripsi_trans), 150) }}
            </div>
            
            <div class="info-boxes">
                <div class="info-box">
                    <i class="fas fa-tag"></i>
                    <span>Harga / Tarif</span>
                    <strong>{{ $item->harga ?? 'Gratis / N/A' }}</strong>
                </div>
                <div class="info-box">
                    <i class="fas fa-phone"></i>
                    <span>Kontak</span>
                    <strong>{{ $item->kontak ?? '-' }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Bawah: Deskripsi Lengkap --}}
    <div class="desc-card">
        <h3>{{ app()->getLocale() == 'en' ? 'Full Description' : 'Deskripsi Lengkap' }}</h3>
        <p>{{ $item->deskripsi_trans }}</p>
    </div>

    {{-- Rekomendasi Fasilitas Lainnya --}}
    @if(isset($related) && count($related) > 0)
    <h3 class="rekomendasi-title">Fasilitas Lainnya</h3>
    <div class="rekomendasi-grid">
        @foreach($related as $rel)
        <a href="{{ route('fasilitas.detail', $rel->id) }}" style="text-decoration: none; color: inherit;">
            <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid #e2e8f0; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="height: 160px; overflow: hidden;">
                    <img src="{{ $rel->gambar_url }}" alt="{{ $rel->nama_trans }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.src='{{ asset('image/fasilitas/default.jpg') }}'">
                </div>
                <div style="padding: 18px;">
                    <span style="font-size: 0.68rem; font-weight: 700; color: var(--gold-dark); text-transform: uppercase;">{{ ucwords($rel->jenis ?? 'Fasilitas') }}</span>
                    <h4 style="font-size: 1rem; font-weight: 700; color: var(--primary-dark); margin: 6px 0;">{{ $rel->nama_trans }}</h4>
                    <p style="font-size: 0.8rem; color: var(--text-light); margin: 0;">{{ Str::limit(strip_tags($rel->deskripsi_trans), 70) }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="action-container">
        <a href="{{ route('fasilitas.index') }}" class="btn-return">
            <i class="fas fa-arrow-left"></i> Kembali ke Fasilitas
        </a>
        @if($item->kontak)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->kontak) }}" target="_blank" class="btn-contact">
            <i class="fab fa-whatsapp"></i> Hubungi Pengelola
        </a>
        @endif
    </div>

</main>

@endsection
