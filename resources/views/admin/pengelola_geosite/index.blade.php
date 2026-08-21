@extends('layouts.admin')

@section('title', 'Kelola Pengelola Geosite')

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

    .card-header h5 i { color: #c6a43b; font-size: 1.2rem; }

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
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    thead { background: #f8fafc; }

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

    tbody tr:hover { background: #fafcff; }

    .avatar-cell {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #003366, #1a4a7a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        font-weight: 700;
        overflow: hidden;
        flex-shrink: 0;
    }

    .avatar-cell img {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
    }

    .nama-block strong {
        display: block;
        font-size: 0.9rem;
        color: #1e293b;
    }

    .nama-block span {
        font-size: 0.75rem;
        color: #64748b;
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
        border: 1px solid #ffcdd2;
        display: inline-flex;
        align-items: center;
        gap: 5px;
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
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 768px) {
        .card-header { padding: 14px 16px; flex-direction: column; align-items: flex-start; }
        th, td { padding: 10px 12px; font-size: 0.75rem; }
        .btn-edit, .btn-delete { padding: 4px 10px; font-size: 0.65rem; }
    }

    /* Lightbox Styles */
    .lightbox-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 80px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.85);
        backdrop-filter: blur(5px);
    }
    .lightbox-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 80vh;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        animation: zoomIn 0.3s ease;
        object-fit: contain;
    }
    .lightbox-close {
        position: absolute;
        top: 25px;
        right: 40px;
        color: #f1f1f1;
        font-size: 45px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    .lightbox-close:hover {
        color: #c6a43b;
    }
    @keyframes zoomIn {
        from {transform:scale(0.8); opacity: 0;} 
        to {transform:scale(1); opacity: 1;}
    }
</style>

<div class="card-table">
    <div class="card-header">
        <h5>
            <i class="fas fa-users-cog"></i>
            Kelola Pengelola Geosite
        </h5>
        <a href="{{ route('admin.pengelola-geosite.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengelola
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="stats-bar">
        <span class="stats-badge">
            <i class="fas fa-database"></i> Total: {{ $pengelolas->count() }}
        </span>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Profil</th>
                    <th>Nama / Jabatan</th>
                    <th>Deskripsi</th>
                    <th>Urutan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengelolas as $index => $item)
                @php
                    $words = explode(' ', $item->nama);
                    $initials = '';
                    foreach(array_slice($words, 0, 2) as $w) {
                        $initials .= strtoupper(substr($w, 0, 1));
                    }
                @endphp
                <tr>
                    <td data-label="No">{{ $index + 1 }}</td>
                    <td data-label="Profil">
                        <div class="avatar-cell">
                            @if($item->image)
                                <img src="{{ asset($item->image) }}"
                                     alt="{{ $item->nama }}"
                                     style="cursor: pointer;"
                                     onclick="openLightbox('{{ asset($item->image) }}')"
                                     onerror="this.style.display='none'; this.parentElement.innerHTML='{{ $initials }}'">
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                    </td>
                    <td data-label="Nama">
                        <div class="nama-block">
                            <strong>{{ $item->nama }}</strong>
                            <span>{{ $item->jabatan }}</span>
                        </div>
                    </td>
                    <td data-label="Deskripsi" style="max-width: 260px; color: #64748b;">
                        {{ Str::limit($item->deskripsi, 70) }}
                    </td>
                    <td data-label="Urutan">
                        <span class="stats-badge">{{ $item->urutan }}</span>
                    </td>
                    <td data-label="Aksi">
                        <div class="btn-group">
                            <a href="{{ route('admin.pengelola-geosite.edit', $item->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.pengelola-geosite.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengelola ini?')" style="display: inline;">
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
                    <td colspan="6" class="empty-state">
                        <i class="fas fa-users-cog" style="font-size: 2rem; opacity: 0.4; display: block; margin-bottom: 10px;"></i>
                        Belum ada data pengelola
                        <p style="margin-top: 10px; font-size: 0.8rem;">Klik tombol "Tambah Pengelola" untuk mulai menambahkan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="imageLightbox" class="lightbox-modal" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightboxImage">
</div>

<script>
    function openLightbox(imgSrc) {
        document.getElementById('imageLightbox').style.display = "block";
        document.getElementById('lightboxImage').src = imgSrc;
    }
    
    function closeLightbox() {
        document.getElementById('imageLightbox').style.display = "none";
    }
</script>
@endsection
