@extends('layouts.admin')

@section('title', 'Edit Cultural Diversity')

@section('content')
<div style="background:white; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.08); overflow:hidden;">
    <div style="padding:18px 24px; background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom:1px solid #e2e8f0;">
        <h5 style="margin:0; font-size:1.1rem; font-weight:700; color:#003366; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-edit" style="color:#c6a43b;"></i> Edit Cultural Diversity
        </h5>
    </div>
    <div style="padding:24px;">
        @if($errors->any())
        <div style="background:#ffebee; color:#c62828; padding:12px 16px; border-radius:10px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.cultural-diversity.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">Nama <span style="color:#dc2626;">*</span></label>
                <input type="text" name="nama" id="cult_edit_nama" class="form-control" value="{{ old('nama', $data->nama) }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;" required>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">Kategori <span style="color:#dc2626;">*</span></label>
                <select name="kategori" class="form-control" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="tarian" {{ old('kategori', $data->kategori) == 'tarian' ? 'selected' : '' }}>Tarian</option>
                    <option value="musik" {{ old('kategori', $data->kategori) == 'musik' ? 'selected' : '' }}>Musik</option>
                    <option value="upacara" {{ old('kategori', $data->kategori) == 'upacara' ? 'selected' : '' }}>Upacara Adat</option>
                    <option value="kerajinan" {{ old('kategori', $data->kategori) == 'kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                    <option value="kuliner" {{ old('kategori', $data->kategori) == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                </select>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">Deskripsi <span style="color:#dc2626;">*</span></label>
                <textarea name="deskripsi" id="cult_edit_deskripsi" class="form-control" rows="6" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; resize:vertical;" required>{{ old('deskripsi', $data->deskripsi) }}</textarea>
            </div>

            {{-- BLOK TERJEMAHAN BAHASA INGGRIS --}}
<div style="display:flex; flex-wrap:wrap; gap:20px;">
                <div style="flex:1; min-width:200px;">
                    <div style="margin-bottom:20px;">
                        <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $data->lokasi) }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;">
                    </div>
                </div>
                <div style="flex:1; min-width:200px;">
                    <div style="margin-bottom:20px;">
                        <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">Video URL</label>
                        <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $data->video_url) }}" placeholder="https://example.com/video.mp4" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;">
                        <small style="font-size:0.7rem; color:#94a3b8; margin-top:5px; display:block;">Link video (opsional) - mp4, webm, dll</small>
                    </div>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">Gambar</label>
                @if($data->gambar && file_exists(public_path($data->gambar)))
                <div style="margin-top:8px;">
                    <img src="{{ asset($data->gambar) }}" style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:2px solid #c6a43b; padding:2px;">
                </div>
                <div style="display:flex; align-items:center; gap:8px; margin-top:8px;">
                    <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1" style="width:16px; height:16px; cursor:pointer;">
                    <label for="hapus_gambar" style="margin:0; font-weight:normal; color:#dc2626; cursor:pointer;">Hapus gambar ini</label>
                </div>
                @else
                <div style="font-size:0.7rem; color:#94a3b8; margin-top:5px;">Tidak ada gambar</div>
                @endif
                <label style="display:block; margin-top:12px; font-weight:600; font-size:0.85rem; color:#1e293b;">Ganti Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" id="inputGambar" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;">
                <small style="font-size:0.7rem; color:#94a3b8; margin-top:5px; display:block;">Format: JPG, PNG, WEBP. Max: 5MB</small>
                <img id="previewImage" style="max-width:150px; margin-top:10px; display:none; border-radius:10px;">
            </div>

            <div style="display:flex; align-items:center; gap:10px; margin:20px 0;">
                <input type="checkbox" name="status" value="1" id="status" {{ old('status', $data->status) ? 'checked' : '' }} style="width:18px; height:18px; cursor:pointer;">
                <label for="status" style="margin:0; cursor:pointer;">Aktifkan</label>
            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" style="background:linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color:white; padding:10px 24px; border-radius:10px; font-weight:600; border:none; cursor:pointer;">Simpan Perubahan</button>
                <a href="{{ route('admin.cultural-diversity.index') }}" style="background:#f1f5f9; color:#475569; padding:10px 24px; border-radius:10px; font-weight:600; border:none; cursor:pointer; text-decoration:none; display:inline-block;">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewImage');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection

