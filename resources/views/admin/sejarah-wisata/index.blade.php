@extends('layouts.admin')

@section('title', 'Sejarah Wisata')

@section('content')
<style>
    .card-table { background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .card-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; gap: 12px; }
    .card-header h5 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #003366; display: flex; align-items: center; gap: 8px; }
    .card-header h5 i { color: #c6a43b; }
    .btn-primary { background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color: white; padding: 8px 18px; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; border: none; cursor: pointer; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,51,102,0.3); color: white; }
    .btn-filter { background: #f1f5f9; color: #475569; padding: 6px 14px; border-radius: 8px; text-decoration: none; font-size: 0.75rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-filter:hover { background: #c6a43b; color: white; }
    .btn-filter.active { background: #003366; color: white; }
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 600px; }
    thead { background: #f8fafc; }
    th { padding: 14px 16px; text-align: left; font-weight: 700; font-size: 0.8rem; color: #003366; border-bottom: 2px solid #e2e8f0; }
    td { padding: 14px 16px; border-bottom: 1px solid #eef2f6; vertical-align: middle; font-size: 0.85rem; color: #1e293b; }
    .img-preview { width: 50px; height: 50px; object-fit: cover; border-radius: 10px; }
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 600; }
    .badge-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .badge-danger { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
    .badge-balige { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
    .badge-meat { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .badge-batu { background: #fff3e0; color: #e65100; border: 1px solid #ffe0b2; }
    .badge-liang { background: #f3e5f5; color: #7b1fa2; border: 1px solid #e1bee7; }
    .badge-sejarah { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
    .badge-legenda { background: #fff3e0; color: #e65100; border: 1px solid #ffe0b2; }
    .badge-budaya { background: #fce4ec; color: #c62828; border: 1px solid #f8bbd0; }
    .badge-informasi { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .badge-tokoh { background: #f3e5f5; color: #7b1fa2; border: 1px solid #e1bee7; }
    .btn-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-edit { background: #fff8e1; color: #f57c00; padding: 5px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #ffe082; transition: all 0.2s ease; cursor: pointer; }
    .btn-edit:hover { background: #ffecb3; transform: translateY(-1px); color: #e65100; }
    .btn-delete { background: #ffebee; color: #d32f2f; padding: 5px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 600; border: none; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #ffcdd2; transition: all 0.2s ease; cursor: pointer; }
    .btn-delete:hover { background: #ffcdd2; transform: translateY(-1px); color: #b71c1c; }
    .btn-view { background: #e8f5e9; color: #2e7d32; padding: 5px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #a5d6a7; transition: all 0.2s ease; }
    .btn-view:hover { background: #c8e6c9; transform: translateY(-1px); }
    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; font-size: 0.9rem; }
    .pagination { padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; }
    .stats-bar { display: flex; align-items: center; gap: 15px; padding: 12px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; }
    .stats-badge { background: white; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; color: #003366; font-weight: 500; display: inline-flex; align-items: center; gap: 5px; }
    .filter-bar { display: flex; gap: 8px; padding: 12px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; flex-wrap: wrap; align-items: center; }
    .filter-bar label { font-size: 0.75rem; font-weight: 600; color: #475569; margin-right: 4px; }
    .alert-success { background: #e8f5e9; color: #2e7d32; padding: 12px 20px; margin: 16px 20px; border-radius: 12px; border-left: 4px solid #2e7d32; display: flex; align-items: center; gap: 10px; font-size: 0.85rem; }
    @media (max-width: 768px) { .card-header { flex-direction: column; align-items: flex-start; } th, td { padding: 10px 12px; font-size: 0.75rem; } .img-preview { width: 40px; height: 40px; } }
</style>

<div class="card-table">
    <div class="card-header">
        <h5><i class="fas fa-history"></i> Sejarah Wisata</h5>
        <a href="{{ route('admin.sejarah-wisata.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Sejarah
        </a>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="filter-bar">
        <label><i class="fas fa-filter"></i> Filter Geosite:</label>
        <a href="{{ route('admin.sejarah-wisata.index') }}" class="btn-filter {{ !request()->route('geosite') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('admin.sejarah-wisata.filter', 'balige') }}" class="btn-filter {{ request()->route('geosite') == 'balige' ? 'active' : '' }}">Balige</a>
        <a href="{{ route('admin.sejarah-wisata.filter', 'meat') }}" class="btn-filter {{ request()->route('geosite') == 'meat' ? 'active' : '' }}">Meat</a>
        <a href="{{ route('admin.sejarah-wisata.filter', 'batu-basiha') }}" class="btn-filter {{ request()->route('geosite') == 'batu-basiha' ? 'active' : '' }}">Batu Basiha</a>
        <a href="{{ route('admin.sejarah-wisata.filter', 'liang-sipege') }}" class="btn-filter {{ request()->route('geosite') == 'liang-sipege' ? 'active' : '' }}">Liang Sipege</a>
    </div>

    <div class="stats-bar">
        <span class="stats-badge"><i class="fas fa-database"></i> Total: {{ $data->total() }}</span>
        <span class="stats-badge"><i class="fas fa-eye"></i> Halaman {{ $data->currentPage() }} / {{ $data->lastPage() }}</span>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Geosite</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $key => $item)
                <tr>
                    <td data-label="No">{{ $loop->iteration }}</td>
                    <td data-label="Gambar">
                        @if($item->gambar && file_exists(public_path($item->gambar)))
                            <img src="{{ asset($item->gambar) }}" class="img-preview" alt="{{ $item->judul }}">
                        @else
                            <img src="{{ asset('image/default.jpg') }}" class="img-preview" alt="Default">
                        @endif
                    </td>
                    <td data-label="Judul"><strong>{{ Str::limit($item->judul, 35) }}</strong></td>
                    <td data-label="Geosite">
                        <span class="badge badge-{{ str_replace('-', '', $item->geosite) }}">
                            {{ $item->geosite_label }}
                        </span>
                    </td>
                    <td data-label="Kategori">
                        <span class="badge badge-{{ $item->kategori }}">
                            {{ $item->kategori_label }}
                        </span>
                    </td>
                    <td data-label="Status">
                        <span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">
                            {{ $item->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td data-label="Aksi">
                        <div class="btn-group">
                            <a href="{{ route('admin.sejarah-wisata.show', $item->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.sejarah-wisata.edit', $item->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sejarah-wisata.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-history" style="font-size:2rem; opacity:0.5; display:block; margin-bottom:10px;"></i>
                        📭 Belum ada data sejarah wisata
                        <p style="margin-top:10px; font-size:0.8rem;">Klik tombol "Tambah Sejarah" untuk mulai menambahkan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->hasPages())
    <div class="pagination">{{ $data->links() }}</div>
    @endif
</div>
@endsection