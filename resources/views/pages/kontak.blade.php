@extends('layouts.app')

@section('title', 'Kontak Kami - Geosite Danau Toba')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@600;700&display=swap');
    
    .kontak-hero {
        background: linear-gradient(135deg, rgba(0,51,102,0.85), rgba(0,51,102,0.7)), url('{{ asset("image/meat/meat-hero.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 120px 0 80px 0;
        text-align: center;
        color: white;
    }
    .kontak-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .kontak-hero p {
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .kontak-section {
        padding: 80px 0;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }
    
    .kontak-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .kontak-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: stretch;
    }
    
    @media (max-width: 991px) {
        .kontak-grid {
            grid-template-columns: 1fr;
        }
    }

    .left-side {
        display: flex;
        flex-direction: column;
        gap: 20px;
        height: 100%;
    }

    .info-boxes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        align-items: stretch;
    }

    @media (max-width: 768px) {
        .info-boxes-grid { grid-template-columns: 1fr; }
    }

    .info-box {
        background: white;
        border-radius: 15px;
        padding: 25px 15px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .info-box-icon {
        width: 45px;
        height: 45px;
        background: #fdf8e9;
        color: #c6a43b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin: 0 auto 15px auto;
        flex-shrink: 0;
    }

    .info-box h5 {
        font-size: 1rem;
        color: #003366;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .info-box p {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
        line-height: 1.8;
    }

    .follow-us-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .follow-us-title {
        font-size: 1.2rem;
        color: #003366;
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
        display: inline-block;
    }
    
    .follow-us-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #c6a43b;
    }

    .social-links-row {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .social-links-row a {
        width: 45px;
        height: 45px;
        background: #f8fafc;
        color: #003366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    .social-links-row a:hover {
        background: #003366;
        color: white;
        transform: translateY(-3px);
    }

    .dark-blue-box {
        background: #0d3b66;
        border-radius: 15px;
        padding: 30px;
        color: white;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dark-blue-box .db-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .dark-blue-box .db-content {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.9);
        line-height: 1.8;
        margin-bottom: 20px;
    }
    
    .db-divider {
        width: 40px;
        height: 1px;
        background: rgba(255,255,255,0.2);
        margin: 0 auto 20px auto;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
    }
    
    .form-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        color: #003366;
        margin-bottom: 30px;
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        transition: all 0.3s;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #003366;
        box-shadow: 0 0 0 3px rgba(0,51,102,0.1);
    }

    textarea.form-control {
        flex: 1;
        min-height: 120px;
        resize: none;
    }
    
    .btn-submit {
        background: #c6a43b;
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: auto;
    }
    
    .btn-submit:hover {
        background: #b09133;
        transform: translateY(-2px);
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    .map-section {
        margin-top: 40px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: white;
    }
    .map-iframe {
        width: 100%;
        height: 450px;
        border: none;
        display: block;
    }
</style>

<div class="kontak-hero">
    <h1>Hubungi Kami</h1>
    <p>Punya pertanyaan, saran, atau butuh bantuan terkait wisata di Geosite Danau Toba? Kami siap membantu Anda.</p>
</div>

<div class="kontak-section">
    <div class="kontak-container">

        <div class="info-boxes-grid" style="margin-bottom: 30px;">
            <div class="info-box">
                <div class="info-box-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h5>Alamat</h5>
                <p>{!! nl2br(e(str_replace('\n', "\n", $kontak->alamat ?? 'Belum ada data alamat'))) !!}</p>
            </div>
            <div class="info-box">
                <div class="info-box-icon"><i class="fas fa-phone-alt"></i></div>
                <h5>Telepon</h5>
                <p>{!! nl2br(e(str_replace('\n', "\n", $kontak->telepon ?? 'Belum ada data telepon'))) !!}</p>
            </div>
            <div class="info-box">
                <div class="info-box-icon"><i class="fas fa-envelope"></i></div>
                <h5>Email</h5>
                <p>{!! nl2br(e(str_replace('\n', "\n", $kontak->email ?? 'Belum ada data email'))) !!}</p>
            </div>
        </div>
        
        <div class="kontak-grid">
            <div class="left-side">
                <div class="follow-us-container">
                    <div class="follow-us-title">Ikuti Kami</div>
                    
                    <div class="social-links-row">
                        @if($kontak->social_fb) <a href="{{ $kontak->social_fb }}" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                        @if($kontak->social_ig) <a href="{{ $kontak->social_ig }}" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                        @if($kontak->social_twitter) <a href="{{ $kontak->social_twitter }}" target="_blank"><i class="fab fa-twitter"></i></a> @endif
                        @if($kontak->social_youtube) <a href="{{ $kontak->social_youtube }}" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                        @if($kontak->social_tiktok) <a href="{{ $kontak->social_tiktok }}" target="_blank"><i class="fab fa-tiktok"></i></a> @endif
                    </div>

                    <div class="dark-blue-box">
                        @if($kontak->jam_operasional)
                            <div class="db-title"><i class="far fa-clock"></i> Jam Operasional</div>
                            <div class="db-content">{!! nl2br(e(str_replace('\n', "\n", $kontak->jam_operasional))) !!}</div>
                            <div class="db-divider"></div>
                        @endif
                        
                        @if($kontak->map_lokasi)
                            <div class="db-title"><i class="fas fa-map-marker-alt"></i> {{ $kontak->map_lokasi }}</div>
                            <div class="db-content">{{ $kontak->lokasi_bawah }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 class="form-title">Kirim Pesan</h3>
                
                @if(session('success'))
                    <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}</div>
                @endif

                <form action="{{ route('kontak.kirim') }}" method="POST" style="display:flex; flex-direction:column; flex:1;">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama Anda">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Telepon / WA</label>
                            <input type="text" name="telepon" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email Aktif *</label>
                        <input type="email" name="email" class="form-control" required placeholder="Contoh: nama@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Subjek *</label>
                        <input type="text" name="subjek" class="form-control" required placeholder="Apa yang ingin Anda tanyakan?">
                    </div>
                    
                    <div class="form-group" style="flex:1; display:flex; flex-direction:column;">
                        <label class="form-label">Pesan *</label>
                        <textarea name="pesan" class="form-control" required placeholder="Tuliskan detail pesan Anda di sini..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>

        @if($kontak->map_iframe)
        <div class="map-section">
            <iframe class="map-iframe" src="{{ $kontak->map_iframe }}" allowfullscreen="" loading="lazy"></iframe>
        </div>
        @endif

    </div>
</div>

@endsection