@extends('layouts.app')

@section('title', 'Berita Terkini - Geosite Danau Toba')

@section('content')

<style>
    /* ==================== FONTS & VARIABLES ==================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap');
    
    :root {
        --primary: #003366;
        --primary-light: #1a4a7a;
        --primary-dark: #001f3f;
        --gold: #c6a43b;
        --gold-light: #f1d26b;
        --gold-dark: #967a28;
        --text-dark: #0f172a;
        --text-gray: #334155;
        --text-light: #64748b;
        --white: #ffffff;
        --bg-light: #f8fafc;
        --bg-gray: #f1f5f9;
        
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 10px 30px rgba(0,0,0,0.06);
        --shadow-xl: 0 25px 50px -12px rgba(15, 23, 42, 0.15);
        
        --radius-lg: 20px;
        --radius-md: 14px;
        --radius-sm: 8px;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
        background-color: var(--bg-light);
        -webkit-font-smoothing: antialiased;
    }
    
    /* ==================== HERO SECTION ==================== */
    .hero-pengumuman {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        padding: 120px 0 80px;
        margin-top: 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-pengumuman::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 60%);
        animation: slowRotate 40s linear infinite;
    }
    
    @keyframes slowRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .hero-pengumuman .container {
        position: relative;
        z-index: 2;
    }
    
    .hero-badge {
        display: inline-block;
        background: rgba(198, 164, 59, 0.12);
        border: 1px solid rgba(198, 164, 59, 0.3);
        color: var(--gold-light);
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    
    .hero-pengumuman h1 {
        font-size: 3rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: var(--white);
        margin-bottom: 14px;
        letter-spacing: -0.5px;
    }
    
    .hero-pengumuman p {
        font-size: 0.92rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.75);
    }
    
    .hero-divider {
        width: 50px;
        height: 3px;
        background: var(--gold);
        margin: 24px auto 0;
        border-radius: 4px;
    }
    
    /* ==================== BERITA SECTION ==================== */
    .pengumuman-section {
        padding: 80px 0;
        background: var(--bg-light);
    }
    
    .container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
    }
    
    .pengumuman-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 380px));
        gap: 35px;
        justify-content: center;
    }
    
    .pengumuman-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(15, 23, 42, 0.04);
    }
    
    .pengumuman-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(198, 164, 59, 0.15);
    }
    
    .card-image-wrapper {
        position: relative;
        height: 230px;
        overflow: hidden;
        cursor: pointer;
    }
    
    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .pengumuman-card:hover .card-image-wrapper img {
        transform: scale(1.06);
    }
    
    .card-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 31, 63, 0.35);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 1;
        backdrop-filter: blur(2px);
    }
    
    .card-image-overlay i {
        color: var(--white);
        font-size: 1.3rem;
        background: var(--gold);
        padding: 14px;
        border-radius: 50%;
        box-shadow: 0 6px 15px rgba(198, 164, 59, 0.3);
        transform: scale(0.8);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .card-image-wrapper:hover .card-image-overlay {
        opacity: 1;
    }
    
    .card-image-wrapper:hover .card-image-overlay i {
        transform: scale(1);
    }
    
    .card-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--white);
        color: var(--primary-dark);
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        z-index: 2;
        box-shadow: var(--shadow-sm);
    }
    
    .card-date {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(8px);
        color: white;
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 0.68rem;
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
    }
    
    .card-content {
        padding: 26px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        font-family: 'Playfair Display', serif;
        margin-bottom: 12px;
        line-height: 1.4;
        cursor: pointer;
        transition: color 0.2s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-title:hover {
        color: var(--gold-dark);
    }
    
    .card-excerpt {
        font-size: 0.88rem;
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid var(--bg-gray);
    }
    
    .card-views {
        font-size: 0.75rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .read-more {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--gold-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }
    
    .read-more:hover {
        gap: 10px;
        color: var(--primary);
    }
    
    /* ==================== PREMIUM OVERLAY READER MODAL ==================== */
    .reader-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--white);
        z-index: 1050;
        overflow-y: auto;
        visibility: hidden;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .reader-modal.active {
        visibility: visible;
        opacity: 1;
    }
    
    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(0,0,0,0.01);
        z-index: 1060;
    }
    
    .progress-bar {
        height: 4px;
        background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%);
        width: 0%;
        transition: width 0.1s ease;
    }
    
    .reader-nav {
        position: sticky;
        top: 0;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 14px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(15, 23, 42, 0.05);
        z-index: 99;
    }
    
    .reader-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--primary-dark);
    }
    
    .reader-logo span {
        color: var(--gold);
    }
    
    .btn-close {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--bg-gray);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-dark);
        font-size: 0.85rem;
    }
    
    .btn-close:hover {
        background: var(--primary-dark);
        color: var(--white);
        transform: rotate(90deg);
    }
    
    .reader-content {
        max-width: 740px;
        margin: 0 auto;
        padding: 50px 24px 80px;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.05s;
    }
    
    .reader-modal.active .reader-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .reader-header {
        text-align: center;
        margin-bottom: 35px;
    }
    
    .reader-category {
        display: inline-block;
        background: rgba(198, 164, 59, 0.08);
        color: var(--gold-dark);
        padding: 5px 16px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    
    .reader-title {
        font-size: 2.2rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: var(--primary-dark);
        margin-bottom: 20px;
        line-height: 1.3;
        letter-spacing: -0.3px;
    }
    
    .reader-meta {
        display: flex;
        justify-content: center;
        gap: 24px;
        font-size: 0.82rem;
        color: var(--text-light);
        flex-wrap: wrap;
        border-bottom: 1px solid var(--bg-gray);
        padding-bottom: 24px;
    }
    
    .reader-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .reader-image-container {
        width: 100%;
        border-radius: var(--radius-md);
        overflow: hidden;
        margin: 35px 0;
        box-shadow: var(--shadow-sm);
    }
    
    .reader-image {
        width: 100%;
        max-height: 440px;
        object-fit: cover;
        display: block;
    }
    
    .reader-body {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        line-height: 1.75;
        color: var(--text-gray);
    }
    
    .reader-body p {
        margin-bottom: 1.4rem;
        font-weight: 400;
        text-align: justify;
    }
    
    .reader-body h1, .reader-body h2, .reader-body h3, .reader-body h4 {
        color: var(--primary-dark);
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        line-height: 1.35;
        margin: 1.8rem 0 0.8rem;
    }
    
    .reader-body h1 { font-size: 1.75rem; }
    .reader-body h2 { font-size: 1.5rem; border-left: 3px solid var(--gold); padding-left: 12px; }
    .reader-body h3 { font-size: 1.25rem; }
    
    .reader-body img {
        max-width: 100%;
        height: auto !important;
        border-radius: var(--radius-sm);
        margin: 20px auto;
        display: block;
    }
    
    .reader-body ul, .reader-body ol {
        margin-bottom: 1.4rem;
        padding-left: 20px;
    }
    
    .reader-body li {
        margin-bottom: 0.5rem;
    }
    
    .reader-body table {
        width: 100% !important;
        margin: 24px 0;
        border-collapse: collapse;
        font-size: 0.88rem;
        overflow-x: auto;
        display: block;
    }
    
    .reader-body th, .reader-body td {
        padding: 10px 14px;
        border: 1px solid var(--bg-gray);
    }
    
    .reader-body th {
        background-color: var(--bg-light);
        color: var(--primary-dark);
    }
    
    .reader-body blockquote {
        border-left: 3px solid var(--gold);
        padding: 16px 24px;
        margin: 30px 0;
        background: var(--bg-light);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        font-style: italic;
        color: var(--primary-light);
        font-size: 1.08rem;
        font-family: 'Playfair Display', serif;
    }
    
    .reader-body strong {
        color: var(--primary-dark);
        font-weight: 600;
    }
    
    .reader-footer {
        margin-top: 50px;
        padding-top: 35px;
        border-top: 1px solid var(--bg-gray);
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .btn-back-reader {
        background: var(--primary-dark);
        color: var(--white);
        padding: 12px 30px;
        border-radius: 50px;
        border: none;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-back-reader:hover {
        background: var(--gold-dark);
        transform: translateY(-2px);
    }
    
    .btn-share-reader {
        background: transparent;
        color: var(--primary-dark);
        padding: 12px 30px;
        border-radius: 50px;
        border: 1px solid rgba(0, 31, 63, 0.15);
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-share-reader:hover {
        background: var(--bg-light);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 24px;
        background: var(--white);
        border-radius: var(--radius-lg);
        grid-column: span 3;
        box-shadow: var(--shadow-sm);
    }
    
    .empty-state i {
        font-size: 4rem;
        color: var(--gold);
        opacity: 0.25;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 1.35rem;
        color: var(--primary-dark);
        margin-bottom: 8px;
        font-family: 'Playfair Display', serif;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 50px;
    }
    
    @media (max-width: 1024px) {
        .pengumuman-grid { grid-template-columns: repeat(2, 1fr); gap: 25px; }
        .hero-pengumuman h1 { font-size: 2.6rem; }
    }
    
    @media (max-width: 768px) {
        .hero-pengumuman h1 { font-size: 2rem; }
        .pengumuman-grid { grid-template-columns: 1fr; }
        .reader-title { font-size: 1.8rem; }
        .reader-nav { padding: 14px 20px; }
        .reader-content { padding: 35px 16px 50px; }
    }
</style>

<!-- ==================== HERO SECTION ==================== -->
<section class="hero-pengumuman">
    <div class="container">
        <div class="hero-badge">{{ __('app.news.badge') }}</div>
        <h1>{{ __('app.news.title') }}</h1>
        <p>{{ __('app.news.hero_desc') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- ==================== BERITA SECTION ==================== -->
<section class="pengumuman-section">
    <div class="container">
        <div class="pengumuman-grid">
            @forelse($pengumuman as $item)
            <div class="pengumuman-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                @php
                    $imgSrc = asset('image/default.jpg');
                    if (!empty($item->gambar)) {
                        if (str_starts_with($item->gambar, 'data:image')) {
                            $imgSrc = $item->gambar;
                        } elseif (filter_var($item->gambar, FILTER_VALIDATE_URL)) {
                            $imgSrc = $item->gambar;
                        } elseif (str_starts_with($item->gambar, 'image/pengumuman/')) {
                            $imgSrc = asset($item->gambar);
                        } elseif (file_exists(public_path('image/pengumuman/' . $item->gambar))) {
                            $imgSrc = asset('image/pengumuman/' . $item->gambar);
                        } else {
                            $imgSrc = asset($item->gambar);
                        }
                    }
                @endphp
                
                <div class="card-image-wrapper" onclick="openPengumuman({{ $item->id }})">
                    <img src="{{ $imgSrc }}" alt="{{ $item->judul_trans }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                    <div class="card-image-overlay">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span class="card-category">{{ __('app.news.category') }}</span>
                    <span class="card-date">
                        <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                    </span>
                </div>
                
                <div class="card-content">
                    <h3 class="card-title" onclick="openPengumuman({{ $item->id }})">{{ $item->judul_trans }}</h3>
                    <p class="card-excerpt">{{ Str::limit(strip_tags($item->konten_trans), 110) }}</p>
                    <div class="card-footer">
                        <span class="card-views" id="views-{{ $item->id }}">
                            <i class="far fa-eye"></i> {{ number_format($item->views ?? 0) }} {{ __('app.common.views_count') }}
                        </span>
                        <a href="javascript:void(0)" class="read-more" onclick="openPengumuman({{ $item->id }})">
                            {{ __('app.common.read_more') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="far fa-newspaper"></i>
                <h3>{{ __('app.news.no_data') }}</h3>
                <p>{{ __('app.news.no_data_desc') }}</p>
            </div>
            @endforelse
        </div>
        
        @if(method_exists($pengumuman, 'links'))
        <div class="pagination">
            {{ $pengumuman->links() }}
        </div>
        @endif
    </div>
</section>

<!-- ==================== MODAL READER PREMIUM ==================== -->
<div id="readerModal" class="reader-modal">
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>
    
    <div class="reader-nav">
        <div class="reader-logo">Geo<span>Toba</span></div>
        <button class="btn-close" onclick="closePengumuman()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="reader-content">
        <div class="reader-header">
            <span class="reader-category" id="modalCategory">{{ __('app.news.category') }}</span>
            <h1 class="reader-title" id="modalTitle"></h1>
            <div class="reader-meta" id="modalMeta"></div>
        </div>
        
        <div class="reader-image-container">
            <img id="modalImage" class="reader-image" src="" alt="">
        </div>
        
        <div class="reader-body" id="modalContent"></div>
        
        <div class="reader-footer">
            <button class="btn-back-reader" onclick="closePengumuman()">
                <i class="fas fa-arrow-left"></i> {{ __('app.common.back') }}
            </button>
            <button class="btn-share-reader" onclick="bagikanPengumuman()">
                <i class="fas fa-share-alt"></i> {{ __('app.common.share_article') }}
            </button>
        </div>
    </div>
</div>

<script>
    const pengumumanData = @json($pengumuman->items());
    
    async function openPengumuman(id) {
        const item = pengumumanData.find(x => x.id === id);
        if (!item) return;
        
        let imgSrc = '{{ asset("image/default.jpg") }}';
        if (item.gambar) {
            if (item.gambar.startsWith('data:image') || item.gambar.startsWith('http')) {
                imgSrc = item.gambar;
            } else if (item.gambar.startsWith('image/pengumuman/')) {
                imgSrc = '{{ asset("") }}' + item.gambar;
            } else if (item.gambar) {
                imgSrc = '{{ asset("image/pengumuman/") }}' + item.gambar;
            } else {
                imgSrc = '{{ asset("storage") }}/' + item.gambar;
            }
        }
        
        const tgl = new Date(item.created_at);
        const tanggalFormatted = tgl.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        
        document.getElementById('modalTitle').innerText = item.judul;
        document.getElementById('modalContent').innerHTML = item.konten;
        document.getElementById('modalImage').src = imgSrc;
        document.getElementById('modalMeta').innerHTML = `
            <span><i class="far fa-calendar"></i> ${tanggalFormatted}</span>
            <span><i class="far fa-user"></i> ${item.penulis || 'Admin GeoToba'}</span>
            <span><i class="far fa-eye"></i> <span id="modalViews">${(item.views || 0).toLocaleString()}</span> ${@json(__('app.common.views_count'))}</span>
        `;
        
        const modal = document.getElementById('readerModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        modal.scrollTop = 0;
        document.getElementById('progressBar').style.width = '0%';
        
        try {
            const response = await fetch('/api/pengumuman/' + id + '/view', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            
            if (data.success) {
                const viewsSpan = document.getElementById('views-' + id);
                if (viewsSpan) {
                    viewsSpan.innerHTML = `<i class="far fa-eye"></i> ${data.views.toLocaleString()} ${@json(__('app.common.views_count'))}`;
                }
                const modalViews = document.getElementById('modalViews');
                if (modalViews) {
                    modalViews.innerText = data.views.toLocaleString();
                }
            }
        } catch (err) {
            console.error('Gagal memperbarui data views:', err);
        }
    }
    
    function closePengumuman() {
        const modal = document.getElementById('readerModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    function bagikanPengumuman() {
        const title = document.getElementById('modalTitle').innerText;
        const url = window.location.href;
        
        if (navigator.share) {
            navigator.share({
                title: title,
                text: 'Baca berita menarik seputar GeoToba terbaru ini:',
                url: url
            }).catch(err => console.log('Share dibatalkan'));
        } else {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan berita berhasil disalin ke clipboard!');
            }).catch(() => {
                alert('Salin tautan berikut: ' + url);
            });
        }
    }
    
    const modalElement = document.getElementById('readerModal');
    if (modalElement) {
        modalElement.addEventListener('scroll', function() {
            const scrollTop = modalElement.scrollTop;
            const scrollHeight = modalElement.scrollHeight - modalElement.clientHeight;
            const scrolled = (scrollTop / scrollHeight) * 100;
            const progressBar = document.getElementById('progressBar');
            if (progressBar && scrollHeight > 0) {
                progressBar.style.width = scrolled + '%';
            }
        });
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('readerModal');
            if (modal && modal.classList.contains('active')) {
                closePengumuman();
            }
        }
    });
</script>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 60,
        easing: 'ease-out-quad'
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@endsection
