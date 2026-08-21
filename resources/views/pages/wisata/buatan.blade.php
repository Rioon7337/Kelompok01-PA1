{{-- Halaman Destinasi Buatan — konten dirender langsung oleh PublicDestinationController::buatan() --}}
@extends('layouts.app')

@section('title', $categoryLabel . ' - Geosite Danau Toba')

@section('content')

<style>
    :root {
        --primary:#003366;--primary-light:#1a4a7a;--primary-dark:#001f3f;
        --gold:#c6a43b;--gold-light:#f1d26b;--gold-dark:#967a28;
        --text-gray:#334155;--text-light:#64748b;--white:#ffffff;
        --bg-light:#f8fafc;--shadow-xl:0 25px 50px -12px rgba(15,23,42,0.15);
    }
    body{font-family:'Inter',sans-serif;background:var(--bg-light);}
    .hero-dest{background:linear-gradient(135deg,var(--primary-dark) 0%,var(--primary-light) 100%);padding:120px 0 80px;margin-top:0;text-align:center;position:relative;overflow:hidden;}
    .hero-dest::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle,rgba(255,255,255,0.03) 0%,transparent 60%);animation:slowRotate 40s linear infinite;}
    @keyframes slowRotate{from{transform:rotate(0deg);}to{transform:rotate(360deg);}}
    .hero-dest .container{position:relative;z-index:2;}
    .hero-badge{display:inline-block;background:rgba(198,164,59,0.12);border:1px solid rgba(198,164,59,0.3);color:var(--gold-light);padding:6px 20px;border-radius:50px;font-size:0.72rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:20px;}
    .hero-dest h1{font-size:2.8rem;font-weight:700;font-family:'Playfair Display',serif;color:white;margin-bottom:12px;}
    .hero-dest h1 span{color:var(--gold-light);}
    .hero-dest p{color:rgba(255,255,255,0.75);font-size:0.9rem;}
    .hero-divider{width:50px;height:3px;background:var(--gold);margin:18px auto;border-radius:4px;}
    .dest-section{padding:70px 0 90px;}
    .container{max-width:1240px;margin:0 auto;padding:0 24px;}
    .dest-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,380px));gap:35px;justify-content:center;}
    .dest-card{background:var(--white);border-radius:20px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);transition:all 0.4s cubic-bezier(0.16,1,0.3,1);display:flex;flex-direction:column;border:1px solid rgba(15,23,42,0.04);text-decoration:none;color:inherit;}
    .dest-card:hover{transform:translateY(-8px);box-shadow:var(--shadow-xl);border-color:rgba(198,164,59,0.15);}
    .card-img-wrapper{position:relative;height:220px;overflow:hidden;}
    .card-img-wrapper img{width:100%;height:100%;object-fit:cover;transition:transform 0.8s cubic-bezier(0.16,1,0.3,1);}
    .dest-card:hover .card-img-wrapper img{transform:scale(1.06);}
    .card-img-overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,31,63,0.35);opacity:0;display:flex;align-items:center;justify-content:center;transition:all 0.3s ease;backdrop-filter:blur(2px);}
    .card-img-overlay i{color:white;font-size:1.3rem;background:var(--gold);padding:14px;border-radius:50%;transform:scale(0.8);transition:transform 0.4s cubic-bezier(0.175,0.885,0.32,1.275);}
    .dest-card:hover .card-img-overlay{opacity:1;}
    .dest-card:hover .card-img-overlay i{transform:scale(1);}
    .card-badge{position:absolute;top:15px;left:15px;background:white;color:var(--primary-dark);padding:5px 14px;border-radius:30px;font-size:0.68rem;font-weight:700;z-index:2;box-shadow:0 2px 8px rgba(0,0,0,0.08);}
    .card-content{padding:24px;flex:1;display:flex;flex-direction:column;}
    .card-title{font-size:1.15rem;font-weight:700;color:var(--primary-dark);font-family:'Playfair Display',serif;margin-bottom:10px;line-height:1.45;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
    .card-excerpt{font-size:0.87rem;color:var(--text-gray);line-height:1.65;margin-bottom:18px;display:-webkit-box;-webkit-line-clamp:3;line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
    .card-footer{display:flex;justify-content:flex-end;align-items:center;margin-top:auto;padding-top:16px;border-top:1px solid #f1f5f9;}
    .read-more{font-size:0.8rem;font-weight:700;color:var(--gold-dark);text-decoration:none;display:flex;align-items:center;gap:6px;transition:all 0.3s ease;}
    .read-more:hover{gap:10px;color:var(--primary);}
    .empty-state{grid-column:1/-1;text-align:center;padding:80px 20px;}
    .empty-state i{font-size:3rem;color:var(--gold);opacity:0.25;display:block;margin-bottom:16px;}
    .empty-state p{color:var(--text-light);}
    .pagination-wrapper{display:flex;justify-content:center;margin-top:50px;}
    @media(max-width:768px){.hero-dest{padding:110px 0 60px;}.hero-dest h1{font-size:1.8rem;}.dest-section{padding:50px 0 70px;}}
    @media(max-width:576px){.hero-dest h1{font-size:1.5rem;}.card-content{padding:18px;}}
</style>

<div class="hero-dest">
    <div class="container">
        <div class="hero-badge">Wisata Geosite</div>
        <h1><span>{{ $categoryLabel }}</span></h1>
        <div class="hero-divider"></div>
        <p>{{ $subtitle }}</p>
    </div>
</div>

<section class="dest-section">
    <div class="container">
        <div class="dest-grid">
            @forelse($destinations as $item)
            <a href="{{ route('destinasi.detail', [$category, $item->id]) }}" class="dest-card">
                <div class="card-img-wrapper">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title_trans }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                    <div class="card-img-overlay"><i class="fas fa-arrow-right"></i></div>
                    <span class="card-badge">{{ $categoryLabel }}</span>
                </div>
                <div class="card-content">
                    <div class="card-title">{{ $item->title_trans }}</div>
                    <div class="card-excerpt">{{ strip_tags($item->description_trans) }}</div>
                    <div class="card-footer">
                        <span class="read-more">Lihat Detail <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-building"></i>
                <p>Belum ada data {{ $categoryLabel }} yang tersedia.</p>
                <p style="font-size:0.8rem;margin-top:8px;">Silahkan tambahkan melalui panel admin.</p>
            </div>
            @endforelse
        </div>
        @if($destinations->hasPages())
        <div class="pagination-wrapper">{{ $destinations->links() }}</div>
        @endif
    </div>
</section>

@endsection


