@extends('layouts.app')

@section('title', $item->nama_trans . ' - Penginapan Geosite Danau Toba')
@section('meta_description', Str::limit(strip_tags($item->deskripsi_trans), 160))

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
        position: relative; margin-top: 60px;
        height: 580px; overflow: hidden;
    }
    .detail-hero img { width: 100%; height: 100%; object-fit: cover; transition: transform 8s ease; }
    .detail-hero:hover img { transform: scale(1.04); }
    .detail-hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(0,20,60,0.1) 0%, rgba(0,20,60,0.82) 100%);
        display: flex; align-items: flex-end; padding: 60px 80px;
    }
    .detail-hero-content { color: white; max-width: 900px; }
    .detail-hero-badge {
        display: inline-block; background: var(--gold); color: var(--primary-dark);
        padding: 7px 22px; border-radius: 50px;
        font-size: 0.78rem; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; margin-bottom: 18px;
        box-shadow: 0 4px 15px rgba(198,164,59,0.4);
    }
    .detail-hero-content h1 {
        font-size: 3.2rem; font-weight: 800;
        font-family: 'Playfair Display', serif;
        line-height: 1.15; text-shadow: 0 3px 20px rgba(0,0,0,0.4); margin-bottom: 16px;
    }
    .detail-hero-meta { display: flex; gap: 20px; flex-wrap: wrap; }
    .detail-hero-meta span {
        display: flex; align-items: center; gap: 8px;
        font-size: 0.87rem; color: rgba(255,255,255,0.85);
        background: rgba(255,255,255,0.12); backdrop-filter: blur(8px);
        padding: 7px 16px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.15);
    }
    .detail-hero-meta i { color: var(--gold-light); }

    /* ======= BODY ======= */
    .detail-body { padding: 70px 0 90px; }
    .detail-layout { display: grid; grid-template-columns: 1fr 360px; gap: 40px; }
    .detail-main {}
    .detail-main-foto {
        width: 100%; border-radius: 20px; object-fit: cover;
        max-height: 400px; margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    .detail-main-body {
        background: white; border-radius: 20px; padding: 40px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .detail-main-body h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem; color: var(--primary-dark); margin-bottom: 20px;
        display: flex; align-items: center; gap: 14px;
    }
    .detail-main-body .icon-wrap {
        width: 42px; height: 42px; background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        border-radius: 12px; display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1rem; flex-shrink: 0;
    }
    .deskripsi { font-size: 0.95rem; color: var(--text-gray); line-height: 1.85; white-space: pre-wrap; }

    /* ======= SIDEBAR ======= */
    .sidebar-card {
        background: white; border-radius: 20px; overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06); margin-bottom: 24px;
    }
    .sidebar-card-header {
        padding: 18px 24px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex; align-items: center; gap: 12px; color: white;
    }
    .sidebar-card-header i { font-size: 1.1rem; color: var(--gold-light); }
    .sidebar-card-header h4 { margin: 0; font-size: 1rem; font-weight: 700; }
    .sidebar-card-body { padding: 20px 24px; }
    .info-row {
        display: flex; gap: 14px; padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .icon {
        width: 36px; height: 36px; background: #f0f4ff;
        border-radius: 10px; display: flex; align-items: center;
        justify-content: center; flex-shrink: 0;
    }
    .info-row .icon i { color: var(--gold-dark); font-size: 0.85rem; }
    .info-label { font-size: 0.72rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
    .info-text { font-size: 0.88rem; font-weight: 600; color: var(--text-dark); }
    .btn-back {
        display: flex; align-items: center; gap: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white; padding: 12px 20px; border-radius: 12px;
        text-decoration: none; font-size: 0.85rem; font-weight: 700;
        transition: all 0.3s ease;
    }
    .btn-back:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,51,102,0.3); color: white; }
    .btn-whatsapp {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        background: #25D366; color: white; padding: 12px 20px; border-radius: 12px;
        text-decoration: none; font-size: 0.85rem; font-weight: 700;
        transition: all 0.3s ease; margin-top: 10px;
    }
    .btn-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(37,211,102,0.35); color: white; }

    /* ======= RELATED ======= */
    .related-section { margin-top: 70px; }
    .related-section-header { text-align: center; margin-bottom: 36px; }
    .related-section-header h3 { font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--primary-dark); margin-bottom: 12px; }
    .related-section-header h3 span { color: var(--gold); }
    .divider-line { width: 50px; height: 2px; background: var(--gold); margin: 0 auto; border-radius: 2px; }
    .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .related-card { background: white; border-radius: 16px; overflow: hidden; text-decoration: none; color: inherit; box-shadow: 0 4px 16px rgba(0,0,0,0.07); transition: all 0.3s ease; }
    .related-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,0.12); }
    .related-card-img-wrap { height: 170px; overflow: hidden; }
    .related-card-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .related-card:hover .related-card-img-wrap img { transform: scale(1.06); }
    .related-content { padding: 18px; }
    .related-title { font-size: 0.95rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 8px; line-height: 1.4; }
    .related-link { font-size: 0.78rem; font-weight: 700; color: var(--gold-dark); display: flex; align-items: center; gap: 5px; }

    @media (max-width: 992px) { .detail-layout { grid-template-columns: 1fr; } .related-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .detail-hero { height: 420px; margin-top: 60px; }
        .detail-hero-overlay { padding: 30px 30px; }
        .detail-hero-content h1 { font-size: 2rem; }
        .detail-body { padding: 40px 0 60px; }
        .detail-main-body { padding: 24px; }
        .related-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 576px) {
        .detail-hero-content h1 { font-size: 1.5rem; }
        .detail-hero-meta span { font-size: 0.75rem; padding: 5px 12px; }
    }
</style>

{{-- HERO --}}
<div class="detail-hero">
    @php
        $imgSrc = $item->gambar && file_exists(public_path($item->gambar))
            ? asset($item->gambar)
            : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop';
    @endphp
    <img src="{{ $imgSrc }}" alt="{{ $item->nama_trans }}"
         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop'">
    <div class="detail-hero-overlay">
        <div class="detail-hero-content" data-aos="fade-up">
            <div class="detail-hero-badge"><i class="fas fa-bed"></i> Penginapan</div>
            <h1>{{ $item->nama_trans }}</h1>
            <div class="detail-hero-meta">
                @if($item->lokasi)
                <span><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}</span>
                @endif
                @if($item->harga)
                <span><i class="fas fa-tag"></i> {{ $item->harga }}</span>
                @endif
                @if($item->kontak)
                <span><i class="fas fa-phone"></i> {{ $item->kontak }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- KONTEN UTAMA --}}
<section class="detail-body">
    <div class="container">
        <div class="detail-layout">

            {{-- Kolom Kiri: Deskripsi --}}
            <div class="detail-main">
                @if($item->gambar_tambahan && file_exists(public_path($item->gambar_tambahan)))
                    <img src="{{ asset($item->gambar_tambahan) }}"
                         alt="Foto tambahan {{ $item->nama_trans }}"
                         class="detail-main-foto"
                         onerror="this.style.display='none'">
                @endif
                <div class="detail-main-body">
                    <h2>
                        <div class="icon-wrap"><i class="fas fa-bed"></i></div>
                        {{ app()->getLocale() == 'en' ? 'About This Accommodation' : 'Tentang Penginapan Ini' }}
                    </h2>
                    <div class="deskripsi">{{ $item->deskripsi_trans ?? (app()->getLocale() == 'en' ? 'Description not available.' : 'Deskripsi belum tersedia.') }}</div>
                </div>
            </div>

            {{-- Kolom Kanan: Sidebar --}}
            <div class="detail-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-card-header">
                        <i class="fas fa-info-circle"></i>
                        <h4>{{ app()->getLocale() == 'en' ? 'Accommodation Info' : 'Informasi Penginapan' }}</h4>
                    </div>
                    <div class="sidebar-card-body">
                        @if($item->lokasi)
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ app()->getLocale() == 'en' ? 'Location' : 'Lokasi' }}</div>
                                <div class="info-text">{{ $item->lokasi }}</div>
                            </div>
                        </div>
                        @endif
                        @if($item->harga)
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-tag"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ app()->getLocale() == 'en' ? 'Price' : 'Harga' }}</div>
                                <div class="info-text">{{ $item->harga }}</div>
                            </div>
                        </div>
                        @endif
                        @if($item->kontak)
                        <div class="info-row">
                            <div class="icon"><i class="fas fa-phone"></i></div>
                            <div class="info-text-wrap">
                                <div class="info-label">{{ app()->getLocale() == 'en' ? 'Contact' : 'Kontak' }}</div>
                                <div class="info-text">{{ $item->kontak }}</div>
                            </div>
                        </div>
                        @endif
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
                        <a href="{{ route('penginapan.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            {{ app()->getLocale() == 'en' ? 'Back to Accommodation List' : 'Kembali ke Daftar Penginapan' }}
                        </a>
                        @if($item->kontak)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->kontak) }}" target="_blank" class="btn-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            {{ app()->getLocale() == 'en' ? 'Contact via WhatsApp' : 'Hubungi via WhatsApp' }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Penginapan Lainnya --}}
        @if($related->count() > 0)
        <div class="related-section">
            <div class="related-section-header">
                <h3>{{ app()->getLocale() == 'en' ? 'Other' : 'Penginapan' }} <span>{{ app()->getLocale() == 'en' ? 'Accommodations' : 'Lainnya' }}</span></h3>
                <div class="divider-line"></div>
            </div>
            <div class="related-grid">
                @foreach($related as $rel)
                <a href="{{ route('penginapan.detail', $rel->id) }}" class="related-card">
                    <div class="related-card-img-wrap">
                        @php $relImg = $rel->gambar && file_exists(public_path($rel->gambar)) ? asset($rel->gambar) : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600&auto=format&fit=crop'; @endphp
                        <img src="{{ $relImg }}" alt="{{ $rel->nama_trans }}" loading="lazy" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600&auto=format&fit=crop'">
                    </div>
                    <div class="related-content">
                        <div class="related-title">{{ $rel->nama_trans }}</div>
                        @if($rel->harga)<div style="font-size:0.78rem;color:#64748b;margin-bottom:6px;"><i class="fas fa-tag" style="color:#c6a43b;"></i> {{ $rel->harga }}</div>@endif
                        <div class="related-link">{{ app()->getLocale() == 'en' ? 'View Detail' : 'Lihat Detail' }} <i class="fas fa-arrow-right"></i></div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection
