@extends('layouts.app')

@section('title', 'Cultural Diversity - Geosite Danau Toba')

@section('content')

<style>
    .hero-diversity {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-medium) 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .hero-diversity::before {
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
    .hero-diversity .container { position: relative; z-index: 2; }
    .hero-diversity .badge {
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
    .hero-diversity h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    .hero-diversity h1 span { color: var(--gold); }
    .hero-diversity p {
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

    .grid-diversity {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 380px));
        gap: 30px;
        padding: 60px 0;
        justify-content: center;
    }
    .card-diversity {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15 rgba(0,0,0,0.06);
        transition: all 0.4s ease;
        cursor: pointer;
    }
    .card-diversity:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.12);
    }
    .card-diversity img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .card-diversity:hover img { transform: scale(1.03); }
    .card-diversity .content { padding: 18px 20px; }
    .card-diversity .content .badge-kategori {
        display: inline-block;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .badge-tarian { background: #fce4ec; color: #c62828; }
    .badge-musik { background: #e8f5e9; color: #2e7d32; }
    .badge-upacara { background: #fff3e0; color: #e65100; }
    .badge-kerajinan { background: #e3f2fd; color: #1565c0; }
    .badge-kuliner { background: #f3e5f5; color: #7b1fa2; }
    
    .card-diversity .content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #003366;
        margin-bottom: 6px;
    }
    .card-diversity .content .lokasi {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 8px;
    }
    .card-diversity .content .lokasi i { color: #c6a43b; margin-right: 4px; }
    .card-diversity .content p {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-diversity .content .btn-detail {
        display: inline-block;
        margin-top: 10px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #c6a43b;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .card-diversity .content .btn-detail:hover { color: #003366; letter-spacing: 0.5px; }

    .empty-state {
        text-align: center;
        padding: 60px;
        color: #94a3b8;
        grid-column: span 3;
    }
    .empty-state i { font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 15px; }

    @media (max-width: 992px) {
        .grid-diversity { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .hero-diversity { padding: 100px 0 40px; }
        .hero-diversity h1 { font-size: 1.8rem; }
        .grid-diversity { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .hero-diversity h1 { font-size: 1.4rem; }
    }
</style>

<!-- HERO -->
<section class="hero-diversity">
    <div class="container">
        <div class="badge">UNESCO Global Geopark</div>
        <h1>{{ __('app.cultural.title') }}</h1>
        <div class="hero-divider"></div>
        <p>{{ __('app.cultural.subtitle') }}</p>
    </div>
</section>

<!-- GRID -->
<section style="background: #f8fafc;">
    <div class="container">
        <div class="grid-diversity">
            @forelse($data as $item)
            <div class="card-diversity" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" onclick="window.location.href='{{ route('cultural-diversity.detail', $item->slug) }}'">
                @php
                    $imgSrc = $item->gambar ? asset($item->gambar) : asset('image/default.jpg');
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $item->nama_trans }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                <div class="content">
                    <span class="badge-kategori badge-{{ $item->kategori }}">
                        {{ ucfirst($item->kategori) }}
                    </span>
                    <h3>{{ Str::limit($item->nama_trans, 40) }}</h3>
                    <div class="lokasi"><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi ?? 'Danau Toba' }}</div>
                    <p>{{ Str::limit(strip_tags($item->deskripsi_trans), 100) }}</p>
                    <a href="{{ route('cultural-diversity.detail', $item->slug) }}" class="btn-detail">{{ __('app.common.read_more') }} →</a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-people-arrows"></i>
                <p>{{ __('app.common.no_data') }}</p>
            </div>
            @endforelse
        </div>

        @if($data->hasPages())
        <div style="display:flex; justify-content:center; padding-bottom:40px;">
            {{ $data->links() }}
        </div>
        @endif
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 600, once: true, offset: 40, easing: 'ease-out-quad' });
</script>

@endsection
