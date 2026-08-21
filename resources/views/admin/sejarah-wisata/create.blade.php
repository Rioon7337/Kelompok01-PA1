@extends('layouts.admin')

@section('title', 'Tambah Sejarah Wisata')

@section('content')
<style>
    .card { background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); overflow: hidden; }
    .card-header { padding: 18px 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; }
    .card-header h5 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #003366; display: flex; align-items: center; gap: 8px; }
    .card-header h5 i { color: #c6a43b; }
    .card-body { padding: 24px; }
    .mb-3 { margin-bottom: 20px; }
    label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.85rem; color: #1e293b; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.85rem; transition: all 0.3s ease; }
    .form-control:focus { outline: none; border-color: #003366; box-shadow: 0 0 0 3px rgba(0,51,102,0.1); }
    textarea.form-control { resize: vertical; min-height: 200px; }
    .row { display: flex; flex-wrap: wrap; gap: 20px; }
    .col-half { flex: 1; min-width: 200px; }
    .preview-image { margin-top: 10px; max-width: 150px; border-radius: 10px; display: none; }
    .checkbox-group { display: flex; align-items: center; gap: 10px; margin: 20px 0; }
    .checkbox-group input { width: 18px; height: 18px; cursor: pointer; }
    .checkbox-group label { margin: 0; cursor: pointer; }
    .btn-group { display: flex; gap: 12px; margin-top: 24px; }
    .btn-save { background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color: white; padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; transition: all 0.3s ease; }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,51,102,0.3); }
    .btn-cancel { background: #f1f5f9; color: #475569; padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s ease; }
    .btn-cancel:hover { background: #e2e8f0; transform: translateY(-2px); }
    .alert-danger { background: #ffebee; color: #c62828; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #c62828; font-size: 0.85rem; }
    .alert-danger ul { margin: 0; padding-left: 20px; }
    .form-text { font-size: 0.7rem; color: #94a3b8; margin-top: 5px; }
    .form-text i { margin-right: 4px; }
    @media (max-width: 768px) { .card-header { padding: 12px 18px; } .card-body { padding: 18px; } .row { flex-direction: column; gap: 0; } .btn-save, .btn-cancel { padding: 8px 18px; font-size: 0.8rem; } }
</style>

<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-plus-circle"></i> Tambah Sejarah Wisata</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.sejarah-wisata.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" id="sejarah_create_judul" class="form-control" value="{{ old('judul') }}" placeholder="Masukkan judul" required>
            </div>

            <div class="row">
                <div class="col-half">
                    <div class="mb-3">
                        <label>Geosite <span class="text-danger">*</span></label>
                        <select name="geosite" class="form-control" required>
                            <option value="">-- Pilih Geosite --</option>
                            <option value="balige" {{ old('geosite') == 'balige' ? 'selected' : '' }}>Balige</option>
                            <option value="meat" {{ old('geosite') == 'meat' ? 'selected' : '' }}>Meat</option>
                            <option value="batu-basiha" {{ old('geosite') == 'batu-basiha' ? 'selected' : '' }}>Batu Basiha</option>
                            <option value="liang-sipege" {{ old('geosite') == 'liang-sipege' ? 'selected' : '' }}>Liang Sipege</option>
                        </select>
                    </div>
                </div>
                <div class="col-half">
                    <div class="mb-3">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="sejarah" {{ old('kategori') == 'sejarah' ? 'selected' : '' }}>Sejarah</option>
                            <option value="legenda" {{ old('kategori') == 'legenda' ? 'selected' : '' }}>Legenda</option>
                            <option value="budaya" {{ old('kategori') == 'budaya' ? 'selected' : '' }}>Budaya</option>
                            <option value="informasi" {{ old('kategori') == 'informasi' ? 'selected' : '' }}>Informasi</option>
                            <option value="tokoh" {{ old('kategori') == 'tokoh' ? 'selected' : '' }}>Tokoh</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label>Konten <span class="text-danger">*</span></label>
                <textarea name="konten" id="sejarah_create_konten" class="form-control" rows="8" required>{{ old('konten') }}</textarea>

            </div>

            {{-- BLOK TERJEMAHAN BAHASA INGGRIS --}}
<div class="row">
                <div class="col-half">
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', 'Balige') }}" placeholder="Contoh: Balige, Sumatera Utara">
                    </div>
                </div>
                <div class="col-half">
                    <div class="mb-3">
                        <label>Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="{{ old('penulis', 'Admin') }}" placeholder="Nama penulis">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" id="inputGambar">
                <div class="form-text"><i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP. Max: 5MB</div>
                <img id="previewImage" class="preview-image">
            </div>

            <div class="checkbox-group">
                <input type="checkbox" name="status" value="1" id="status" {{ old('status', 1) ? 'checked' : '' }}>
                <label for="status">Aktifkan</label>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save">Simpan</button>
                <a href="{{ route('admin.sejarah-wisata.index') }}" class="btn-cancel">Batal</a>
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
