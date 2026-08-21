@extends('layouts.app')

@section('title', 'Galeri - GeoToba')

@section('content')

<style>
    .gallery-hero {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 80px 0 50px;
        margin-top: 70px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .gallery-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: slowRotate 20s linear infinite;
    }
    @keyframes slowRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .gallery-hero-content { position: relative; z-index: 2; }
    .gallery-hero h1 {
        font-size: 2.8rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: white;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }
    .gallery-hero p {
        font-size: 0.85rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.8);
    }
    
    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    .filter-btn {
        background: transparent;
        border: 2px solid #c6a43b;
        padding: 8px 24px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #003366;
    }
    .filter-btn.active, .filter-btn:hover {
        background: #c6a43b;
        color: #003366;
    }
    
    .gallery-section {
        padding: 60px 0 100px;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2f8 100%);
        min-height: 100vh;
    }
    .container { max-width: 1400px; margin: 0 auto; padding: 0 24px; }
    .stack-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 25px;
        padding: 20px 0;
    }
    .slip-card {
        position: relative;
        width: 280px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
    }
    .slip-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 40px -10px rgba(0,0,0,0.25);
    }
    .slip-image {
        position: relative;
        width: 100%;
        height: 260px;
        overflow: hidden;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }
    .slip-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .slip-card:hover .slip-image img { transform: scale(1.05); }
    .slip-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        padding: 30px 16px 16px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .slip-card:hover .slip-overlay { opacity: 1; }
    .slip-category {
        display: inline-block;
        background: #c6a43b;
        color: #003366;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .slip-info {
        padding: 16px;
        background: white;
    }
    .slip-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .slip-location {
        font-size: 0.7rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .slip-location i { font-size: 0.65rem; color: #54c63b; }
    
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.96);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(12px);
    }
    .modal-box {
        background: #1a1a1a;
        width: 90%;
        max-width: 1000px;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        border-radius: 20px;
        overflow: hidden;
        animation: modalFadeIn 0.4s ease;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
    .modal-img-part {
        background: #0a0a0a;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .modal-img-part img { width: 100%; max-height: 70vh; object-fit: contain; }
    .modal-text-part {
        padding: 35px;
        color: white;
        text-align: left;
        background: linear-gradient(135deg, #1a1a1a, #0d0d0d);
    }
    .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        z-index: 10000;
        width: 40px;
        height: 40px;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .close-btn:hover {
        background: #c6a43b;
        color: #003366;
        transform: rotate(90deg);
    }
    .modal-text-part small {
        color: #c6a43b;
        letter-spacing: 2px;
        font-size: 0.7rem;
        text-transform: uppercase;
    }
    .modal-text-part h2 {
        font-size: 1.5rem;
        margin: 12px 0;
        font-family: 'Playfair Display', serif;
    }
    .modal-text-part p { color: #bbb; line-height: 1.7; font-size: 0.85rem; }
    
    .modal-music-player {
        margin-top: 25px;
        padding: 12px 16px;
        background: rgba(0,0,0,0.5);
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(198,164,59,0.4);
    }
    .modal-music-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c6a43b, #e8c45a);
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .modal-music-avatar i { color: #003366; font-size: 1.1rem; }
    .modal-music-info { flex: 1; }
    .modal-music-title { font-size: 0.8rem; font-weight: 700; color: white; }
    .modal-music-artist { font-size: 0.65rem; color: #c6a43b; }
    .modal-music-controls button {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        transition: all 0.2s;
    }
    .modal-music-controls button:hover {
        background: #c6a43b;
        color: #003366;
        transform: scale(1.1);
    }
    
    .empty-gallery { text-align: center; padding: 80px; background: white; border-radius: 16px; }
    .empty-gallery i { font-size: 3rem; color: #cbd5e1; margin-bottom: 15px; }

    @media (max-width: 768px) {
        .modal-box { grid-template-columns: 1fr; max-height: 85vh; overflow-y: auto; }
        .slip-card { width: calc(50% - 10px); }
    }
    @media (max-width: 560px) {
        .slip-card { width: 100%; }
    }
</style>

<div class="gallery-hero">
    <div class="gallery-hero-content">
        <h1>{{ __('app.gallery.title') }}</h1>
        <p>{{ __('app.gallery.subtitle') }}</p>
    </div>
</div>

<section class="gallery-section">
    <div class="container">
        
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">{{ __('app.gallery.all') }}</button>
            <button class="filter-btn" data-filter="meat">MEAT</button>
            <button class="filter-btn" data-filter="batu-bahisan">BATU BASIHA</button>
            <button class="filter-btn" data-filter="liang-sipege">LIANG SIPEGE</button>
            <button class="filter-btn" data-filter="balige">BALIGE</button>
        </div>
        
        <div class="stack-container" id="galleryContainer">
            @forelse($galeri ?? [] as $index => $item)
                @php
                    // TENTUKAN GAMBAR BERDASARKAN KATEGORI JIKA KOSONG
                    $imgSrc = asset('image/default.jpg');
                    $kategoriLower = strtolower($item->kategori ?? '');
                    
                    if (!empty($item->gambar)) {
                        if (str_starts_with($item->gambar, 'http')) {
                            $imgSrc = $item->gambar;
                        } elseif (str_starts_with($item->gambar, '/storage/')) {
                            $imgSrc = asset($item->gambar);
                        } elseif (str_starts_with($item->gambar, 'image/')) {
                            $imgSrc = asset($item->gambar);
                        } else {
                            $imgSrc = asset($item->gambar);
                        }
                    } else {
                        // GAMBAR DEFAULT BERDASARKAN KATEGORI
                        if (str_contains($kategoriLower, 'meat')) {
                            $imgSrc = asset('image/meat/slide1.jpg');
                        } else if (str_contains($kategoriLower, 'batu') || str_contains($kategoriLower, 'bahisan')) {
                            $imgSrc = asset('image/meat/batu-detail.jpg');
                        } else if (str_contains($kategoriLower, 'liang') || str_contains($kategoriLower, 'sipege')) {
                            $imgSrc = asset('image/meat/liang-detail.jpg');
                        } else if (str_contains($kategoriLower, 'balige')) {
                            $imgSrc = asset('image/default.jpg');
                        }
                    }
                    
                    // TENTUKAN FILTER CATEGORY
                    $filterCat = 'other';
                    if (str_contains($kategoriLower, 'meat')) {
                        $filterCat = 'meat';
                    } else if (str_contains($kategoriLower, 'batu') || str_contains($kategoriLower, 'bahisan')) {
                        $filterCat = 'batu-bahisan';
                    } else if (str_contains($kategoriLower, 'liang') || str_contains($kategoriLower, 'sipege')) {
                        $filterCat = 'liang-sipege';
                    } else if (str_contains($kategoriLower, 'balige')) {
                        $filterCat = 'balige';
                    }
                    
                    $judul = addslashes($item->judul_trans ?? (app()->getLocale() == 'en' ? 'Gallery' : 'Galeri'));
                    $deskripsi = addslashes($item->deskripsi_trans ?? (app()->getLocale() == 'en' ? 'No description' : 'Tidak ada deskripsi'));
                    $kategoriModal = addslashes(strtoupper($item->kategori ?? (app()->getLocale() == 'en' ? 'GALLERY' : 'GALERI')));
                    $lokasi = addslashes($item->lokasi ?? 'Danau Toba');
                @endphp
                
                <div class="slip-card" data-category="{{ $filterCat }}"
                     onclick="openPhoto('{{ $imgSrc }}', '{{ $judul }}', '{{ $deskripsi }}', '{{ $kategoriModal }}', '{{ $lokasi }}')">
                    <div class="slip-image">
                        <img src="{{ $imgSrc }}" alt="{{ $item->judul_trans }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                        <div class="slip-overlay">
                            <span class="slip-category">{{ strtoupper($item->kategori ?? (app()->getLocale() == 'en' ? 'GALLERY' : 'GALERI')) }}</span>
                        </div>
                    </div>
                    <div class="slip-info">
                        <div class="slip-title">{{ Str::limit($item->judul_trans, 30) }}</div>
                        <div class="slip-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $item->lokasi ?? 'Danau Toba' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-gallery">
                    <i class="fas fa-images"></i>
                    <p>{{ __('app.gallery.no_data') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<div id="pModal" class="modal-overlay" onclick="closePhoto()">
    <div class="close-btn" onclick="closePhoto()">&times;</div>
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-img-part"><img src="" id="mImg"></div>
        <div class="modal-text-part">
            <small id="mTag"></small>
            <h2 id="mTitle"></h2>
            <p><i class="fas fa-map-marker-alt"></i> <span id="mLocation"></span></p>
            <p id="mDesc"></p>
            
            <div class="modal-music-player">
                <div class="modal-music-avatar">
                    <i class="fas fa-music"></i>
                </div>
                <div class="modal-music-info">
                    <div class="modal-music-title">🎵 Gondang Batak</div>
                    <div class="modal-music-artist">🎤 Musik Instrumental Batak</div>
                </div>
                <div class="modal-music-controls">
                    <button id="modalPlayPauseBtn" onclick="toggleModalMusic(event)">
                        <i class="fas fa-play"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const songUrl = "{{ asset('audio/GONDANG.weba') }}";
    let modalAudio = new Audio();
    let isModalPlaying = false;
    
    modalAudio.src = songUrl;
    modalAudio.loop = true;
    
    function toggleModalMusic(event) {
        if (event) event.stopPropagation();
        if (isModalPlaying) {
            modalAudio.pause();
            document.getElementById('modalPlayPauseBtn').innerHTML = '<i class="fas fa-play"></i>';
        } else {
            modalAudio.play().catch(e => console.log('Play error:', e));
            document.getElementById('modalPlayPauseBtn').innerHTML = '<i class="fas fa-pause"></i>';
        }
        isModalPlaying = !isModalPlaying;
    }
    
    function stopModalMusic() {
        if (modalAudio) {
            modalAudio.pause();
            modalAudio.currentTime = 0;
            isModalPlaying = false;
            const btn = document.getElementById('modalPlayPauseBtn');
            if (btn) btn.innerHTML = '<i class="fas fa-play"></i>';
        }
    }
    
    function startModalMusic() {
        if (!isModalPlaying && modalAudio.paused) {
            modalAudio.play().catch(e => console.log('Play error:', e));
            const btn = document.getElementById('modalPlayPauseBtn');
            if (btn) btn.innerHTML = '<i class="fas fa-pause"></i>';
            isModalPlaying = true;
        }
    }
    
    function openPhoto(src, title, desc, tag, location) {
        document.getElementById('mImg').src = src;
        document.getElementById('mTitle').innerText = title;
        document.getElementById('mTag').innerText = tag;
        document.getElementById('mDesc').innerHTML = desc || '{{ app()->getLocale() == "en" ? "No description." : "Tidak ada deskripsi." }}';
        document.getElementById('mLocation').innerHTML = location || 'Danau Toba';
        document.getElementById('pModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        startModalMusic();
    }
    
    function closePhoto() {
        document.getElementById('pModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        stopModalMusic();
    }
    
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filterValue = this.getAttribute('data-filter');
            const cards = document.querySelectorAll('.slip-card');
            cards.forEach(card => {
                if (filterValue === 'all') {
                    card.style.display = 'block';
                } else {
                    const cardCategory = card.getAttribute('data-category');
                    if (cardCategory === filterValue) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePhoto();
    });
    
    window.addEventListener('beforeunload', function() {
        if (modalAudio) modalAudio.pause();
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@endsection
