@extends('layouts.admin')

@section('title', $config['label'])

@section('content')
<div style="background:white; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.08); overflow:hidden;">

    {{-- ── HEADER KARTU ── --}}
    <div style="display:flex; justify-content:space-between; align-items:center; padding:18px 24px; background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom:1px solid #e2e8f0; flex-wrap:wrap; gap:12px;">
        <h5 style="margin:0; font-size:1.1rem; font-weight:700; color:#003366; display:flex; align-items:center; gap:8px;">
            <i class="fas {{ $config['icon'] }}" style="color:#c6a43b;"></i> {{ $config['label'] }}
            {{-- Indikator jumlah data vs batas maksimal --}}
            <span style="font-size:0.7rem; font-weight:500; color:#64748b; background:#f1f5f9; padding:3px 10px; border-radius:20px;">
                {{ $totalKategori }} / 24 data
            </span>
        </h5>
        @if($totalKategori < 24)
            <a href="{{ route('admin.destination.' . $category . '.create') }}"
               style="background:linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color:white; padding:8px 18px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:0.85rem; font-weight:600;">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        @else
            {{-- Tombol dinonaktifkan saat batas 24 tercapai --}}
            <span style="background:#e2e8f0; color:#94a3b8; padding:8px 18px; border-radius:12px; display:inline-flex; align-items:center; gap:8px; font-size:0.85rem; font-weight:600; cursor:not-allowed;">
                <i class="fas fa-lock"></i> Batas Maksimal Tercapai
            </span>
        @endif
    </div>

    {{-- ── NOTIFIKASI SUKSES ── --}}
    @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:12px 20px; margin:16px 20px; border-radius:12px; border-left:4px solid #2e7d32; display:flex; align-items:center; gap:10px; font-size:0.85rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- ── NOTIFIKASI ERROR (termasuk pesan batas maksimal) ── --}}
    @if($errors->any())
    <div style="background:#ffebee; color:#c62828; padding:12px 20px; margin:16px 20px; border-radius:12px; border-left:4px solid #c62828;">
        @foreach($errors->all() as $error)
            <div style="display:flex; align-items:center; gap:8px; font-size:0.85rem;">
                <i class="fas fa-exclamation-circle"></i> {{ $error }}
            </div>
        @endforeach
    </div>
    @endif



    {{-- ── TABEL DATA ── --}}
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; min-width:600px;">
            <thead style="background:#f8fafc;">
                <tr>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">No</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Gambar</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Judul</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Deskripsi</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Status</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Unggulan</th>
                    <th style="padding:14px 16px; text-align:left; font-weight:700; font-size:0.8rem; color:#003366; border-bottom:2px solid #e2e8f0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr style="border-bottom:1px solid #eef2f6; transition:background 0.2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                    {{-- Nomor urut mempertimbangkan halaman paginator --}}
                    <td style="padding:14px 16px; vertical-align:middle; font-size:0.85rem; color:#64748b;">
                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                    </td>

                    {{-- Gambar thumbnail --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                             style="width:55px; height:55px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0;"
                             onerror="this.onerror=null; this.src='{{ asset('image/default.jpg') }}'">
                    </td>

                    {{-- Judul --}}
                    <td style="padding:14px 16px; vertical-align:middle; font-size:0.85rem; color:#1e293b;">
                        <strong>{{ Str::limit($item->title, 45) }}</strong>
                    </td>

                    {{-- Cuplikan deskripsi --}}
                    <td style="padding:14px 16px; vertical-align:middle; font-size:0.8rem; color:#64748b; max-width:220px;">
                        {{ Str::limit(strip_tags($item->description), 80) }}
                    </td>

                    {{-- Badge status aktif / nonaktif --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;
                            {{ $item->status
                                ? 'background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7;'
                                : 'background:#ffebee; color:#c62828; border:1px solid #ef9a9a;' }}">
                            <i class="fas fa-circle" style="font-size:0.4rem;"></i>
                            {{ $item->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    {{-- Badge unggulan --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <span style="display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:50px; font-size:0.7rem; font-weight:600;
                            {{ $item->is_featured
                                ? 'background:#ffefc2; color:#b45309; border:1px solid #fcd34d;'
                                : 'background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;' }}">
                            <i class="fas fa-star" style="font-size:0.4rem;"></i>
                            {{ $item->is_featured ? 'Unggulan' : 'Biasa' }}
                        </span>
                    </td>

                    {{-- Tombol aksi: Edit + Hapus --}}
                    <td style="padding:14px 16px; vertical-align:middle;">
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <a href="{{ route('admin.destination.' . $category . '.edit', $item->id) }}"
                               style="background:#fff8e1; color:#f57c00; padding:5px 14px; border-radius:8px; font-size:0.7rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:5px; border:1px solid #ffe082;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.destination.' . $category . '.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus destinasi ini? Gambarnya juga akan terhapus.')"
                                  style="display:inline;">
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
                {{-- State kosong --}}
                <tr>
                    <td colspan="6" style="text-align:center; padding:70px 20px; color:#94a3b8; font-size:0.9rem;">
                        <i class="fas {{ $config['icon'] }}" style="font-size:2.5rem; opacity:0.25; display:block; margin-bottom:12px; color:#c6a43b;"></i>
                        Belum ada data {{ $config['label'] }}.
                        @if($totalKategori < 24)
                            <br>
                            <a href="{{ route('admin.destination.' . $category . '.create') }}"
                               style="color:#003366; font-weight:600; font-size:0.85rem; margin-top:8px; display:inline-block;">
                                + Tambah sekarang
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── PAGINASI ── --}}
    @if($data->hasPages())
    <div style="padding:16px 20px; background:#f8fafc; border-top:1px solid #e2e8f0;">
        {{ $data->links() }}
    </div>
    @endif

</div>
@endsection

