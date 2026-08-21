@extends('layouts.app')

@section('title', $item->nama_trans . ' - Biodiversitas')

@section('content')

<style>
    .detail-hero {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 120px 0 40px;
        margin-top: 60px;
        color: white;
    }
    .detail-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
    }
    .detail-hero .meta {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.7);
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .detail-hero .meta i { color: #c6a43b; margin-right: 4px; }
    .detail-content { padding: 50px 0; background: #f8fafc; }
    .detail-content .main-img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .detail-content .info-box {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        margin-top: 20px;
    }
    .detail-content .info-box .label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-content .info-box .value {
        font-size: 0.95rem;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .detail-content .deskripsi {
        font-size: 1rem;
        line-height: 1.8;
        color: #475569;
        margin-top: 20px;
        text-align: justify;
    }
    .btn-back {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        padding: 10px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-top: 20px;
    }
    .btn-back:hover { background: #e2e8f0; transform: translateY(-2px); }

    .badge-status {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-flora { background: #dcfce7; color: #166534; }
    .badge-fauna { background: #fef3c7; color: #92400e; }
    .badge-ekosistem { background: #dbeafe; color: #1e40af; }

    .rekomendasi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 20px;
    }
    .rekomendasi-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .rekomendasi-item:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .rekomendasi-item img {
        width: 100%;
        height: 140px;
        object-fit: cover;
    }
    .rekomendasi-item .caption { padding: 12px; }
    .rekomendasi-item .caption h4 {
        font-size: 0.85rem;
        font-weight: 600;
        color: #003366;
        margin: 0;
    }

    @media (max-width: 768px) {
        .detail-hero { padding: 100px 0 30px; }
        .detail-hero h1 { font-size: 1.5rem; }
        .detail-content .main-img { max-height: 250px; }
        .rekomendasi-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .rekomendasi-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- HERO -->
<section class="detail-hero">
    <div class="container">
        <a href="{{ route('biodiversitas') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.85rem;">
            <i class="fas fa-arrow-left"></i> {{ __('app.biodiversity.back') }}
        </a>
        <h1>{{ $item->nama_trans }}</h1>
        <div class="meta">
            <span><i class="fas fa-tag"></i> {{ ucfirst($item->kategori) }}</span>
            <span><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi ?? 'Danau Toba' }}</span>
            <span><i class="fas fa-eye"></i> {{ number_format($item->views ?? 0) }} {{ __('app.common.views_count') }}</span>
            @if($item->status_keberadaan)
            <span><i class="fas fa-shield-alt"></i> {{ $item->status_keberadaan }}</span>
            @endif
        </div>
    </div>
</section>

<!-- CONTENT -->
<section class="detail-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @php
                    $imgSrc = $item->gambar ? asset($item->gambar) : asset('image/default.jpg');
                    if (!empty($item->gambar) && file_exists(public_path($item->gambar))) {
                        $imgSrc = asset($item->gambar);
                    } elseif (!empty($item->gambar) && file_exists(public_path('image/biodiversitas/' . $item->gambar))) {
                        $imgSrc = asset('image/biodiversitas/' . $item->gambar);
                    }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $item->nama_trans }}" class="main-img" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                <div class="deskripsi">{!! $item->deskripsi_trans !!}</div>
            </div>
            <div class="col-lg-4">
                <div class="info-box">
                    <div class="label">{{ __('app.biodiversity.category') }}</div>
                    <div class="value">
                        <span class="badge-status badge-{{ $item->kategori }}">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </div>

                    <div class="label">{{ __('app.biodiversity.location') }}</div>
                    <div class="value">{{ $item->lokasi ?? 'Danau Toba' }}</div>

                    @if($item->status_keberadaan)
                    <div class="label">{{ __('app.biodiversity.existence_status') }}</div>
                    <div class="value">{{ $item->status_keberadaan }}</div>
                    @endif

                    <div class="label">{{ __('app.common.status') }}</div>
                    <div class="value">
                        <span style="display:inline-block; padding:2px 12px; border-radius:20px; background:#dcfce7; color:#166534; font-weight:600; font-size:0.75rem;">
                            {{ $item->status ? __('app.common.active') : __('app.common.inactive') }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('biodiversitas') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> {{ __('app.common.back') }}
                </a>
            </div>
        </div>

        @if(isset($rekomendasi) && $rekomendasi->count() > 0)
        <div style="margin-top:50px;">
            <h3 style="font-family:'Playfair Display', serif; color:#003366;">{{ __('app.biodiversity.other_recommendations') }}</h3>
            <div class="rekomendasi-grid">
                @foreach($rekomendasi as $rec)
                <div class="rekomendasi-item" onclick="window.location.href='{{ route('biodiversitas.detail', $rec->slug) }}'">
                    @php
                        $recImg = $rec->gambar ? asset($rec->gambar) : asset('image/default.jpg');
                        if (!empty($rec->gambar) && file_exists(public_path($rec->gambar))) {
                            $recImg = asset($rec->gambar);
                        }
                    @endphp
                    <img src="{{ $recImg }}" alt="{{ $rec->nama_trans }}" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                    <div class="caption">
                        <h4>{{ Str::limit($rec->nama_trans, 25) }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
