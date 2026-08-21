<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - GeoToba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            background: #0A1C2E;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
            margin: 0;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
            width: 100%;
            min-height: 620px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        /* ===== PANEL KIRI ===== */
        .left-panel {
            background: linear-gradient(135deg, #003366 0%, #002855 100%);
            display: flex;
            flex-direction: column;
            padding: 40px 32px;
            position: relative;
        }

        .left-content { position: relative; z-index: 2; flex: 1; display: flex; flex-direction: column; }

        /* Logo Area */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 50px;
        }

        .logo-badge {
            background: white;
            border-radius: 12px;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-badge img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .logo-sep {
            width: 1.5px;
            height: 35px;
            background: rgba(255,255,255,0.25);
        }

        .logo-name {
            color: white;
            font-size: 24px;
            font-weight: 800;
        }

        .logo-name span { color: #c6a43b; }

        /* Hero Text */
        .hero-text {
            flex: 1;
        }

        .hero-text h2 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 16px;
        }

        .hero-text h2 .highlight {
            color: #c6a43b;
            display: block;
        }

        .hero-text p {
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .hero-text p:last-of-type {
            margin-bottom: 0;
        }

        /* ===== PANEL KANAN ===== */
        .right-panel {
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
        }

        .right-panel .welcome-title {
            font-size: 24px;
            font-weight: 700;
            color: #003366;
            margin-bottom: 8px;
        }

        .right-panel .welcome-sub {
            font-size: 13px;
            color: #888;
            margin-bottom: 32px;
        }

        /* Alert Styling */
        .alert {
            padding: 10px 15px;
            font-size: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: none;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border: none;
        }

        /* Form Fields */
        .field-group { margin-bottom: 20px; }

        .field-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #555;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .field-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1.5px solid #e0e0e0;
            border-radius: 12px;
            padding: 0 16px;
            height: 48px;
            background: #f8f9fa;
            transition: all 0.25s ease;
        }

        .field-inner:focus-within {
            border-color: #003366;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0,51,102,0.08);
        }

        .field-inner i {
            font-size: 15px;
            color: #c6a43b;
            flex-shrink: 0;
        }

        .field-inner input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            flex: 1;
            color: #222;
            font-family: 'Inter', sans-serif;
        }

        .field-inner input::placeholder { 
            color: #bbb;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            height: 50px;
            background: #003366;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: #c6a43b;
            color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(198,164,59,0.3);
        }

        .btn-login:active { transform: translateY(0); }

        /* Secure Badge */
        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            font-size: 11px;
            color: #aaa;
        }

        .secure-badge i { 
            color: #4caf50; 
            font-size: 12px;
        }

        /* ===== LUPA PASSWORD DI BAWAH ===== */
        .forgot-bottom {
            text-align: center;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #e0e0e0;
        }

        .forgot-bottom-link {
            font-size: 12px;
            font-weight: 600;
            color: #020201;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .forgot-bottom-link:hover {
            color: #003366;
            text-decoration: underline;
            transform: translateX(3px);
        }

        /* Copyright Text */
        .login-footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #bbb;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 800px) {
            .login-wrapper { 
                grid-template-columns: 1fr;
                max-width: 480px;
            }
            .left-panel { 
                padding: 30px 28px;
                min-height: auto;
            }
            .logo-area { margin-bottom: 30px; }
            .hero-text h2 { font-size: 24px; }
            .right-panel { padding: 36px 32px; }
        }
        
        /* GARIS PEMISAH ANTARA DUA PARAGRAF */
        .divider-line {
            width: 60px;
            height: 3px;
            background: #c6a43b;
            margin: 20px 0;
            border-radius: 3px;
        }

        @media (max-width: 480px) {
            .logo-badge { width: 40px; height: 40px; }
            .logo-badge img { width: 30px; height: 30px; }
            .logo-name { font-size: 20px; }
            .hero-text h2 { font-size: 20px; }
            .right-panel { padding: 30px 24px; }
            .welcome-title { font-size: 20px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">

        {{-- PANEL KIRI --}}
        <div class="left-panel">
            <div class="left-content">
                <div class="logo-area">
                    <div class="logo-badge">
                        <img src="{{ asset('image/logo/logobankindonesia.jpg') }}" alt="Bank Indonesia">
                    </div>
                    <div class="logo-sep"></div>
                    <div class="logo-badge">
                        <img src="{{ asset('image/logo/del.jpg') }}" alt="Del">
                    </div>
                    <div class="logo-sep"></div>
                    <div class="logo-name">Geo<span>Toba</span></div>
                </div>

                <div class="hero-text">
                    <h2>
                        Selamat Datang <span class="highlight">di Portal Admin</span>
                    </h2>
                    <p>Kelola destinasi konten dan data wisata Geosite Danau Toba dari satu dashboard terpadu.</p>

                    <div class="divider-line"></div>

                    <p>Menjalankan informasi terintegrasi mengenai kekayaan geologi, warisan budaya, dan titik destinasi wisata.</p>
                </div>
            </div>
        </div>

        {{-- PANEL KANAN --}}
        <div class="right-panel">
            <h2 class="welcome-title">Masuk ke Dashboard</h2>
            <p class="welcome-sub">Masukkan kredensial admin Anda untuk melanjutkan.</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field-group">
                    <label>EMAIL ADMIN</label>
                    <div class="field-inner">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Masukkan Email"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="field-group">
                    <label>PASSWORD</label>
                    <div class="field-inner">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk Sekarang
                </button>
            </form>

            <!-- ===== LUPA PASSWORD DI BAWAH (SEBELUM SECURE BADGE) ===== -->
            <div class="forgot-bottom">
                <a href="{{ route('password.request') }}" class="forgot-bottom-link">
                    <i class="fas fa-question-circle"></i>
                    Lupa Password?
                </a>
            </div>

            <div class="secure-badge">
                <i class="fas fa-shield-alt"></i>
                Koneksi aman & terenkripsi SSL
            </div>

            <div class="login-footer-text">
                &copy; {{ date('Y') }} GeoToba. All Rights Reserved.
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>