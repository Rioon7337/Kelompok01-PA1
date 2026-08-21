{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>
    /* ==================== CORE DECORATIONS ==================== */
    .dash-welcome {
        margin-bottom: 20px;
    }
    .dash-welcome h4 {
        margin: 0;
        font-size: 1.2rem;
        color: #003366;
        font-weight: 700;
    }
    .dash-welcome p {
        margin: 3px 0 0 0;
        font-size: 0.8rem;
        color: #64748b;
    }

    /* ==================== STATS GRID (COMPACT) ==================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-number {
        font-size: 1.35rem;
        font-weight: 700;
        color: #003366;
        line-height: 1;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
    }

    /* ==================== CARD TABLE STYLES ==================== */
    .card-table {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .card-header {
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .card-header h5 {
        font-size: 0.85rem;
        font-weight: 700;
        color: #003366;
        margin: 0;
    }
    
    .card-header h5 i {
        color: #003366;
        margin-right: 6px;
    }

    /* ==================== BUTTONS (PROPORSIONAL) ==================== */
    .btn-primary-sm {
        background: #003366;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-primary-sm:hover {
        background: #1a4a7a;
        color: white;
    }

    .btn-group-action {
        display: flex;
        gap: 6px;
    }

    .btn-action-edit {
        background: #eff6ff;
        color: #2563eb;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.725rem;
        font-weight: 600;
        text-decoration: none;
    }
    .btn-action-edit:hover { background: #dbeafe; }

    .btn-action-delete {
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.725rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }
    .btn-action-delete:hover { background: #fecaca; }

    /* ==================== COMPACT TABLE STYLES ==================== */
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    
    th {
        background: #f8fafc;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 10px 16px;
        border-bottom: 1px solid #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    
    td {
        padding: 10px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background-color: #f8fafc;
    }

    /* ==================== BADGES ==================== */
    .badge-status {
        display: inline-flex;
        padding: 2px 8px;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 12px;
    }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-inactive { background: #f1f5f9; color: #475569; }

    .empty-state {
        text-align: center;
        color: #94a3b8;
        font-size: 0.775rem;
        padding: 20px !important;
    }

</style>

<div class="dash-welcome">
    <h4>Dashboard Admin</h4>
    <p>Ringkasan data operasional website GeoToba Desa Meat.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalGaleri ?? 0 }}</div>
        <div class="stat-label">Total Galeri</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalBerita ?? 0 }}</div>
        <div class="stat-label">Total Berita</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalAgenda ?? 0 }}</div>
        <div class="stat-label">Total Agenda</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPengumuman ?? 0 }}</div>
        <div class="stat-label">Total Pengumuman</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">{{ $totalSejarah ?? 0 }}</div>
        <div class="stat-label">Total Sejarah Wisata</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalUmkm ?? 0 }}</div>
        <div class="stat-label">Lapak UMKM</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalFasilitas ?? 0 }}</div>
        <div class="stat-label">Fasilitas Desa</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">{{ $totalPenginapan ?? 0 }}</div>
        <div class="stat-label">Penginapan</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">{{ $totalKuliner ?? 0 }}</div>
        <div class="stat-label">Kuliner</div>
    </div>

    <div class="stat-card">
        <div class="stat-number">{{ $totalBiodiversitas ?? 0 }}</div>
        <div class="stat-label">Biodiversitas</div>
    </div>
</div>

@endsection
