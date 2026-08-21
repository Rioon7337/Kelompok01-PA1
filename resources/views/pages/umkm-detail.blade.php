@extends('layouts.app')

@section('title', $item->nama_usaha_trans . ' - UMKM Geosite Danau Toba')

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
        --bg-light:     #f8fafc;
        --shadow-xl:    0 25px 50px -12px rgba(15,23,42,0.15);
    }
    body { font-family: 'Inter', sans-serif; background: var(--bg-light); }

    /* ======= HERO ======= */
    .detail-hero {
        position: relative;
        margin-top: 60px;
        height: 600px;
        overflow: hidden;
    }
    .detail-hero img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 8s ease;
    }
    .detail-hero:hover img { transform: scale(1.04); }
    .detail-hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(0,20,60,0.1) 0%, rgba(0,20,60,0.82) 100%);
        display: flex; align-items: flex-end;
        padding: 60px 80px;
    }
    .detail-hero-content { color: white; max-width: 900px; }
    .detail-hero-badge {
        display: inline-block;
        background: var(--gold); color: var(--primary-dark);
        padding: 7px 22px; border-radius: 50px;
        font-size: 0.78rem; font-weight: 700;
        letter-spacing: 2px; text-transform: uppercase;
        margin-bottom: 18px;
        box-shadow: 0 4px 15px rgba(198,164,59,0.4);
    }
    .detail-hero-content h1 {
        font-size: 3.5rem; font-weight: 800;
        font-family: 'Playfair Display', serif;
        line-height: 1.15;
        text-shadow: 0 3px 20px rgba(0,0,0,0.4);
        margin-bottom: 16px;
    }
    .detail-hero-meta {
        display: flex; gap: 30px; flex-wrap: wrap;
        opacity: 0.9; font-size: 0.95rem;
    }
    .detail-hero-meta span { display: flex; align-items: center; gap: 8px; }
    .detail-hero-meta i { color: var(--gold-light); }

    /* ======= BODY ======= */
    .detail-body { padding: 70px 0 100px; }
    .container { max-width: 1300px; margin: 0 auto; padding: 0 40px; }

    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 50px;
        align-items: start;
    }

    /* ======= MAIN COLUMN ======= */
    .detail-main {
        background: var(--white);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(15,23,42,0.05);
    }
    .detail-main-foto {
        width: 100%;
        max-height: 520px;
        object-fit: cover;
        display: block;
        border-bottom: 4px solid var(--gold);
    }
    .detail-main-body { padding: 44px; }
    .detail-main-body h2 {
        font-size: 1.8rem; font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: var(--primary-dark);
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 2px solid #f1f5f9;
        display: flex; align-items: center; gap: 12px;
    }
    .detail-main-body h2 .icon-wrap {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .detail-main-body h2 .icon-wrap i { color: var(--primary-dark); font-size: 1.1rem; }
    .deskripsi {
        font-size: 1.05rem; color: var(--text-gray);
        line-height: 1.9; white-space: pre-line; text-align: justify;
    }

    /* ======= SIDEBAR ======= */
    .detail-sidebar { display: flex; flex-direction: column; gap: 24px; }
    .sidebar-card {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        border: 1px solid rgba(15,23,42,0.05);
    }
    .sidebar-card-header {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        padding: 18px 24px;
        display: flex; align-items: center; gap: 10px;
        color: white;
    }
    .sidebar-card-header i { color: var(--gold-light); font-size: 1rem; }
    .sidebar-card-header h4 {
        font-size: 0.9rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px;
        margin: 0; color: white;
    }
    .sidebar-card-body { padding: 24px; }

    .info-row {
        display: flex; gap: 16px; align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row .icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, rgba(198,164,59,0.12), rgba(198,164,59,0.05));
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .info-row .icon i { color: var(--gold); font-size: 0.85rem; }
    .info-row .info-text-wrap { flex: 1; }
    .info-row .info-label {
        font-size: 0.72rem; color: var(--text-light);
        text-transform: uppercase; letter-spacing: 1px;
        font-weight: 600; margin-bottom: 4px;
    }
    .info-row .info-text {
        font-size: 0.95rem; color: var(--text-dark);
        font-weight: 500;
    }

    .btn-back {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 16px 24px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0,51,102,0.25);
    }
    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,51,102,0.35);
        color: white;
    }

    /* ======= RELATED ======= */
    .related-section { margin-top: 70px; }
    .related-section-header {
        display: flex; align-items: center; gap: 16px;
        margin-bottom: 32px;
    }
    .related-section-header h3 {
        font-size: 1.6rem; font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: var(--primary-dark);
        margin: 0;
    }
    .related-section-header h3 span { color: var(--gold); }
    .related-section-header .divider-line {
        flex: 1; height: 2px;
        background: linear-gradient(to right, #e2e8f0, transparent);
    }
    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }
    .related-card {
        background: var(--white); border-radius: 18px; overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        text-decoration: none; color: inherit;
        display: flex; flex-direction: column;
        border: 1px solid rgba(15,23,42,0.04);
    }
    .related-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); }
    .related-card-img-wrap { height: 200px; overflow: hidden; position: relative; }
    .related-card-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.6s ease;
    }
    .related-card:hover .related-card-img-wrap img { transform: scale(1.08); }
    .related-content { padding: 20px; }
    .related-title {
        font-size: 1.05rem; font-weight: 700;
        color: var(--primary-dark); margin-bottom: 8px;
        font-family: 'Playfair Display', serif;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .related-link {
        font-size: 0.82rem; color: var(--gold-dark);
        font-weight: 700; display: flex; align-items: center; gap: 6px;
        transition: gap 0.2s ease;
    }
    .related-card:hover .related-link { gap: 10px; }

    /* ======= RESPONSIVE ======= */
    @media (max-width: 1100px) {
        .detail-layout { grid-template-columns: 1fr 320px; gap: 36px; }
        .container { padding: 0 30px; }
    }
    @media (max-width: 992px) {
        .detail-layout { grid-template-columns: 1fr; }
        .detail-hero { height: 450px; }
        .detail-hero-overlay { padding: 40px; }
        .detail-hero-content h1 { font-size: 2.6rem; }
        .related-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .detail-hero { height: 360px; }
        .detail-hero-overlay { padding: 28px; }
        .detail-hero-content h1 { font-size: 2rem; }
        .detail-body { padding: 40px 0 70px; }
        .detail-main-body { padding: 28px; }
        .container { padding: 0 20px; }
        .related-grid { grid-template-columns: 1fr; }
        .detail-hero-meta { gap: 16px; font-size: 0.85rem; }
    }
    @media (max-width: 576px) {
        .detail-hero { height: 300px; }
        .detail-hero-content h1 { font-size: 1.7rem; }
    }
</style>

{{-- HERO GAMBAR --}}
<div class="detail-hero">
    <img src="{{ $item->foto_utama ? asset($item->foto_utama) : asset('image/default.jpg') }}"
         alt="{{ $item->nama_usaha_trans }}"
         onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
    <div class="detail-hero-overlay">
        <div class="detail-hero-content">
            <div class="detail-hero-badge">🏪 {{ __('app.umkm.title') }}</div>
            <h1>{{ $item->nama_usaha_trans }}</h1>
            <div class="detail-hero-meta">
                @if($item->pemilik)
                    <span><i class="fas fa-user"></i> {{ $item->pemilik }}</span>
                @endif
                @if($item->alamat)
                    <span><i class="fas fa-map-marker-alt"></i> {{ $item->alamat }}</span>
                @endif
                @if($item->no_telepon && $item->no_telepon != '-')
                    <span><i class="fas fa-phone"></i> {{ $item->no_telepon }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- KONTEN UTAMA --}}
<section class="detail-body">
    <div class="container">
        <div class="detail-layout">

            {{-- Kolom kiri: Foto Tambahan + Deskripsi --}}
            <div class="detail-main">
                @if($item->foto_tambahan && file_exists(public_path($item->foto_tambahan)))
                    <img src="{{ asset($item->foto_tambahan) }}"
                         alt="Foto {{ $item->nama_usaha_trans }}"
                         class="detail-main-foto"
                         onerror="this.style.display='none'">
                @endif
                <div class="detail-main-body">
                    <h2>
                        <div class="icon-wrap"><i class="fas fa-store"></i></div>
                        {{ __('app.umkm.about_title') }}
                    </h2>
                    <div class="deskripsi">{{ $item->deskripsi_trans ?? (app()->getLocale() == 'en' ? 'Description not available.' : 'Deskripsi belum tersedia.') }}</div>
                </div>
            </div>

            {{-- Kolom kanan: Sidebar info --}}
            <div class="detail-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-card-header">
                        <i class="fas fa-info-circle"></i>
                        <h4>{{ app()->getLocale() == 'en' ? 'Complete Information' : 'Informasi Lengkap' }}</h4>
                    </div>
                    <div class="sidebar-card-body">
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ __('app.umkm.owner') }}</div>
                                <div class="info-text">{{ $item->pemilik ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ __('app.umkm.address') }}</div>
                                <div class="info-text">{{ $item->alamat ?? 'Geosite Danau Toba, Sumatera Utara' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ __('app.umkm.phone') }}</div>
                                <div class="info-text">{{ $item->no_telepon ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ app()->getLocale() == 'en' ? 'Last Updated' : 'Terakhir Diperbarui' }}</div>
                                <div class="info-text">{{ $item->updated_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar-card">
                    <div class="sidebar-card-header">
                        <i class="fas fa-compass"></i>
                        <h4>{{ app()->getLocale() == 'en' ? 'Navigation' : 'Navigasi' }}</h4>
                    </div>
                    <div class="sidebar-card-body">
                        <a href="{{ route('fasilitas.umkm') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            {{ __('app.umkm.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- UMKM Lainnya --}}
        @if($related->count() > 0)
        <div class="related-section">
            <div class="related-section-header">
                <h3>{{ app()->getLocale() == 'en' ? 'Other' : 'UMKM' }} <span>{{ app()->getLocale() == 'en' ? 'MSMEs' : 'Lainnya' }}</span></h3>
                <div class="divider-line"></div>
            </div>
            <div class="related-grid">
                @foreach($related as $rel)
                <a href="{{ route('fasilitas.umkm.detail', $rel->id) }}" class="related-card">
                    <div class="related-card-img-wrap">
                        <img src="{{ $rel->foto_utama ? asset($rel->foto_utama) : asset('image/default.jpg') }}"
                             alt="{{ $rel->nama_usaha_trans }}" loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                    </div>
                    <div class="related-content">
                        <div class="related-title">{{ $rel->nama_usaha_trans }}</div>
                        <div class="related-link">{{ __('app.common.read_more') }} <i class="fas fa-arrow-right"></i></div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

