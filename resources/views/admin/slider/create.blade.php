@extends('layouts.admin')

@section('title', 'Tambah Slider')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>
            <i class="fas fa-plus-circle"></i>
            Tambah Slider Beranda
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

        <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label>Judul Utama (Opsional)</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Contoh: Balige • Meat">
                <small class="text-muted">Ditampilkan besar di atas gambar (Opsional)</small>
            </div>
            
            <div class="mb-3">
                <label>Sub Judul (Opsional)</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="Contoh: Batu Basiha • Liang Sipege">
                <small class="text-muted">Ditampilkan sedikit lebih kecil di bawah judul (Opsional)</small>
            </div>

            <div class="mb-3">
                <label>Gambar Slider <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" id="inputGambar" required>
                <small class="text-muted">Format: JPG, PNG, WEBP. Max: 5MB. Resolusi disarankan 1920x1080.</small>
                <img id="previewImage" style="max-width: 300px; margin-top: 15px; display: none; border-radius: 10px; border: 2px solid #e2e8f0;">
            </div>
            
            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
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
        color: #c6753b;
    }
    .card-body {
        padding: 24px;
    }
    .mb-3 {
        margin-bottom: 20px;
    }
    .mb-3 label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: inherit;
    }
    .form-control:focus {
        outline: none;
        border-color: #003366;
        box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
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