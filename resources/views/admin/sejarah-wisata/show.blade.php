@extends('layouts.admin')

@section('title', 'Detail Sejarah Wisata')

@section('content')
<style>
    .card { background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .card-header { padding: 18px 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; }
    .card-header h5 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #003366; display: flex; align-items: center; gap: 8px; }
    .card-header h5 i { color: #c6a43b; }
    .card-body { padding: 24px; }
    .detail-img { width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; }
    .detail-label { font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .detail-value { font-size: 0.95rem; color: #1e293b; margin-bottom: 15px; }
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 14px; border-radius: 50px; font-size: 0.7rem; font-weight: 600; }
    .badge-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .badge-danger { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
    .badge-balige { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
    .badge-meat { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .badge-batu { background: #fff3e0; color: #e65100; border: 1px solid #ffe0b2; }
    .badge-liang { background: #f3e5f5; color: #7b1fa2; border: 1px solid #e1bee7; }
    .content-box { background: #f8fafc; padding: 20px; border-radius: 12px; margin-top: 15px; }
    .content-box p { line-height: 1.8; color: #1e293b; }
    .btn-back { background: #f1f5f9; color: #475569; padding: 8px 20px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease; }
    .btn-back:hover { background: #e2e8f0; transform: translateY(-2px); }
    .btn-edit { background: #003366; color: white; padding: 8px 20px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease; }
    .btn-edit:hover { background: #1a4a7a; transform: translateY(-2px); color: white; }
    .btn-group { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px; }
    @media (max-width: 768px) { .card-body { padding: 18px; } .detail-img { max-height: 250px; } }
</style>

<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-eye"></i> Detail Sejarah Wisata</h5>
    </div>
    <div class="card-body">
        @if($data->gambar && file_exists(public_path($data->gambar)))
            <img src="{{ asset($data->gambar) }}" alt="{{ $data->judul }}" class="detail-img">
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="detail-label">Judul</div>
                <div class="detail-value"><strong>{{ $data->judul }}</strong></div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="badge {{ $data->status ? 'badge-success' : 'badge-danger' }}">
                        {{ $data->status ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="detail-label">Geosite</div>
                <div class="detail-value">
                    <span class="badge badge-{{ str_replace('-', '', $data->geosite) }}">
                        {{ $data->geosite_label }}
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Kategori</div>
                <div class="detail-value">
                    <span class="badge badge-{{ $data->kategori }}">
                        {{ $data->kategori_label }}
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Views</div>
                <div class="detail-value">{{ number_format($data->views ?? 0) }} kali dibaca</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="detail-label">Lokasi</div>
                <div class="detail-value">{{ $data->lokasi ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Penulis</div>
                <div class="detail-value">{{ $data->penulis ?? '-' }}</div>
            </div>
        </div>

        <div class="detail-label">Konten</div>
        <div class="content-box">
            {!! $data->konten !!}
        </div>

        <div class="btn-group">
            <a href="{{ route('admin.sejarah-wisata.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.sejarah-wisata.edit', $data->id) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection