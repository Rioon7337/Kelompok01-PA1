@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>
            <i class="fas fa-edit"></i>
            Edit Berita
        </h5>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Judul Berita <span class="text-danger">*</span></label>
                <input type="text" id="berita_judul_id" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}" required>
            </div>
            
            <div class="mb-3">
                <label>Konten <span class="text-danger">*</span></label>
                <textarea id="berita_konten_id" name="konten" class="form-control" rows="10" required>{{ old('konten', $berita->konten) }}</textarea>

            </div>

            {{-- BLOK TERJEMAHAN BAHASA INGGRIS --}}
<div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Gambar Saat Ini</label><br>
                        @if($berita->gambar)
                            @php
                                $imgUrl = asset('image/default.jpg');
                                if (file_exists(public_path($berita->gambar))) {
                                    $imgUrl = asset($berita->gambar);
                                } elseif (file_exists(public_path('image/berita/' . $berita->gambar))) {
                                    $imgUrl = asset('image/berita/' . $berita->gambar);
                                }
                            @endphp
                            <img src="{{ $imgUrl }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
                            <div class="form-check">
                                <input type="checkbox" name="hapus_gambar" value="1" class="form-check-input" id="hapusGambar">
                                <label class="form-check-label text-danger" for="hapusGambar">Hapus gambar ini</label>
                            </div>
                        @else
                            <p class="text-muted">Tidak ada gambar</p>
                        @endif
                        
                        <label style="margin-top: 12px;">Ganti Gambar (Opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" id="inputGambar">
                        <small>Format: JPG, PNG, WEBP. Max: 5MB</small>
                        <img id="previewImage" style="max-width: 150px; margin-top: 10px; display: none; border-radius: 10px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="{{ old('penulis', $berita->penulis) }}">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" id="status" {{ old('status', $berita->status) ? 'checked' : '' }}>
                <label for="status"> Publikasikan</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
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

<style>
    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .card-header {
        padding: 18px 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
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
    }
    .card-body {
        padding: 24px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
    }
    .form-control:focus {
        outline: none;
        border-color: #003366;
        box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
    }
    textarea.form-control {
        resize: vertical;
        min-height: 300px;
    }
    .btn-primary {
        background: #003366;
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
    }
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .alert-danger {
        background: #ffebee;
        color: #c62828;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .card-body { padding: 18px; }
        .row { flex-direction: column; }
    }
</style>
@endsection

