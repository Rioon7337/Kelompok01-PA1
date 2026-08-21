<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Geosite Danau Toba')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { 
            font-family: 'Inter', sans-serif; 
            box-sizing: border-box; 
        }
        
        :root {
            --blue-dark: #003366;
            --blue-medium: #1a4a7a;
            --blue-light: #4a8ab5;
            --gold: #c6a43b;
            --gold-light: #e8c45a;
            --gold-dark: #a8882e;
            --white: #ffffff;
            --gray-light: #f8fafc;
            --gray: #64748b;
            --text-dark: #0f172a;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
            --radius: 16px;
        }

        html, body {
            overflow-x: hidden;
            background: var(--gray-light);
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            padding-top: 64px; /* Compensate for fixed navbar */
            overflow-x: hidden;
        }

        main {
            margin: 0;
            padding: 0;
        }

        /* ========================================
           NAVBAR
        ======================================== */
        .navbar {
            position: fixed;
            transition: all 0.35s ease;
            padding: 0;
            height: 64px;
            background: rgba(0, 51, 102, 0.97);
            backdrop-filter: blur(12px);
            border-bottom: none;
            box-shadow: none;
            z-index: 1050;
            top: 0;
            left: 0;
            right: 0;
        }

        .navbar.scrolled-down {
            background: var(--white) !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .navbar.scrolled-down .navbar-brand {
            color: var(--blue-dark) !important;
        }

        .navbar.scrolled-down .nav-link {
            color: var(--blue-dark) !important;
        }

        .navbar.scrolled-down .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.1);
        }

        .navbar.scrolled-down .nav-link.active {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.1);
        }

        /* CONTAINER */
        .navbar .container {
            max-width: 1800px; /* Diperbesar agar jarak kosong berkurang */
            padding: 0 12px; /* Padding dikurangi setengahnya dari 24px menjadi 12px */
            height: 100%;
            display: flex;
            align-items: center;
        }

        /* LOGO */
        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .logo-img {
            height: 38px;
            width: auto;
            border-radius: 7px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .logo-divider {
            width: 1px;
            height: 28px;
            background: rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
            transition: background 0.3s;
        }

        .navbar.scrolled-down .logo-divider {
            background: rgba(0, 51, 102, 0.2);
        }

        .navbar-brand {
            font-size: 1.45rem; /* Ukuran teks logo diperbesar */
            font-weight: 800;
            color: white !important;
            margin: 0;
            padding: 0;
            font-family: 'Quincy CF', serif;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .navbar-brand span {
            color: var(--gold);
        }

        /* NAV COLLAPSE */
        .navbar-collapse {
            flex: 1;
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }

        /* NAV LIST */
        .navbar-nav {
            display: flex;
            align-items: center;
            flex: 1;
            justify-content: center;
            gap: 1px;
            flex-wrap: nowrap;
        }

        /* NAV LINKS */
        .nav-link {
            color: rgba(255, 255, 255, 0.88) !important;
            font-family: 'Quincy CF', serif !important;
            font-weight: bold !important;
            font-size: 0.9rem; /* Ukuran teks diperbesar dari 0.72rem */
            padding: 5px 10px !important; /* Padding sedikit diperbesar agar proporsional */
            border-radius: 7px;
            transition: all 0.25s ease;
            white-space: nowrap;
            cursor: pointer;
            line-height: 1.4;
        }

        .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.12);
        }

        .nav-link.active {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.13);
        }

        /* TOGGLER */
        .navbar-toggler {
            border: none;
            padding: 7px 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 9px;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px var(--gold);
            outline: none;
        }

        .navbar.scrolled-down .navbar-toggler {
            background: rgba(0, 51, 102, 0.08);
        }

        .navbar.scrolled-down .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0,51,102,1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ========================================
           SEARCH BAR
        ======================================== */
        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            flex-shrink: 0;
            margin-left: 12px;
        }

        .search-input-container {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 30px;
            padding: 5px 12px;
            gap: 7px;
            width: 150px;
            transition: all 0.3s ease;
        }

        .search-input-container:focus-within {
            background: rgba(255, 255, 255, 0.18);
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198, 164, 59, 0.15);
            width: 190px;
        }

        .navbar.scrolled-down .search-input-container {
            background: rgba(0, 51, 102, 0.06);
            border-color: rgba(0, 51, 102, 0.18);
        }

        .navbar.scrolled-down .search-input-container:focus-within {
            background: rgba(0, 51, 102, 0.1);
            border-color: var(--blue-dark);
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .search-icon-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.65);
            transition: color 0.25s;
            flex-shrink: 0;
        }

        .search-icon-btn:hover { color: var(--gold); }

        .search-icon { font-size: 0.75rem; }

        .navbar.scrolled-down .search-icon-btn { color: rgba(0, 51, 102, 0.5); }
        .navbar.scrolled-down .search-icon-btn:hover { color: var(--blue-dark); }

        #globalSearchInput {
            background: transparent;
            border: none;
            outline: none;
            color: white;
            font-size: 0.9rem; /* Ukuran teks search diperbesar */
            font-weight: 500;
            width: 100%;
            font-family: 'Inter', sans-serif;
            padding: 2px 0;
        }

        .navbar.scrolled-down #globalSearchInput { color: var(--blue-dark); }

        #globalSearchInput::placeholder {
            color: rgba(255, 255, 255, 0.42);
            font-size: 0.85rem; /* Ukuran teks placeholder diperbesar */
        }

        .navbar.scrolled-down #globalSearchInput::placeholder {
            color: rgba(0, 51, 102, 0.38);
        }

        .search-clear-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.45);
            cursor: pointer;
            padding: 0;
            font-size: 0.65rem;
            flex-shrink: 0;
            display: none;
            line-height: 1;
            transition: color 0.2s;
        }

        .search-clear-btn:hover { color: white; }

        .navbar.scrolled-down .search-clear-btn { color: rgba(0, 51, 102, 0.4); }
        .navbar.scrolled-down .search-clear-btn:hover { color: var(--blue-dark); }

        /* SEARCH DROPDOWN */
        #searchResultsDropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 360px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 51, 102, 0.07);
            overflow: hidden;
            z-index: 9999;
            display: none;
            animation: dropdownFadeIn 0.2s ease;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .search-results-header {
            padding: 9px 16px;
            font-size: 0.67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gold);
            background: rgba(0, 51, 102, 0.03);
            border-bottom: 1px solid rgba(0, 51, 102, 0.05);
        }

        .search-result-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            text-decoration: none;
            color: var(--text-dark);
            transition: background 0.2s;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }

        .search-result-item:last-child { border-bottom: none; }
        .search-result-item:hover { background: rgba(0, 51, 102, 0.04); }

        .search-result-thumb {
            width: 42px;
            height: 42px;
            border-radius: 9px;
            object-fit: cover;
            flex-shrink: 0;
            background: #f1f5f9;
        }

        .search-result-icon-placeholder {
            width: 42px;
            height: 42px;
            border-radius: 9px;
            background: linear-gradient(135deg, rgba(0,51,102,0.1), rgba(198,164,59,0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--blue-dark);
            font-size: 1rem;
        }

        .search-result-info { flex: 1; overflow: hidden; }

        .search-result-name {
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-result-sub {
            font-size: 0.74rem;
            color: var(--gray);
            margin-top: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-result-badge {
            font-size: 0.6rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            background: rgba(0, 51, 102, 0.08);
            color: var(--blue-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .search-empty-state { padding: 26px 16px; text-align: center; }
        .search-empty-state i { font-size: 1.8rem; color: #cbd5e1; margin-bottom: 8px; display: block; }
        .search-empty-state p { color: #94a3b8; font-size: 0.83rem; margin: 0; }

        .search-loading { padding: 18px 16px; text-align: center; color: #94a3b8; font-size: 0.83rem; }
        .search-loading i { animation: spin 1s linear infinite; margin-right: 6px; }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ========================================
           RESPONSIVE MOBILE & TABLET
        ======================================== */
        @media (max-width: 991px) {

            .navbar {
                height: auto;
                padding: 0;
            }

            .navbar .container {
                padding: 10px 14px;
                flex-wrap: wrap;
                align-items: center;
                height: auto;
                gap: 0;
            }

            .logo-wrapper {
                flex: 1;
                min-width: 0;
            }

            .logo-img { height: 30px; }
            .logo-divider { height: 20px; }
            .navbar-brand { font-size: 0.95rem; }

            .navbar-toggler {
                order: 3;
                margin-left: 8px;
            }

            /* Collapse panel */
            .navbar-collapse {
                order: 10;
                flex: none;
                width: 100%;
                display: none !important;
                flex-direction: column;
                background: rgba(0, 36, 78, 0.98);
                border-radius: 12px;
                margin-top: 8px;
                padding: 8px 8px 12px;
                max-height: 80vh;
                overflow-y: auto;
            }

            .navbar-collapse.show {
                display: flex !important;
            }

            .navbar.scrolled-down .navbar-collapse {
                background: rgba(248, 250, 252, 0.99);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            }

            /* Nav list */
            .navbar-nav {
                flex-direction: column;
                width: 100%;
                gap: 2px;
                justify-content: flex-start;
                flex: none;
                align-items: center;
                text-align: center;
            }

            .nav-item { width: 100%; }

            .nav-link {
                display: flex !important;
                align-items: center;
                width: 100%;
                padding: 11px 14px !important;
                border-radius: 9px;
                font-size: 0.84rem !important;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.9) !important;
            }

            .navbar.scrolled-down .nav-link {
                color: var(--blue-dark) !important;
            }

            .navbar.scrolled-down .nav-link:hover {
                background: rgba(198, 164, 59, 0.1);
                color: var(--gold) !important;
            }

            .navbar.scrolled-down .nav-link.active {
                background: rgba(198, 164, 59, 0.1);
                color: var(--gold) !important;
            }

            /* Search di dalam collapse — item terakhir */
            .search-wrapper {
                width: 100%;
                margin-left: 0;
                margin-top: 6px;
                padding-top: 6px;
                border-top: 1px solid rgba(255, 255, 255, 0.07);
                display: block;
            }

            .navbar.scrolled-down .search-wrapper {
                border-top-color: rgba(0, 51, 102, 0.08);
            }

            .search-wrapper .search-input-container {
                width: 100%;
                border-radius: 10px;
                padding: 10px 14px;
                gap: 10px;
                border-color: rgba(198, 164, 59, 0.25);
                background: rgba(255, 255, 255, 0.07);
            }

            .search-wrapper .search-input-container:focus-within {
                width: 100%;
                border-color: var(--gold);
                background: rgba(255, 255, 255, 0.12);
                box-shadow: 0 0 0 3px rgba(198, 164, 59, 0.15);
            }

            .navbar.scrolled-down .search-wrapper .search-input-container {
                background: rgba(0, 51, 102, 0.05);
                border-color: rgba(0, 51, 102, 0.15);
            }

            .navbar.scrolled-down .search-wrapper .search-input-container:focus-within {
                background: rgba(0, 51, 102, 0.08);
                border-color: var(--blue-dark);
                box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
            }

            .search-wrapper #globalSearchInput {
                font-size: 0.82rem;
                color: white;
            }

            .navbar.scrolled-down .search-wrapper #globalSearchInput {
                color: var(--blue-dark);
            }

            .search-wrapper #globalSearchInput::placeholder {
                font-size: 0.78rem;
                color: rgba(255, 255, 255, 0.4);
            }

            .navbar.scrolled-down .search-wrapper #globalSearchInput::placeholder {
                color: rgba(0, 51, 102, 0.38);
            }

            .search-wrapper .search-icon {
                font-size: 0.8rem;
                color: var(--gold);
            }

            .navbar.scrolled-down .search-wrapper .search-icon-btn {
                color: rgba(0, 51, 102, 0.5);
            }

            #searchResultsDropdown {
                min-width: unset;
                width: 100%;
                right: 0;
                left: 0;
            }
        }

        @media (max-width: 576px) {
            .logo-img { height: 26px; }
            .navbar-brand { font-size: 0.88rem; }
            .logo-divider { height: 17px; }
            .navbar .container { padding: 8px 12px; }
        }

        /* ========================================
           FOOTER MODERN
        ======================================== */
        .footer {
            background: linear-gradient(135deg, #001f3f 0%, #003366 50%, #0a4a7a 100%);
            padding: 60px 0 30px;
            margin-top: 0;
            position: relative;
            border-top: 3px solid rgba(198, 164, 59, 0.3);
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand .logo-footer {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .footer-brand .logo-footer-img {
            height: 40px;
            width: auto;
            border-radius: 8px;
        }

        .footer-brand h4 {
            font-size: 1.4rem;
            font-weight: 800;
            font-family: 'Quincy CF', serif;
            background: linear-gradient(135deg, #fff 0%, var(--gold) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .footer-brand h4 span {
            background: linear-gradient(135deg, var(--gold) 0%, #ffd966 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            line-height: 1.7;
            margin-top: 8px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 18px;
        }

        .footer-social a {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-social a:hover {
            background: var(--gold);
            color: var(--blue-dark);
            transform: translateY(-3px);
        }

        .footer-col h5 {
            color: var(--gold);
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 18px;
            letter-spacing: 0.5px;
            position: relative;
            display: inline-block;
        }

        .footer-col h5::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
        }

        .footer-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-menu a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-menu a i {
            font-size: 0.65rem;
            opacity: 0;
            transform: translateX(-5px);
            transition: all 0.3s ease;
            color: var(--gold);
        }

        .footer-menu a:hover {
            color: var(--gold);
            transform: translateX(5px);
        }

        .footer-menu a:hover i {
            opacity: 1;
            transform: translateX(0);
        }

        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-contact .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
        }

        .footer-contact .contact-item i {
            width: 32px;
            height: 32px;
            background: rgba(198, 164, 59, 0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer-copyright p {
            margin: 0;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
        }

        .footer-credit {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
        }

        .footer-credit a {
            color: var(--gold);
            text-decoration: none;
        }

        .footer-credit a:hover { text-decoration: underline; }

        @media (max-width: 992px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
        }

        @media (max-width: 768px) {
            .footer { padding: 40px 0 25px; margin-top: 0; }
            .footer-grid { grid-template-columns: 1fr; gap: 25px; text-align: center; }
            .footer-col h5::after { left: 50%; transform: translateX(-50%); }
            .footer-menu a { justify-content: center; }
            .footer-brand .logo-footer { justify-content: center; }
            .footer-social { justify-content: center; }
            .footer-contact .contact-item { justify-content: center; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }

        @media (max-width: 576px) {
            .footer { padding: 30px 0 20px; }
            .footer-container { padding: 0 16px; }
        }

        /* ========================================
           BACK TO TOP
        ======================================== */
        .back-to-top {
            position: fixed;
            bottom: 80px;
            right: 25px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--gold);
            color: var(--blue-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(198, 164, 59, 0.3);
            text-decoration: none;
            border: none;
        }

        .back-to-top i { font-size: 1.1rem; }

        .back-to-top:hover {
            background: white;
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
        }

        .back-to-top.show { opacity: 1; visibility: visible; }

        @media (max-width: 768px) {
            .back-to-top { bottom: 70px; right: 15px; width: 40px; height: 40px; }
        }

        /* ========================================
           MAIN CONTENT
        ======================================== */
        main {
            flex: 1;
            padding-top: 0;
            min-height: calc(100vh - 200px);
        }

        @media (max-width: 991px) { main { padding-top: 0; } }
        @media (max-width: 576px) { main { padding-top: 0; } }

        /* ========================================
           WIDGET FLOATING BAHASA (Language Switcher)
           Tampilan pill ID | EN
        ======================================== */
        .lang-switcher-widget {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            align-items: center;
            background: #003366;
            border-radius: 50px;
            padding: 5px 6px;
            gap: 2px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.28);
            transition: box-shadow 0.3s ease;
        }

        .lang-switcher-widget:hover {
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.35);
        }

        .lang-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 7px 16px;
            border-radius: 40px;
            text-decoration: none;
            transition: all 0.25s ease;
            cursor: pointer;
            min-width: 46px;
        }

        .lang-code {
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.55);
            text-transform: uppercase;
        }

        .lang-btn--active {
            background: #c6a43b;
        }

        .lang-btn--active .lang-code {
            color: #003366;
        }

        .lang-btn:not(.lang-btn--active):hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .lang-btn:not(.lang-btn--active):hover .lang-code {
            color: rgba(255, 255, 255, 0.85);
        }

        @media (max-width: 768px) {
            .lang-switcher-widget { bottom: 16px; right: 16px; }
            .lang-btn { padding: 6px 12px; min-width: 40px; }
            .lang-code { font-size: 0.75rem; }
        }

    
h1, h2, h3, h4, h5, h6, .page-title, .section-title, .navbar-brand {
    font-family: 'Quincy CF', serif !important;
    font-weight: bold !important;
}
</style>

    @stack('styles')
</head>
<body>

    <!-- ========================================
    NAVBAR
    ======================================== -->
    <nav class="navbar navbar-expand-lg" id="navbar">
        <div class="container">

            {{-- LOGO --}}
            <a class="logo-wrapper" href="{{ url('/') }}">
                <img src="{{ asset('image/logo/logobankindonesia.jpg') }}" alt="Bank Indonesia" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <img src="{{ asset('image/logo/del.jpg') }}" alt="Logo Del" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <span class="navbar-brand">Geo<span>Toba</span></span>
            </a>

            {{-- TOGGLER --}}
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- MENU --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ url('/') }}">{{ __('app.nav.home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang-geosite') ? 'active' : '' }}"
                           href="{{ route('tentang-geosite') }}">{{ __('app.nav.about_geosite') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('geodiversitas*') ? 'active' : '' }}"
                           href="{{ route('geodiversitas') }}">{{ __('app.nav.geodiversity') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('biodiversitas*') ? 'active' : '' }}"
                           href="{{ route('biodiversitas') }}">{{ __('app.nav.biodiversity') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cultural-diversity*') ? 'active' : '' }}"
                           href="{{ route('cultural-diversity') }}">{{ __('app.nav.cultural') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('destinasi*') ? 'active' : '' }}"
                           href="{{ url('/destinasi') }}">{{ __('app.nav.destination') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('umkm.index') ? 'active' : '' }}"
                           href="{{ route('umkm.index') }}">{{ __('app.nav.souvenir_umkm') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fasilitas*') ? 'active' : '' }}"
                           href="{{ url('/fasilitas') }}">{{ __('app.nav.facilities') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita*') ? 'active' : '' }}"
                           href="{{ url('/berita') }}">{{ __('app.nav.news') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}"
                           href="{{ url('/kontak') }}">Kontak</a>
                    </li>

                </ul>

                <div class="search-wrapper" id="searchWrapper">
                    <form id="globalSearchForm"
                          action="{{ route('search.results') }}"
                          method="GET"
                          style="display:contents;"
                          onsubmit="handleSearchSubmit(event)">
                        <div class="search-input-container">
                            <button type="submit" class="search-icon-btn" aria-label="Cari">
                                <i class="fas fa-search search-icon"></i>
                            </button>
                            <input
                                type="text"
                                id="globalSearchInput"
                                name="q"
                                placeholder="{{ __('app.nav.search_placeholder') }}"
                                autocomplete="off"
                                aria-label="Pencarian Global"
                                maxlength="100"
                                value="{{ request('q') }}"
                            >
                            <button class="search-clear-btn" id="searchClearBtn"
                                    type="button" aria-label="Hapus pencarian">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                    <div id="searchResultsDropdown"></div>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========================================
    MAIN CONTENT
    ======================================== -->
    <main style="margin: 0; padding: 0;">@yield('content')</main>

          <!-- ========================================
    FOOTER MODERN
      ======================================== -->
      @php
          $kontakInfo = \App\Models\Kontak::first();
      @endphp
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">

                <!-- Brand Column -->
                <div class="footer-brand">
                    <div class="logo-footer">
                        <img src="{{ asset('image/logo/logobankindonesia.jpg') }}" alt="Bank Indonesia" class="logo-footer-img" loading="lazy">
                        <img src="{{ asset('image/logo/del.jpg') }}" alt="Logo Del" class="logo-footer-img" loading="lazy">
                    </div>
                    <h4>Geo<span>Toba</span></h4>
                    <p>{{ __('app.footer.tagline') }}</p>
                                        <div class="footer-social">
                          @if(isset($kontakInfo) && $kontakInfo->social_fb)<a href="{{ $kontakInfo->social_fb }}" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                          @if(isset($kontakInfo) && $kontakInfo->social_ig)<a href="{{ $kontakInfo->social_ig }}" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>@endif
                          @if(isset($kontakInfo) && $kontakInfo->social_youtube)<a href="{{ $kontakInfo->social_youtube }}" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>@endif
                          @if(isset($kontakInfo) && $kontakInfo->social_twitter)<a href="{{ $kontakInfo->social_twitter }}" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>@endif
                          @if(isset($kontakInfo) && $kontakInfo->social_tiktok)<a href="{{ $kontakInfo->social_tiktok }}" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>@endif
                      </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h5>{{ __('app.footer.quick_links') }}</h5>
                    <div class="footer-menu">
                        <a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.home') }}</a>
                        <a href="{{ route('tentang-geosite') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.about_geosite') }}</a>
                        <a href="{{ url('/destinasi') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.destination') }}</a>
                        <a href="{{ url('/berita') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.news') }}</a>
                        <a href="{{ url('/galeri') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.gallery') }}</a>
                    </div>
                </div>

                <!-- Diversity -->
                <div class="footer-col">
                    <h5>{{ __('app.footer.diversity') }}</h5>
                    <div class="footer-menu">
                        <a href="{{ route('geodiversitas') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.geodiversity') }}</a>
                        <a href="{{ route('biodiversitas') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.biodiversity') }}</a>
                        <a href="{{ route('cultural-diversity') }}"><i class="fas fa-chevron-right"></i> {{ __('app.nav.cultural') }}</a>
                    </div>
                </div>

                <!-- Contact -->
                                <div class="footer-col">
                    <h5>{{ __('app.footer.contact') }}</h5>
                    <div class="footer-contact">
                          @if(isset($kontakInfo) && $kontakInfo->alamat)
                          <div class="contact-item">
                              <i class="fas fa-map-marker-alt"></i>
                              <span>{{ $kontakInfo->alamat }}</span>
                          </div>
                          @endif
                          @if(isset($kontakInfo) && $kontakInfo->telepon)
                          <div class="contact-item">
                              <i class="fas fa-phone"></i>
                              <span>{{ $kontakInfo->telepon }}</span>
                          </div>
                          @endif
                          @if(isset($kontakInfo) && $kontakInfo->email)
                          <div class="contact-item">
                              <i class="fas fa-envelope"></i>
                              <span>{{ $kontakInfo->email }}</span>
                          </div>
                          @endif
                      </div>
                  </div>
                </div>

            </div>

            <!-- Bottom -->
            <div class="footer-bottom">
                <div class="footer-copyright">
                    <p>&copy; {{ date('Y') }} GeoToba - Geopark Danau Toba. {{ __('app.footer.copyright') }}</p>
                </div>
                <div class="footer-credit">
                    <span>{{ __('app.footer.designed_by') }} <a href="#">Kelompok 10</a></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP -->
    <div class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </div>    {{-- ========================================
         WIDGET FLOATING GANTI BAHASA - pill ID | EN (Google Translate)
    ======================================== --}}
    @php
        $currentLang = 'id';
        if(isset($_COOKIE['googtrans']) && str_contains($_COOKIE['googtrans'], '/en')) {
            $currentLang = 'en';
        }
    @endphp
    
    <div class="lang-switcher-widget" id="langSwitcherWidget">
        {{-- Tombol Bahasa Indonesia --}}
        <a href="#"
           class="lang-btn {{ $currentLang === 'id' ? 'lang-btn--active' : '' }}"
           title="Bahasa Indonesia"
           aria-label="Ganti ke Bahasa Indonesia"
           onclick="doGTranslate('id'); return false;">
            <span class="lang-code">ID</span>
        </a>

        {{-- Tombol Bahasa Inggris --}}
        <a href="#"
           class="lang-btn {{ $currentLang === 'en' ? 'lang-btn--active' : '' }}"
           title="English"
           aria-label="Switch to English"
           onclick="doGTranslate('en'); return false;">
            <span class="lang-code">EN</span>
        </a>
    </div>

    <!-- Google Translate Script & Logic -->
    <script type="text/javascript">
        function doGTranslate(lang) {
            sessionStorage.setItem('langScroll', window.scrollY);
            var theLang = (lang === 'en') ? '/id/en' : '/id/id';
            // Set cookie for both domain and path to ensure compatibility
            document.cookie = "googtrans=" + theLang + "; path=/; domain=" + window.location.hostname;
            document.cookie = "googtrans=" + theLang + "; path=/";
            window.location.reload();
        }
        
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'id', autoDisplay: false}, 'google_translate_element');
        }

        // Restore scroll position
        window.addEventListener('load', function() {
            var scrollPos = sessionStorage.getItem('langScroll');
            if (scrollPos) {
                window.scrollTo(0, parseInt(scrollPos));
                sessionStorage.removeItem('langScroll');
            }
        });
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <div id="google_translate_element" style="display:none;"></div>
    
    <style>
        /* Sembunyikan toolbar/banner atas Google Translate */
        .goog-te-banner-frame.skiptranslate { display: none !important; }
        .VIpgJd-ZVi9od-ORHb-OEVmcd { display: none !important; }
        .VIpgJd-ZVi9od-aZ2wEe-wOHMyf { display: none !important; }
        iframe.skiptranslate { display: none !important; }
        body { top: 0px !important; position: static !important; }
        /* Sembunyikan popup tooltip saat hover pada teks terjemahan */
        .goog-tooltip { display: none !important; }
        .goog-tooltip:hover { display: none !important; }
        .goog-text-highlight { background-color: transparent !important; border: none !important; box-shadow: none !important; }
        font { background: transparent !important; }
    </style>

    <!-- ========================================
    SCRIPTS
    ======================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // ========================================
        // AOS INIT
        // ========================================
        AOS.init({ duration: 800, once: true, offset: 50 });

        // ========================================
        // NAVBAR SCROLL
        // ========================================
        const navbar    = document.getElementById('navbar');
        const backToTop = document.getElementById('backToTop');

        function handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > 50) {
                navbar.classList.add('scrolled-down');
            } else {
                navbar.classList.remove('scrolled-down');
            }
            if (scrollTop > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        }

        window.addEventListener('scroll', function () {
            requestAnimationFrame(handleScroll);
        });

        // ========================================
        // BACK TO TOP
        // ========================================
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ========================================
        // CLOSE MENU ON LINK CLICK, SCROLL, OR OUTSIDE CLICK (MOBILE)
        // ========================================
        function closeMobileMenu() {
            if (window.innerWidth <= 991) {
                var navbarCollapse = document.getElementById('navbarNav');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    var bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            }
        }

        // Close when a nav link is clicked
        document.querySelectorAll('.navbar-nav .nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                closeMobileMenu();
            });
        });

        // Close when user scrolls the page
        window.addEventListener('scroll', function () {
            closeMobileMenu();
        }, { passive: true });

        // Close when user clicks anywhere outside the navbar
        document.addEventListener('click', function (event) {
            var navbarElement = document.getElementById('navbar');
            if (navbarElement && !navbarElement.contains(event.target)) {
                closeMobileMenu();
            }
        });

        // ========================================
        // RESET ON RESIZE
        // ========================================
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                handleScroll();
            }, 200);
        });

        // ========================================
        // INITIAL
        // ========================================
        setTimeout(handleScroll, 100);
    </script>

    <!-- ========================================
    LIVE SEARCH JAVASCRIPT
    ======================================== -->
    <script>
    (function () {
        const searchInput    = document.getElementById('globalSearchInput');
        const searchDropdown = document.getElementById('searchResultsDropdown');
        const searchClearBtn = document.getElementById('searchClearBtn');
        const searchWrapper  = document.getElementById('searchWrapper');
        const SEARCH_URL     = '{{ route("search") }}';
        let debounceTimer    = null;

        function showLoading() {
            searchDropdown.style.display = 'block';
            searchDropdown.innerHTML = `
                <div class="search-loading">
                    <i class="fas fa-circle-notch"></i> ${@json(__('app.nav.searching'))}
                </div>
            `;
        }

        function showEmptyState(query) {
            searchDropdown.innerHTML = `
                <div class="search-empty-state">
                    <i class="fas fa-search-minus"></i>
                    <p>${@json(__('app.nav.search_no_result'))} <strong>"${escapeHtml(query)}"</strong></p>
                </div>
            `;
        }



        function hideDropdown() {
            searchDropdown.style.display = 'none';
            searchDropdown.innerHTML = '';
        }



        function escapeHtml(text) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(text));
            return div.innerHTML;
        }


        function renderResults(results) {
            if (!results || results.length === 0) {
                showEmptyState(searchInput.value);
                return;
            }

            let html = `<div class="search-results-header"><i class="fas fa-bolt me-1"></i> ${@json(__('app.nav.search_results'))} (${results.length})</div>`;

            results.forEach(function (item) {
                const thumbHtml = item.gambar_url
                    ? `<img src="${escapeHtml(item.gambar_url)}" alt="${escapeHtml(item.nama)}" class="search-result-thumb" loading="lazy"
                           onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                       <div class="search-result-icon-placeholder" style="display:none;"><i class="fas ${escapeHtml(item.icon)}"></i></div>`
                    : `<div class="search-result-icon-placeholder"><i class="fas ${escapeHtml(item.icon)}"></i></div>`;

                html += `
                    <a href="${escapeHtml(item.url)}" class="search-result-item">
                        ${thumbHtml}
                        <div class="search-result-info">
                            <div class="search-result-name">${escapeHtml(item.nama)}</div>
                            <div class="search-result-sub">${escapeHtml(item.sub || '')}</div>
                        </div>
                        <span class="search-result-badge">${escapeHtml(item.type)}</span>
                    </a>
                `;
            });

            searchDropdown.innerHTML = html;
            searchDropdown.style.display = 'block';
        }

        function performSearch(query) {
            showLoading();

            fetch(`${SEARCH_URL}?q=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(function (data) {
                renderResults(data);
            })
            .catch(function (error) {
                searchDropdown.innerHTML = `
                    <div class="search-empty-state">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                        <p>${@json(__('app.common.no_data'))}</p>
                    </div>
                `;
                searchDropdown.style.display = 'block';
                console.error('Search error:', error);
            });
        }

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            searchClearBtn.style.display = query.length > 0 ? 'block' : 'none';
            clearTimeout(debounceTimer);
            if (query.length === 0) { hideDropdown(); return; }
            if (query.length < 3)  { hideDropdown(); return; }
            debounceTimer = setTimeout(function () {
                performSearch(query);
            }, 300);
        });

        searchClearBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchClearBtn.style.display = 'none';
            hideDropdown();
            searchInput.focus();
        });

        document.addEventListener('click', function (event) {
            if (searchWrapper && !searchWrapper.contains(event.target)) {
                hideDropdown();
            }
        });

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                hideDropdown();
                searchInput.blur();
            }
        });

    })();

    // ========================================
    // FUNGSI SUBMIT FORM PENCARIAN
    // ========================================
    function handleSearchSubmit(event) {
        const input = document.getElementById('globalSearchInput');
        const query = input ? input.value.trim() : '';
        if (query.length < 1) {
            event.preventDefault();
            input.focus();
        }
    }
    </script>

    @stack('scripts')
</body>
</html>