@extends('layouts.admin')

@section('title', 'Edit Penginapan')

@section('content')
<style>
    .card {
        background: white; border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;
    }
    .card-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        display: flex; justify-content: space-between;
        align-items: center; flex-wrap: wrap; gap: 12px;
    }
    .card-header h5 {
        margin: 0; font-size: 1.1rem; font-weight: 700;
        color: #003366; display: flex; align-items: center; gap: 8px;
    }
    .card-header h5 i { color: #c6a43b; }
    .card-body { padding: 28px 28px; }
    .mb-3 { margin-bottom: 20px; }
    label {
        display: block; margin-bottom: 8px;
        font-weight: 600; font-size: 0.85rem; color: #1e293b;
    }
    .form-control {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.85rem; color: #1e293b; background: #fafbfc;
        transition: border-color 0.2s; box-sizing: border-box;
    }
    .form-control:focus { outline: none; border-color: #003366; background: white; }
    .form-text { font-size: 0.75rem; color: #64748b; margin-top: 5px; }
    .row { display: flex; gap: 20px; flex-wrap: wrap; }
    .col-half { flex: 1; min-width: 240px; }
    .checkbox-group {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 16px; background: #f0f9ff;
        border: 1px solid #bae6fd; border-radius: 10px; margin-bottom: 20px;
    }
    .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; accent-color: #003366; cursor: pointer; }
    .checkbox-group label { margin: 0; font-size: 0.85rem; font-weight: 600; color: #0369a1; cursor: pointer; }
    .btn-group { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px; }
    .btn-update {
        background: linear-gradient(135deg, #c6a43b, #967a28);
        color: white; padding: 10px 28px; border-radius: 10px;
        font-size: 0.85rem; font-weight: 700; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease;
    }
    .btn-update:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-cancel {
        background: #f1f5f9; color: #64748b; padding: 10px 28px;
        border-radius: 10px; font-size: 0.85rem; font-weight: 600;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        border: 1.5px solid #e2e8f0; transition: all 0.2s ease;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #374151; }
    .preview-image {
        display: none; margin-top: 10px;
        max-width: 200px; border-radius: 10px;
        border: 2px solid #e2e8f0; object-fit: cover;
    }
    .current-image {
        margin-bottom: 10px;
    }
    .current-image img {
        max-width: 200px; max-height: 140px;
        border-radius: 10px; object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    .checkbox-delete {
        display: flex; align-items: center; gap: 8px; margin-bottom: 10px;
    }
    .checkbox-delete label { color: #e74c3c; margin: 0; font-size: 0.8rem; cursor: pointer; }
    .alert-danger {
        background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.83rem;
    }
    .section-divider {
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1px; color: #94a3b8; margin: 8px 0 16px;
        padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;
    }
</style>

<div class="card">
    <div class="card-header">
        <h5>
            <i class="fas fa-edit"></i>
            Edit Penginapan: {{ $data->nama }}
        </h5>
        <a href="{{ route('admin.penginapan.index') }}" class="btn-cancel">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</strong>
                <ul style="margin:6px 0 0 16px;padding:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.penginapan.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Informasi Utama --}}
            <div class="section-divider">Informasi Utama</div>

            <div class="mb-3">
                <label>Nama Penginapan <span style="color:#e74c3c;">*</span></label>
                <input type="text" name="nama" id="penginapan_edit_nama" class="form-control"
                       value="{{ old('nama', $data->nama) }}" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi <span style="color:#e74c3c;">*</span></label>
                <textarea name="deskripsi" id="penginapan_edit_deskripsi" class="form-control"
                          rows="5" required>{{ old('deskripsi', $data->deskripsi) }}</textarea>
            </div>

            {{-- Lokasi & Harga --}}
            <div class="row">
                <div class="col-half">
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control"
                               value="{{ old('lokasi', $data->lokasi) }}" placeholder="Contoh: Desa Meat, Kec. Tampahan">
                    </div>
                </div>
                <div class="col-half">
                    <div class="mb-3">
                        <label>Harga / Keterangan</label>
                        <input type="text" name="harga" class="form-control"
                               value="{{ old('harga', $data->harga) }}" placeholder="Contoh: Rp 150.000 / malam">
                    </div>
                </div>
            </div>

            {{-- Kontak & Urutan --}}
            <div class="row">
                <div class="col-half">
                    <div class="mb-3">
                        <label>Kontak</label>
                        <input type="text" name="kontak" class="form-control"
                               value="{{ old('kontak', $data->kontak) }}" placeholder="Contoh: 081234567890">
                    </div>
                </div>
                <div class="col-half">
                    <div class="mb-3">
                        <label>Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $data->urutan) }}" min="0">
                        <div class="form-text"><i class="fas fa-info-circle"></i> Semakin kecil angka, semakin atas tampilannya.</div>
                    </div>
                </div>
            </div>

            {{-- Gambar --}}
            <div class="section-divider">Foto</div>
            <div class="row">
                {{-- Gambar Utama --}}
                <div class="col-half">
                    <div class="mb-3">
                        <label>Gambar Utama Saat Ini</label>
                        @if($data->gambar && file_exists(public_path($data->gambar)))
                            <div class="current-image">
                                <img src="{{ asset($data->gambar) }}" alt="Gambar Utama">
                            </div>
                            <div class="checkbox-delete">
                                <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1">
                                <label for="hapus_gambar"><i class="fas fa-trash"></i> Hapus gambar ini</label>
                            </div>
                        @else
                            <div class="form-text" style="margin-bottom:8px;">Tidak ada gambar saat ini.</div>
                        @endif
                        <label style="margin-top:8px;">Upload Gambar Baru</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" id="inputGambar">
                        <div class="form-text"><i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP. Maks: 5MB.</div>
                        <img id="previewGambar" class="preview-image" alt="Preview">
                    </div>
                </div>

                {{-- Gambar Tambahan --}}
                <div class="col-half">
                    <div class="mb-3">
                        <label>Gambar Tambahan Saat Ini</label>
                        @if($data->gambar_tambahan && file_exists(public_path($data->gambar_tambahan)))
                            <div class="current-image">
                                <img src="{{ asset($data->gambar_tambahan) }}" alt="Gambar Tambahan">
                            </div>
                            <div class="checkbox-delete">
                                <input type="checkbox" name="hapus_gambar_tambahan" id="hapus_gambar_tambahan" value="1">
                                <label for="hapus_gambar_tambahan"><i class="fas fa-trash"></i> Hapus foto tambahan</label>
                            </div>
                        @else
                            <div class="form-text" style="margin-bottom:8px;">Tidak ada gambar tambahan.</div>
                        @endif
                        <label style="margin-top:8px;">Upload Gambar Tambahan Baru</label>
                        <input type="file" name="gambar_tambahan" class="form-control" accept="image/*" id="inputGambarTambahan">
                        <div class="form-text"><i class="fas fa-info-circle"></i> Foto interior / fasilitas tambahan.</div>
                        <img id="previewGambarTambahan" class="preview-image" alt="Preview">
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="checkbox-group">
                <input type="checkbox" name="status" value="1" id="status_penginapan"
                       {{ old('status', $data->status) ? 'checked' : '' }}>
                <label for="status_penginapan"><i class="fas fa-toggle-on"></i> Aktifkan Penginapan (tampil di halaman pengunjung)</label>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-update">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.penginapan.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewGambar');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) { preview.src = ev.target.result; preview.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else { preview.style.display = 'none'; }
    });

    document.getElementById('inputGambarTambahan').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewGambarTambahan');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) { preview.src = ev.target.result; preview.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else { preview.style.display = 'none'; }
    });
</script>
@endsection
