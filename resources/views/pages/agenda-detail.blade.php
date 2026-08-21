@extends('layouts.app')

@section('title', $agenda->judul_trans . ' - Agenda Geosite')

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
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.3;
    }
    .detail-hero .meta {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.8);
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .detail-hero .meta i { color: #c6a43b; margin-right: 5px; }
    .detail-hero .back-link {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .detail-hero .back-link:hover {
        color: white;
        transform: translateX(-5px);
    }

    .detail-content { padding: 60px 0; background: #f8fafc; }
    .detail-content .main-img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .detail-content .konten {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #334155;
        text-align: justify;
    }
    .detail-content .konten p { margin-bottom: 20px; }
    
    .sidebar .recent-news {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }
    .sidebar .recent-news h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #003366;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f5f9;
    }
    .sidebar .news-item {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }
    .sidebar .news-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .sidebar .news-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .sidebar .news-item .info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    .sidebar .news-item .info h4 a {
        color: #1e293b;
        text-decoration: none;
        transition: color 0.3s;
    }
    .sidebar .news-item .info h4 a:hover { color: #c6a43b; }
    .sidebar .news-item .info span {
        font-size: 0.75rem;
        color: #64748b;
    }
</style>

<!-- HERO -->
<section class="detail-hero">
    <div class="container">
        <a href="{{ route('agenda.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> {{ __('app.news.back') ?? 'Kembali ke Agenda' }}
        </a>
        <h1>{{ $agenda->judul_trans }}</h1>
        <div class="meta">
            <span><i class="fas fa-user"></i> {{ $agenda->penulis ?? 'Admin' }}</span>
            <span><i class="fas fa-calendar-alt"></i> {{ $agenda->created_at->format('d M Y') }}</span>
            <span><i class="fas fa-eye"></i> {{ number_format($agenda->views) }} Kali Dilihat</span>
        </div>
    </div>
</section>

<!-- CONTENT -->
<section class="detail-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @php
                    $imgSrc = asset('image/default.jpg');
                    if (!empty($agenda->gambar)) {
                        if (str_starts_with($agenda->gambar, 'http')) {
                            $imgSrc = $agenda->gambar;
                        } elseif (str_starts_with($agenda->gambar, 'image/')) {
                            $imgSrc = asset($agenda->gambar);
                        } else {
                            $imgSrc = asset($agenda->gambar);
                        }
                    }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $agenda->judul_trans }}" class="main-img" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                
                <div class="konten">
                    {!! $agenda->konten_trans !!}
                </div>
                
                <div class="mt-5">
                    <!-- Share buttons can be added here -->
                </div>
            </div>
            <div class="col-lg-4 mt-5 mt-lg-0 sidebar">
                <div class="recent-news">
                    <h3>Agenda Lainnya</h3>
                    @php
                        $recentAgenda = \App\Models\Agenda::where('status', true)->where('id', '!=', $agenda->id)->latest()->take(5)->get();
                    @endphp
                    @forelse($recentAgenda as $item)
                        <div class="news-item">
                            @php
                                $thumbSrc = asset('image/default.jpg');
                                if (!empty($item->gambar)) {
                                    if (str_starts_with($item->gambar, 'http')) {
                                        $thumbSrc = $item->gambar;
                                    } elseif (str_starts_with($item->gambar, 'image/')) {
                                        $thumbSrc = asset($item->gambar);
                                    } else {
                                        $thumbSrc = asset($item->gambar);
                                    }
                                }
                            @endphp
                            <img src="{{ $thumbSrc }}" alt="{{ $item->judul_trans }}" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                            <div class="info">
                                <h4><a href="{{ route('agenda.detail', $item->id) }}">{{ Str::limit($item->judul_trans, 40) }}</a></h4>
                                <span><i class="far fa-clock"></i> {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada berita lainnya.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

