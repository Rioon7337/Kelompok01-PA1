@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
<div style="background:white; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.08); overflow:hidden;">

    {{-- ── HEADER KARTU ── --}}
    <div style="display:flex; justify-content:space-between; align-items:center; padding:18px 24px; background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom:1px solid #e2e8f0; flex-wrap:wrap; gap:12px;">
        <h5 style="margin:0; font-size:1.1rem; font-weight:700; color:#003366; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-images" style="color:#c6a43b;"></i> Data Galeri
        </h5>
        <a href="{{ route('admin.galeri.create') }}"
           style="background:linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color:white; padding:8px 18px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:0.85rem; font-weight:600;">
            <i class="fas fa-plus"></i> Tambah Galeri
        </a>
    </div>

    {{-- ── NOTIFIKASI SUKSES ── --}}
    @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:12px 20px; margin:16px 20px; border-radius:12px; border-left:4px solid #2e7d32; display:flex; align-items:center; gap:10px; font-size:0.85rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- ── NOTIFIKASI ERROR ── --}}
    @if(session('error'))
    <div style="background:#ffebee; color:#c62828; padding:12px 20px; margin:16px 20px; border-radius:12px; border-left:4px solid #c62828; display:flex; align-items:center; gap:10px; font-size:0.85rem;">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- ── STAT BAR ── --}}
    <div style="display:flex; align-items:center; gap:15px; padding:12px 20px; background:#f8fafc; border-bottom:1px solid #e2e8f0; flex-wrap:wrap;">
        <span style="background:white; padding:4px 12px; border-radius:20px; font-size:0.7rem; color:#003366; font-weight:500; display:inline-flex; align-items:center; gap:5px;">
            <i class="fas fa-database"></i> Total: {{ $galeri->total() }}
        </span>
        <span style="background:white; padding:4px 12px; border-radius:20px; font-size:0.7rem; color:#003366; font-weight:500; display:inline-flex; align-items:center; gap:5px;">
            <i class="fas fa-eye"></i> Halaman {{ $galeri->currentPage() }} / {{ $galeri->lastPage() }}
        </span>
    </div>

    {{-- ── TABEL DATA ── --}}
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; min-width:600px;">
            <thead style="background:#f8fafc;">
                <tr>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">No</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Gambar</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Judul</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Kategori</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Lokasi</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Status</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Unggulan</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeri as $key => $item)
                <tr style="border-bottom:1px solid #eef2f6; transition:background 0.2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                    <td style="padding:14px 16px; vertical-align:middle; font-size:0.85rem; color:#64748b;">
                        {{ $key + $galeri->firstItem() }}
                    </td>

                    {{-- Gambar thumbnail --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        @if($item->gambar && file_exists(public_path($item->gambar)))
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}"
                                 style="width:55px; height:55px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0;">
                        @else
                            <div style="width:55px; height:55px; background:#f1f5f9; border-radius:10px;"></div>
                        @endif
                    </td>

                    {{-- Judul --}}
                    <td style="padding:14px 16px; vertical-align:middle; font-size:0.85rem; color:#1e293b;">
                        <strong>{{ Str::limit($item->judul, 35) }}</strong>
                    </td>

                    {{-- Kategori --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; background:#e3f2fd; color:#1565c0; border:1px solid #bbdefb;">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </td>

                    {{-- Lokasi --}}
                    <td style="padding:14px 16px; vertical-align:middle; font-size:0.8rem; color:#64748b; max-width:150px;">
                        {{ $item->lokasi ?? '-' }}
                    </td>

                    {{-- Badge status aktif / nonaktif --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;
                            {{ $item->status
                                ? 'background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7;'
                                : 'background:#ffebee; color:#c62828; border:1px solid #ef9a9a;' }}">
                            <i class="fas fa-circle" style="font-size:0.4rem;"></i>
                            {{ $item->status ? 'Aktif' : 'Tidak' }}
                        </span>
                    </td>

                    {{-- Badge unggulan --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;
                            {{ $item->is_unggulan
                                ? 'background:#ffefc2; color:#b45309; border:1px solid #fcd34d;'
                                : 'background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;' }}">
                            <i class="fas fa-star" style="font-size:0.4rem;"></i>
                            {{ $item->is_unggulan ? 'Unggulan' : 'Biasa' }}
                        </span>
                    </td>

                    {{-- Tombol aksi --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <a href="{{ route('admin.galeri.edit', $item->id) }}"
                               style="background:#fff8e1; color:#f57c00; padding:5px 14px; border-radius:8px; font-size:0.7rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:5px; border:1px solid #ffe082;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus data ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background:#ffebee; color:#d32f2f; padding:5px 14px; border-radius:8px; font-size:0.7rem; font-weight:600; border:1px solid #ffcdd2; display:inline-flex; align-items:center; gap:5px; cursor:pointer;">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:70px 20px; color:#94a3b8; font-size:0.9rem;">
                        <i class="fas fa-images" style="font-size:2.5rem; opacity:0.25; display:block; margin-bottom:12px;"></i>
                        Belum ada data galeri.
                        <br>
                        <a href="{{ route('admin.galeri.create') }}" style="color:#003366; font-weight:600; font-size:0.85rem; margin-top:8px; display:inline-block;">
                            + Tambah sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── PAGINASI ── --}}
    @if($galeri->hasPages())
    <div style="padding:16px 20px; background:#f8fafc; border-top:1px solid #e2e8f0;">
        {{ $galeri->links() }}
    </div>
    @endif

</div>
@endsection