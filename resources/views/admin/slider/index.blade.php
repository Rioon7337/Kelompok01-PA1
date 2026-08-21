@extends('layouts.admin')

@section('title', 'Manajemen Slider')

@section('content')
<style>
    .card-table {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .card-header h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #003366;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header h5 i {
        color: #c6a43b;
        font-size: 1.2rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        color: white;
        padding: 8px 18px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 51, 102, 0.3);
        color: white;
    }
    
    .alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 12px 20px;
        margin: 16px 20px;
        border-radius: 12px;
        border-left: 4px solid #2e7d32;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
    }
    
    .table-wrapper {
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }
    
    thead {
        background: #f8fafc;
    }
    
    th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 700;
        font-size: 0.8rem;
        color: #003366;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }
    
    td {
        padding: 14px 16px;
        border-bottom: 1px solid #eef2f6;
        vertical-align: middle;
        font-size: 0.85rem;
        color: #1e293b;
    }
    
    tbody tr:hover {
        background: #fafcff;
    }
    
    .img-preview {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .badge-success {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }
    
    .badge-danger {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }
    
    .btn-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .btn-edit {
        background: #fff8e1;
        color: #f57c00;
        padding: 5px 14px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid #ffe082;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-edit:hover {
        background: #ffecb3;
        transform: translateY(-1px);
        color: #e65100;
    }
    
    .btn-delete {
        background: #ffebee;
        color: #d32f2f;
        padding: 5px 14px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid #ffcdd2;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background: #ffcdd2;
        transform: translateY(-1px);
        color: #b71c1c;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .pagination {
        padding: 16px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }
    
    .pagination nav {
        display: flex;
        justify-content: center;
    }
    
    .pagination .pagination {
        margin: 0;
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-item .page-link {
        border-radius: 10px;
        border: none;
        padding: 6px 12px;
        color: #003366;
        font-weight: 500;
        background: white;
        transition: all 0.2s ease;
        font-size: 0.8rem;
    }
    
    .pagination .page-item.active .page-link {
        background: #003366;
        color: white;
    }
    
    .stats-bar {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }
    
    .stats-badge {
        background: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        color: #003366;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    @media (max-width: 768px) {
        .card-header {
            padding: 14px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-header h5 {
            font-size: 1rem;
        }
        
        .btn-primary {
            padding: 6px 14px;
            font-size: 0.75rem;
        }
        
        th, td {
            padding: 10px 12px;
            font-size: 0.75rem;
        }
        
        .img-preview {
            width: 40px;
            height: 40px;
        }
        
        .btn-edit, .btn-delete {
            padding: 4px 10px;
            font-size: 0.65rem;
        }
        
        .stats-badge {
            font-size: 0.65rem;
            padding: 3px 8px;
        }
    }
    
    @media (max-width: 576px) {
        .table-wrapper {
            overflow-x: visible;
        }
        
        table {
            min-width: 100%;
        }
        
        thead {
            display: none;
        }
        
        tbody tr {
            display: block;
            margin-bottom: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px;
            background: white;
        }
        
        td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border: none;
            font-size: 0.8rem;
            flex-wrap: wrap;
        }
        
        td:before {
            content: attr(data-label);
            font-weight: 700;
            color: #003366;
            margin-right: 15px;
            min-width: 80px;
        }
        
        .btn-group {
            justify-content: flex-end;
            width: 100%;
            margin-top: 5px;
        }
        
        .img-preview {
            width: 50px;
            height: 50px;
        }
    }
</style>

<div class="card-table">
    <div class="card-header">
        <h5>
            <i class="fas fa-images"></i>
            Manajemen Slider
        </h5>
        <a href="{{ route('admin.slider.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Slider
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    
    <div class="stats-bar">
        <span class="stats-badge">
            <i class="fas fa-database"></i> Total: {{ count($sliders) }} / 6
        </span>
    </div>
    
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul Utama</th>
                    <th>Sub Judul</th>
                    <th>Tanggal</th>
                    
                    
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $key => $item)
                <tr>
                    <td data-label="No">{{ $key + 1 }}</td>
                    <td data-label="Gambar">
                        @php
                            $imgUrl = asset($item->image_path);
                        @endphp
                        <img src="{{ $imgUrl }}" class="img-preview" alt="{{ $item->title }}" onerror="this.onerror=null; this.src='\{\{ asset\('image/default.jpg'\) \}\}'">
                    </td>
                    <td data-label="Judul Utama">
                        <strong>{{ Str::limit($item->title, 50) }}</strong>
                    </td>
                    <td data-label="Sub Judul">{{ $item->subtitle ?? '-' }}</td>
                    <td data-label="Tanggal">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>
                    
                    
                    <td data-label="Aksi">
                        <div class="btn-group">
                            <a href="{{ route('admin.slider.edit', $item->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.slider.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus slider ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="fas fa-images" style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 10px;"></i>
                        📭 Belum ada data slider
                        <p style="margin-top: 10px; font-size: 0.8rem;">Klik tombol "Tambah Slider" untuk mulai menambahkan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    
</div>
@endsection


