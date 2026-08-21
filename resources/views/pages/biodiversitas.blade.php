@extends('layouts.app')

@section('title', 'Biodiversitas - Geosite Danau Toba')

@section('content')
<style>
    .hero-biodiversitas {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-medium) 100%);
        padding: 140px 0 70px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .hero-biodiversitas::before {
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
    .hero-biodiversitas .container { position: relative; z-index: 2; }
    .hero-biodiversitas .badge {
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
    .hero-biodiversitas h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
    }
    .hero-biodiversitas h1 span { color: var(--gold); }
    .hero-biodiversitas p {
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
    .grid-biodiversitas {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 380px));
        gap: 30px;
        padding: 60px 0;
        justify-content: center;
    }
    .card-biodiversitas {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .card-biodiversitas:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    .card-biodiversitas img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .card-biodiversitas .content {
        padding: 20px;
    }
    .card-biodiversitas .content h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #003366;
        margin-bottom: 8px;
    }
    .card-biodiversitas .content p {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .badge-kategori {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .badge-flora { background: #dcfce7; color: #166534; }
    .badge-fauna { background: #fef3c7; color: #92400e; }
    .badge-ekosistem { background: #dbeafe; color: #1e40af; }
    @media (max-width: 768px) {
        .grid-biodiversitas { grid-template-columns: 1fr; }
        .hero-biodiversitas { padding: 100px 0 40px; }
        .hero-biodiversitas h1 { font-size: 1.8rem; }
    }
    @media (max-width: 480px) {
        .hero-biodiversitas h1 { font-size: 1.4rem; }
    }

</style>


<div class="hero-biodiversitas">
    <div class="container">
        <div class="badge">UNESCO Global Geopark</div>
        <h1>{{ __('app.biodiversity.title') }}</h1>
        <div class="hero-divider"></div>
        <p>{{ __('app.biodiversity.subtitle') }}</p>
    </div>
</div>

<div class="container">
    <div class="grid-biodiversitas">
        @forelse($data as $item)
        <div class="card-biodiversitas" onclick="window.location.href='{{ route('biodiversitas.detail', $item->slug) }}'">
            @php
                $imgSrc = $item->gambar ? asset($item->gambar) : asset('image/default.jpg');
            @endphp
            <img src="{{ $imgSrc }}" alt="{{ $item->nama_trans }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
            <div class="content">
                <span class="badge-kategori badge-{{ $item->kategori }}">
                    {{ ucfirst($item->kategori) }}
                </span>
                <h3>{{ Str::limit($item->nama_trans, 40) }}</h3>
                <p>{{ Str::limit(strip_tags($item->deskripsi_trans), 100) }}</p>
                @if($item->lokasi)
                    <p style="font-size:0.7rem; color:#94a3b8; margin-top:6px;">
                        <i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}
                    </p>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column: span 3; text-align:center; padding:60px;">
            <i class="fas fa-leaf" style="font-size:3rem; color:#c6a43b; opacity:0.3;"></i>
            <p style="margin-top:16px; color:#94a3b8;">{{ __('app.common.no_data') }}</p>
        </div>
        @endforelse
    </div>

    @if($data->hasPages())
    <div style="display:flex; justify-content:center; margin-bottom:40px;">
        {{ $data->links() }}
    </div>
    @endif
</div>
@endsection
