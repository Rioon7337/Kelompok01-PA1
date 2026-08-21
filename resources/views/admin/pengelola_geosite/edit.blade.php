@extends('layouts.admin')

@section('title', 'Edit Pengelola Geosite')

@section('content')
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

    .card-header h5 i { color: #c6a43b; }

    .card-body { padding: 24px; }

    .mb-3 { margin-bottom: 20px; }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        color: #1e293b;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        font-size: 0.85rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: white;
        color: #1e293b;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #003366;
        box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-text {
        font-size: 0.7rem;
        color: #94a3b8;
        margin-top: 5px;
    }

    .form-text i { margin-right: 4px; }

    .current-photo-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
    }

    .current-photo-wrap img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #003366;
    }

    .current-photo-wrap .avatar-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #003366, #1a4a7a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .current-photo-wrap .photo-info p {
        margin: 0;
        font-size: 0.82rem;
        font-weight: 600;
        color: #1e293b;
    }

    .current-photo-wrap .photo-info span {
        font-size: 0.7rem;
        color: #64748b;
    }

    .form-control-file {
        width: 100%;
        padding: 8px 12px;
        font-size: 0.85rem;
        border: 1.5px dashed #c6a43b;
        border-radius: 10px;
        background: #fffdf4;
        color: #1e293b;
        cursor: pointer;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    .form-control-file:hover {
        border-color: #003366;
        background: #f8fafc;
    }

    .preview-image {
        margin-top: 12px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        display: none;
        border: 3px solid #003366;
    }

    .btn-group-form {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
        color: #1e293b;
    }

    .alert-danger {
        background: #ffebee;
        color: #c62828;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid #c62828;
        font-size: 0.85rem;
    }

    .alert-danger ul { margin: 0; padding-left: 20px; }

    .divider {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: 20px 0;
    }

    @media (max-width: 768px) {
        .card-header { padding: 12px 18px; }
        .card-body { padding: 18px; }
        .btn-primary, .btn-secondary { padding: 8px 18px; font-size: 0.8rem; }
    }
</style>

<div class="card">
    <div class="card-header">
        <h5>
            <i class="fas fa-user-edit"></i>
            Edit Pengelola Geosite
        </h5>
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

        <form action="{{ route('admin.pengelola-geosite.update', $pengelolaGeosite->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama">Nama / Gelar <span style="color:#d32f2f;">*</span></label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pengelolaGeosite->nama) }}" placeholder="Contoh: Kepala Pengelola" required>
            </div>

            <div class="mb-3">
                <label for="jabatan">Jabatan <span style="color:#d32f2f;">*</span></label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan', $pengelolaGeosite->jabatan) }}" placeholder="Contoh: Koordinator Geopark" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi">Deskripsi Singkat <span style="color:#d32f2f;">*</span></label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Jelaskan peran dan tanggung jawab secara singkat..." required>{{ old('deskripsi', $pengelolaGeosite->deskripsi) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="urutan">Nomor Urutan Tampil</label>
                <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', $pengelolaGeosite->urutan) }}" style="max-width: 180px;">
                <div class="form-text"><i class="fas fa-info-circle"></i> Semakin kecil angkanya, semakin awal ditampilkan di halaman publik.</div>
            </div>

            <hr class="divider">

            <div class="mb-3">
                <label>Foto Profil (Opsional)</label>

                @php
                    $words = explode(' ', $pengelolaGeosite->nama);
                    $initials = '';
                    foreach(array_slice($words, 0, 2) as $w) {
                        $initials .= strtoupper(substr($w, 0, 1));
                    }
                @endphp
                <div class="current-photo-wrap">
                    @if($pengelolaGeosite->image)
                        <img src="{{ asset($pengelolaGeosite->image) }}" alt="Foto Saat Ini">
                    @else
                        <div class="avatar-placeholder">{{ $initials }}</div>
                    @endif
                    <div class="photo-info">
                        <p>Foto Saat Ini</p>
                        <span>{{ $pengelolaGeosite->image ? 'Sudah ada foto profil' : 'Menggunakan inisial nama (' . $initials . ')' }}</span>
                    </div>
                </div>

                <input type="file" name="image" id="image" class="form-control-file" accept="image/*" onchange="previewImg(this)">
                <div class="form-text"><i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, GIF. Maks. 2MB.</div>
                <img id="previewImage" class="preview-image" alt="Preview Baru">
            </div>

            <div class="btn-group-form">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.pengelola-geosite.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input) {
        const preview = document.getElementById('previewImage');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
