@extends('layouts.admin')

@section('title', 'Manajemen Penginapan')

@section('content')
<style>
    .card-table {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .card-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    .card-header h5 i { color: #c6a43b; }
    .btn-primary {
        background: linear-gradient(135deg, #003366, #1a4a7a);
        color: white;
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); color: white; }
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 700px; }
    thead { background: #f8fafc; }
    th {
        padding: 12px 16px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }
    td {
        padding: 12px 16px;
        font-size: 0.82rem;
        color: #374151;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    tr:hover td { background: #f8fafc; }
    .table-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
    }
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .btn-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-edit {
        background: #fff8e1; color: #f57c00;
        padding: 5px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 600;
        text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
        border: 1px solid #ffe082; transition: all 0.2s ease; cursor: pointer;
    }
    .btn-edit:hover { background: #ffecb3; transform: translateY(-1px); color: #e65100; }
    .btn-delete {
        background: #ffebee; color: #d32f2f;
        padding: 5px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 600;
        border: 1px solid #ffcdd2; display: inline-flex; align-items: center; gap: 5px;
        transition: all 0.2s ease; cursor: pointer;
    }
    .btn-delete:hover { background: #ffcdd2; transform: translateY(-1px); color: #b71c1c; }
    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; font-size: 0.9rem; }
    .pagination { padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; }
    .pagination nav { display: flex; justify-content: center; }
    .stats-bar {
        display: flex; align-items: center; gap: 15px;
        padding: 12px 20px; background: #f8fafc;
        border-bottom: 1px solid #e2e8f0; flex-wrap: wrap;
    }
    .stats-badge {
        background: white; padding: 4px 12px; border-radius: 20px;
        font-size: 0.7rem; color: #003366; font-weight: 500;
        display: inline-flex; align-items: center; gap: 5px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    @media (max-width: 768px) {
        .card-header { padding: 14px 16px; flex-direction: column; align-items: flex-start; }
        th, td { padding: 10px 12px; font-size: 0.75rem; }
        .table-img { width: 40px; height: 40px; }
    }
</style>

<div class="card-table">
    <div class="card-header">
        <h5>
            <i class="fas fa-bed"></i>
            Manajemen Penginapan
        </h5>
        <a href="{{ route('admin.penginapan.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Penginapan
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="stats-bar">
        <span class="stats-badge">
            <i class="fas fa-database"></i> Total: {{ $data->total() }}
        </span>
        <span class="stats-badge">
            <i class="fas fa-eye"></i> Halaman {{ $data->currentPage() }} / {{ $data->lastPage() }}
        </span>
        <span class="stats-badge">
            <i class="fas fa-check-circle" style="color:#166534;"></i>
            Aktif: {{ $data->getCollection()->where('status', 1)->count() }}
        </span>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Penginapan</th>
                    <th>Lokasi</th>
                    <th>Harga</th>
                    <th>Kontak</th>
                    <th>Urutan</th>
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
                            <img src="{{ asset($item->gambar) }}" class="table-img" alt="{{ $item->nama }}">
                        @else
                            <div style="width:50px;height:50px;background:#e2e8f0;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-bed" style="color:#94a3b8;"></i>
                            </div>
                        @endif
                    </td>
                    <td data-label="Nama">
                        <strong>{{ Str::limit($item->nama, 30) }}</strong>
                    </td>
                    <td data-label="Lokasi">{{ $item->lokasi ?? '-' }}</td>
                    <td data-label="Harga">{{ $item->harga ?? '-' }}</td>
                    <td data-label="Kontak">{{ $item->kontak ?? '-' }}</td>
                    <td data-label="Urutan" style="text-align:center;">{{ $item->urutan }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $item->status == 1 ? 'badge-success' : 'badge-danger' }}">
                            {{ $item->status == 1 ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td data-label="Aksi">
                        <div class="btn-group">
                            <a href="{{ route('admin.penginapan.edit', $item->id) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.penginapan.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline;">
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
                    <td colspan="9" class="empty-state">
                        <i class="fas fa-bed" style="font-size:2rem;opacity:0.4;display:block;margin-bottom:10px;"></i>
                        Belum ada data Penginapan
                        <p style="margin-top:10px;font-size:0.8rem;">Klik tombol "Tambah Penginapan" untuk mulai menambahkan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->hasPages())
    <div class="pagination">
        {{ $data->links() }}
    </div>
    @endif
</div>
@endsection
