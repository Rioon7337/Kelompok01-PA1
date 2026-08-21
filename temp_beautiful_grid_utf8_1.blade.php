@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . ($query ?: 'Semua') . ' - Geosite Danau Toba')

@section('content')

<style>
    /* ==================== FONT & VARIABEL WARNA ==================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap');

    :root {
        --primary:       #003366;
        --primary-light: #1a4a7a;
        --primary-dark:  #001f3f;
        --gold:          #c6a43b;
        --gold-light:    #f1d26b;
        --gold-dark:     #967a28;
        --text-dark:     #0f172a;
        --text-gray:     #334155;
        --text-light:    #64748b;
        --white:         #ffffff;
        --bg-light:      #f8fafc;
        --bg-gray:       #f1f5f9;
        --shadow-sm:     0 2px 8px rgba(0,0,0,0.04);
        --shadow-md:     0 10px 30px rgba(0,0,0,0.06);
        --shadow-xl:     0 25px 50px -12px rgba(15, 23, 42, 0.15);
        --radius-lg:     20px;
        --radius-md:     14px;
    }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
        background-color: var(--bg-light);
        -webkit-font-smoothing: antialiased;
    }

    /* ==================== HERO HEADER HALAMAN ==================== */
    /* Desain hero mengikuti pola yang sama dengan halaman Berita & Biodiversitas */
    .hero-search {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        padding: 120px 0 80px;
        margin-top: 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Efek rotasi lingkaran halus di background hero */
    .hero-search::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 60%);
        animation: slowRotate 40s linear infinite;
    }

    @keyframes slowRotate {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    .hero-search .container { position: relative; z-index: 2; }

    /* Badge kecil di atas judul hero */
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

    .hero-search h1 {
        font-size: 2.5rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: var(--white);
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    /* Kata kunci ditampilkan dengan warna emas agar menonjol */
    .hero-search h1 .keyword {
        color: var(--gold-light);
        font-style: italic;
    }

    .hero-search p {
        font-size: 0.88rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.65);
    }

    .hero-divider {
        width: 50px; height: 3px;
        background: var(--gold);
        margin: 24px auto 0;
        border-radius: 4px;
    }

    /* ==================== FORM PENCARIAN DI DALAM HERO ==================== */
    /* Form pencarian ulang agar pengguna mudah memodifikasi kata kunci */
    .hero-search-form {
        margin-top: 32px;
        display: flex;
        justify-content: center;
    }

    .hero-search-form .search-box {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.12);
        border: 1.5px solid rgba(255,255,255,0.25);
        border-radius: 50px;
        padding: 8px 8px 8px 22px;
        width: 100%;
        max-width: 540px;
        transition: all 0.3s ease;
    }

    .hero-search-form .search-box:focus-within {
        background: rgba(255,255,255,0.2);
        border-color: var(--gold);
        box-shadow: 0 0 0 4px rgba(198,164,59,0.15);
    }

    .hero-search-form input {
        flex: 1;
        background: none;
        border: none;
        outline: none;
        color: var(--white);
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
    }

    .hero-search-form input::placeholder { color: rgba(255,255,255,0.55); }

    .hero-search-form button {
        background: var(--gold);
        color: var(--primary-dark);
        border: none;
        border-radius: 40px;
        padding: 10px 22px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .hero-search-form button:hover {
        background: var(--gold-light);
        transform: scale(1.04);
    }

    /* ==================== SECTION UTAMA HASIL PENCARIAN ==================== */
    .results-section {
        padding: 70px 0 90px;
        background: var(--bg-light);
    }

    .container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Informasi jumlah hasil ditemukan */
    .results-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--bg-gray);
    }

    .results-count {
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .results-count strong {
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Tombol filter berdasarkan tipe konten */
    .filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .filter-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 30px;
        border: 1.5px solid var(--bg-gray);
        background: var(--white);
        color: var(--text-gray);
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
    }

    .filter-tab:hover,
    .filter-tab.active {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    .filter-tab .count-badge {
        background: rgba(198,164,59,0.2);
        color: var(--gold-dark);
        border-radius: 20px;
        padding: 1px 8px;
        font-size: 0.7rem;
    }

    .filter-tab.active .count-badge {
        background: rgba(255,255,255,0.2);
        color: var(--white);
    }

    /* ==================== GRID KARTU HASIL ==================== */
    /* Menggunakan pola grid yang sama persis dengan halaman Berita & Biodiversitas */
    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 380px));
        gap: 35px;
        justify-content: center;
    }

    /* ==================== KARTU HASIL ==================== */
    /* Desain kartu IDENTIK dengan kartu di halaman Berita */
    .result-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(15, 23, 42, 0.04);
        text-decoration: none;
        color: inherit;
    }

    .result-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(198, 164, 59, 0.15);
    }

    /* Wrapper gambar dengan hover zoom */
    .card-image-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
        cursor: pointer;
    }

    .card-image-wrapper img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .result-card:hover .card-image-wrapper img {
        transform: scale(1.06);
    }

    /* Overlay gelap + ikon panah muncul saat hover */
    .card-image-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 31, 63, 0.35);
        opacity: 0;
        display: flex; align-items: center; justify-content: center;
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

    .result-card:hover .card-image-overlay { opacity: 1; }
    .result-card:hover .card-image-overlay i { transform: scale(1); }

    /* Placeholder ikon jika gambar tidak tersedia */
    .card-image-placeholder {
        height: 220px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,0.4);
        font-size: 3rem;
    }

    /* Badge tipe konten (Berita, UMKM, Penginapan, dst) */
    .card-type-badge {
        position: absolute;
        top: 15px; left: 15px;
        background: var(--white);
        color: var(--primary-dark);
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        z-index: 2;
        box-shadow: var(--shadow-sm);
        display: flex; align-items: center; gap: 5px;
    }

    /* Badge tanggal di pojok kanan bawah gambar (khusus Berita) */
    .card-date-badge {
        position: absolute;
        bottom: 15px; right: 15px;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(8px);
        color: white;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.68rem;
        display: flex; align-items: center; gap: 6px;
        z-index: 2;
    }

    /* Konten teks kartu */
    .card-content {
        padding: 26px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* Judul kartu menggunakan font Playfair Display */
    .card-title {
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--primary-dark);
        font-family: 'Playfair Display', serif;
        margin-bottom: 10px;
        line-height: 1.45;
        /* Batasi 2 baris agar rapi */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Deskripsi singkat kartu */
    .card-excerpt {
        font-size: 0.87rem;
        color: var(--text-gray);
        line-height: 1.65;
        margin-bottom: 16px;
        /* Batasi 3 baris */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Meta info bawah: lokasi, kontak, harga */
    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 16px;
    }

    .card-meta-item {
        font-size: 0.78rem;
        color: var(--text-light);
        display: flex; align-items: center; gap: 7px;
    }

    .card-meta-item i { color: var(--gold); width: 14px; flex-shrink: 0; }

    /* Footer kartu dengan tombol "Lihat Detail" */
    .card-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid var(--bg-gray);
    }

    .read-more {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--gold-dark);
        text-decoration: none;
        display: flex; align-items: center; gap: 6px;
        transition: all 0.3s ease;
    }

    .read-more:hover { gap: 10px; color: var(--primary); }

    /* ==================== STATE KOSONG (TIDAK ADA HASIL) ==================== */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        grid-column: 1 / -1; /* Rentangkan ke seluruh lebar grid */
    }

    .empty-state-icon {
        width: 90px; height: 90px;
        background: linear-gradient(135deg, rgba(198,164,59,0.1), rgba(198,164,59,0.05));
        border: 2px solid rgba(198,164,59,0.15);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 24px;
        font-size: 2.2rem;
        color: var(--gold);
        opacity: 0.6;
    }

    .empty-state h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--text-light);
        font-size: 0.95rem;
        max-width: 420px;
        margin: 0 auto 28px;
        line-height: 1.7;
    }

    /* Tombol kembali ke beranda di state kosong */
    .btn-home {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--primary);
        color: var(--white);
        padding: 13px 30px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.88rem;
        transition: all 0.3s ease;
    }

    .btn-home:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        color: var(--white);
    }

    /* ==================== RESPONSIF ==================== */
    @media (max-width: 992px) {
        .hero-search h1 { font-size: 2rem; }
        .results-meta { flex-direction: column; align-items: flex-start; }
    }

    @media (max-width: 768px) {
        .results-grid { gap: 24px; }
        .hero-search { padding: 110px 0 60px; }
    }

    @media (max-width: 576px) {
        .hero-search h1 { font-size: 1.6rem; }
        .hero-search-form .search-box { flex-direction: column; border-radius: 16px; padding: 12px; gap: 10px; }
        .hero-search-form button { width: 100%; text-align: center; border-radius: 10px; }
        .results-section { padding: 50px 0 70px; }
        .card-content { padding: 20px; }
    }
</style>

{{-- ==================== HERO HEADER ==================== --}}
<div class="hero-search">
    <div class="container">
        {{-- Badge kecil di atas judul --}}
        <div class="hero-badge">Hasil Pencarian</div>

        {{-- Judul utama menampilkan kata kunci --}}
        <h1>
            @if($query)
                Menampilkan hasil untuk: <span class="keyword">"{{ $query }}"</span>
            @else
                Cari Sesuatu
            @endif
        </h1>

        {{-- Informasi jumlah hasil --}}
        <p>
            @if($query)
                {{ $results->count() }} hasil ditemukan di seluruh konten
            @else
                Masukkan kata kunci untuk mulai mencari
            @endif
        </p>

        <div class="hero-divider"></div>

        {{-- Form pencarian ulang agar pengguna bisa langsung memodifikasi kata kunci --}}
        <div class="hero-search-form">
            <form action="{{ route('search.results') }}" method="GET">
                <div class="search-box">
                    <input
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        placeholder="Cari destinasi, berita, UMKM..."
                        autocomplete="off"
                        autofocus
                    >
                    <button type="submit">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ==================== SECTION HASIL PENCARIAN ==================== --}}
<section class="results-section">
    <div class="container">

        @if($query && $results->count() > 0)

        {{-- ΓöÇΓöÇ META: Jumlah hasil + Filter tab per tipe ΓöÇΓöÇ --}}
        <div class="results-meta">
            <div class="results-count">
                Ditemukan <strong>{{ $results->count() }}</strong> hasil
                untuk kata kunci <strong>"{{ $query }}"</strong>
            </div>

            {{-- Hitung jumlah per tipe untuk menampilkan filter tab --}}
            @php
                $groupedTypes = $results->groupBy('type');
            @endphp

            <div class="filter-tabs">
                {{-- Tab "Semua" selalu muncul pertama --}}
                <a href="{{ route('search.results', ['q' => $query]) }}"
                   class="filter-tab {{ !request('type') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Semua
                    <span class="count-badge">{{ $results->count() }}</span>
                </a>
                {{-- Tab per tipe konten yang ditemukan --}}
                @foreach($groupedTypes as $type => $items)
                    <a href="{{ route('search.results', ['q' => $query, 'type' => $type]) }}"
                       class="filter-tab {{ request('type') === $type ? 'active' : '' }}">
                        @php
                            /* Tentukan ikon berdasarkan tipe konten */
                            $iconMap = [
                                'Berita'        => 'fa-newspaper',
                                'UMKM'          => 'fa-store',
                                'Penginapan'    => 'fa-hotel',
                                'Biodiversitas' => 'fa-leaf',
                                'Geodiversitas' => 'fa-gem',
                                'Budaya'        => 'fa-people-arrows',
                                'Destinasi'     => 'fa-map-marked-alt',
                            ];
                            $icon = $iconMap[$type] ?? 'fa-circle';
                        @endphp
                        <i class="fas {{ $icon }}"></i> {{ $type }}
                        <span class="count-badge">{{ $items->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ΓöÇΓöÇ GRID KARTU HASIL ΓöÇΓöÇ --}}
        {{-- Filter berdasarkan tipe jika parameter 'type' ada di URL --}}
        @php
            $displayedResults = request('type')
                ? $results->where('type', request('type'))->values()
                : $results;
        @endphp

        <div class="results-grid">
            @foreach($displayedResults as $item)
            {{-- Setiap item dari hasil pencarian ditampilkan sebagai kartu --}}
            <a href="{{ $item['url'] }}" class="result-card">

                {{-- ΓöÇΓöÇ BAGIAN GAMBAR ΓöÇΓöÇ --}}
                <div class="card-image-wrapper">
                    @php
                        /* Simpan ikon di variabel PHP agar tidak perlu diakses di dalam atribut HTML */
                        $cardIcon = $item['icon'] ?? 'fa-image';
                    @endphp
                    @if(!empty($item['gambar_url']))
                        {{-- Gambar utama: jika gagal dimuat, sembunyikan dan tampilkan placeholder di sampingnya --}}
                        <img
                            src="{{ $item['gambar_url'] }}"
                            alt="{{ $item->nama_usaha_trans ?? $item->nama_wisata_trans ?? $item->judul_trans ?? $item->nama_trans ?? $item->nama_usaha ?? $item->nama_wisata ?? $item->judul ?? $item->nama }}"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        {{-- Placeholder tersembunyi, muncul otomatis jika gambar error --}}
                        <div class="card-image-placeholder" style="display:none;">
                            <i class="fas {{ $cardIcon }}"></i>
                        </div>
                    @else
                        {{-- Jika memang tidak ada gambar, langsung tampilkan placeholder --}}
                        <div class="card-image-placeholder">
                            <i class="fas {{ $cardIcon }}"></i>
                        </div>
                    @endif


                    {{-- Overlay gelap dengan ikon panah saat hover --}}
                    <div class="card-image-overlay">
                        <i class="fas fa-arrow-right"></i>
                    </div>

                    {{-- Badge tipe konten di pojok kiri atas gambar --}}
                    <span class="card-type-badge">
                        <i class="fas {{ $item['icon'] ?? 'fa-circle' }}"></i>
                        {{ $item['type'] }}
                    </span>

                    {{-- Badge tanggal di pojok kanan bawah gambar (hanya untuk Berita) --}}
                    @if(!empty($item['tanggal']))
                        <span class="card-date-badge">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $item['tanggal'] }}
                        </span>
                    @endif
                </div>

                {{-- ΓöÇΓöÇ BAGIAN KONTEN TEKS ΓöÇΓöÇ --}}
                <div class="card-content">
                    {{-- Judul item --}}
                    <div class="card-title">{{ $item->nama_usaha_trans ?? $item->nama_wisata_trans ?? $item->judul_trans ?? $item->nama_trans ?? $item->nama_usaha ?? $item->nama_wisata ?? $item->judul ?? $item->nama }}</div>

                    {{-- Deskripsi singkat (ambil teks bersih tanpa tag HTML) --}}
                    @if(!empty($item['deskripsi']))
                        <div class="card-excerpt">
                            {{ Str::limit(strip_tags($item['deskripsi']), 130) }}
                        </div>
                    @endif

                    {{-- Meta info: lokasi, kontak, harga --}}
                    <div class="card-meta">
                        {{-- Lokasi / sub-info (penulis berita, lokasi, kategori, dll) --}}
                        @if(!empty($item['sub']))
                            <div class="card-meta-item">
                                <i class="fas fa-info-circle"></i>
                                {{ $item['sub'] }}
                            </div>
                        @endif

                        {{-- Harga (khusus Penginapan) --}}
                        @if(!empty($item['harga']))
                            <div class="card-meta-item">
                                <i class="fas fa-tag"></i>
                                {{ $item['harga'] }}
                            </div>
                        @endif

                        {{-- Kontak / no. telepon (khusus UMKM & Penginapan) --}}
                        @if(!empty($item['kontak']))
                            <div class="card-meta-item">
                                <i class="fas fa-phone-alt"></i>
                                {{ $item['kontak'] }}
                            </div>
                        @endif
                    </div>

                    {{-- Footer kartu: tombol "Lihat Detail" --}}
                    <div class="card-footer">
                        <span class="read-more">
                            Lihat Detail <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>

            </a>
            @endforeach
        </div>

        @elseif($query && $results->count() === 0)

        {{-- ΓöÇΓöÇ STATE KOSONG: Tidak ada hasil ditemukan ΓöÇΓöÇ --}}
        <div class="results-grid">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-search-minus"></i>
                </div>
                <h3>Maaf, Data Tidak Ditemukan</h3>
                <p>
                    Tidak ada konten yang cocok dengan kata kunci
                    <strong>"{{ $query }}"</strong>.
                    Coba gunakan kata kunci yang berbeda atau lebih umum.
                </p>
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

        @else

        {{-- ΓöÇΓöÇ STATE AWAL: Pengguna belum memasukkan kata kunci ΓöÇΓöÇ --}}
        <div class="results-grid">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Mulai Pencarian Anda</h3>
                <p>
                    Ketikkan kata kunci di kolom pencarian di atas untuk menemukan
                    destinasi, berita, UMKM, penginapan, dan konten lainnya.
                </p>
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

        @endif

    </div>
</section>

@endsection
