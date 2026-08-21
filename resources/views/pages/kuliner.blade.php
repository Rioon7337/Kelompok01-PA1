@extends('layouts.app')

@section('title', __('app.kuliner.page_title'))
@section('meta_description', __('app.kuliner.meta_description'))

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
    .hero-kuliner {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, #1a4a7a 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .hero-kuliner::before {
        content: '';
        position: absolute; top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: rotateSlow 25s linear infinite;
    }
    @keyframes rotateSlow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }
    .hero-kuliner .container { position: relative; z-index: 2; }
    .hero-kuliner .badge {
        display: inline-block;
        background: rgba(198,164,59,0.15);
        border: 1px solid rgba(198,164,59,0.3);
        color: var(--gold-light);
        padding: 6px 20px; border-radius: 50px;
        font-size: 0.6rem; letter-spacing: 3px;
        text-transform: uppercase; font-weight: 600; margin-bottom: 15px;
    }
    .hero-kuliner h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem; font-weight: 800;
        color: white; margin-bottom: 12px;
    }
    .hero-kuliner h1 span { color: var(--gold); }
    .hero-kuliner p {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem; max-width: 600px; margin: 0 auto;
    }
    .hero-divider {
        width: 60px; height: 2px;
        background: var(--gold);
        margin: 15px auto 20px; border-radius: 2px;
    }

    /* ======= CARD GRID ======= */
    .kuliner-section { padding: 70px 0 90px; }
    .dest-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }
    .dest-card {
        background: var(--white);
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 8px 24px rgba(15,23,42,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        text-decoration: none; color: inherit;
        display: flex; flex-direction: column;
        transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    }
    .dest-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); border-color: rgba(198,164,59,0.15); }
    .card-img-wrapper { position: relative; height: 230px; overflow: hidden; }
    .card-img-wrapper img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16,1,0.3,1);
    }
    .dest-card:hover .card-img-wrapper img { transform: scale(1.06); }
    .card-img-overlay {
        position: absolute; inset: 0;
        background: rgba(0,31,63,0.35); opacity: 0;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease; backdrop-filter: blur(2px);
    }
    .card-img-overlay i {
        color: white; font-size: 1.3rem; background: var(--gold);
        padding: 14px; border-radius: 50%; transform: scale(0.8);
        transition: transform 0.4s cubic-bezier(0.175,0.885,0.32,1.275);
    }
    .dest-card:hover .card-img-overlay { opacity: 1; }
    .dest-card:hover .card-img-overlay i { transform: scale(1); }
    .card-badge {
        position: absolute; top: 15px; left: 15px;
        background: white; color: var(--primary-dark);
        padding: 5px 14px; border-radius: 30px;
        font-size: 0.68rem; font-weight: 700; z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .card-content { padding: 24px; flex: 1; display: flex; flex-direction: column; }
    .card-title {
        font-size: 1.15rem; font-weight: 700; color: var(--primary-dark);
        font-family: 'Playfair Display', serif; margin-bottom: 10px; line-height: 1.45;
    }
    .card-excerpt {
        font-size: 0.87rem; color: var(--text-gray); line-height: 1.65; margin-bottom: 14px;
        display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .card-meta {
        display: flex; flex-direction: column; gap: 6px;
        font-size: 0.8rem; color: var(--text-light);
        margin-bottom: 16px;
    }
    .card-meta span { display: flex; align-items: center; gap: 7px; }
    .card-meta i { color: var(--gold-dark); width: 14px; }
    .card-footer {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: auto; padding-top: 16px; border-top: 1px solid #f1f5f9;
    }
    .card-price {
        font-size: 0.82rem; font-weight: 700;
        color: var(--primary); background: #e8f0fb;
        padding: 4px 12px; border-radius: 20px;
    }
    .read-more {
        font-size: 0.8rem; font-weight: 700; color: var(--gold-dark);
        text-decoration: none; display: flex; align-items: center; gap: 6px;
        transition: all 0.3s ease;
    }
    .read-more:hover { gap: 10px; color: var(--primary); }

    .empty-state { text-align: center; padding: 80px 20px; grid-column: 1 / -1; }
    .empty-state i { font-size: 3rem; color: var(--gold); opacity: 0.3; display: block; margin-bottom: 16px; }
    .empty-state p { color: var(--text-light); }

    .pagination-wrapper { display: flex; justify-content: center; margin-top: 50px; }

    @media (max-width: 768px) {
        .hero-kuliner { padding: 100px 0 40px; }
        .hero-kuliner h1 { font-size: 1.9rem; }
        .kuliner-section { padding: 50px 0 70px; }
        .dest-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 576px) {
        .hero-kuliner h1 { font-size: 1.5rem; }
        .card-content { padding: 18px; }
    }
</style>

{{-- HERO --}}
<div class="hero-kuliner">
    <div class="container">
        <div class="badge">UNESCO Global Geopark</div>
        <h1><span>{{ __('app.kuliner.title') }}</span></h1>
        <div class="hero-divider"></div>
        <p>{{ __('app.kuliner.subtitle') }}</p>
    </div>
</div>

{{-- DAFTAR kuliner --}}
<section class="kuliner-section">
    <div class="container">
        <div class="dest-grid">
            @forelse($kuliner as $item)
            <a href="{{ route('kuliner.detail', $item->id) }}" class="dest-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 80 }}">
                <div class="card-img-wrapper">
                    @php
                        $imgSrc = $item->gambar && file_exists(public_path($item->gambar))
                            ? asset($item->gambar)
                            : 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $imgSrc }}" alt="{{ $item->nama_trans }}" loading="lazy"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop'">
                    <div class="card-img-overlay"><i class="fas fa-arrow-right"></i></div>
                    <span class="card-badge">kuliner</span>
                </div>
                <div class="card-content">
                    <div class="card-title">{{ $item->nama_trans }}</div>
                    <div class="card-excerpt">{{ strip_tags($item->deskripsi_trans) }}</div>
                    <div class="card-meta">
                        @if($item->lokasi)
                        <span><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}</span>
                        @endif
                        @if($item->kontak)
                        <span><i class="fas fa-phone"></i> {{ $item->kontak }}</span>
                        @endif
                    </div>
                    <div class="card-footer">
                        @if($item->harga)
                            <span class="card-price"><i class="fas fa-tag"></i> {{ $item->harga }}</span>
                        @else
                            <span></span>
                        @endif
                        <span class="read-more">Lihat Detail <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-bed"></i>
                <p>Belum ada data kuliner yang tersedia.</p>
                <p style="font-size:0.8rem;margin-top:8px;">Silahkan cek kembali nanti.</p>
            </div>
            @endforelse
        </div>

        @if($kuliner->hasPages())
        <div class="pagination-wrapper">{{ $kuliner->links() }}</div>
        @endif
    </div>
</section>

@endsection
