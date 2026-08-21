@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>
            <i class="fas fa-plus-circle"></i>
            Tambah Pengumuman Baru
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

        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label>Judul Pengumuman <span class="text-danger">*</span></label>
                <input type="text" id="pengumuman_judul_id" name="judul" class="form-control" value="{{ old('judul') }}" required>
            </div>
            
            <div class="mb-3">
                <label>Isi <span class="text-danger">*</span></label>
                <textarea id="pengumuman_isi_id" name="isi" class="form-control" rows="10" required>{{ old('isi') }}</textarea>

            </div>

            {{-- BLOK TERJEMAHAN BAHASA INGGRIS --}}
<div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" id="inputGambar">
                        <small>Format: JPG, PNG, WEBP. Max: 5MB</small>
                        <img id="previewImage" style="max-width: 150px; margin-top: 10px; display: none; border-radius: 10px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit', now()->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" id="status" {{ old('status', 1) ? 'checked' : '' }}>
                <label for="status"> Publikasikan</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">Batal</a>
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
