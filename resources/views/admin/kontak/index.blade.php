@extends('layouts.admin')

@section('title', 'Pengaturan Kontak')

@section('content')
<div class="card-table">
    <div class="card-header">
        <h5>
            <i class="fas fa-address-card"></i>
            Pengaturan Kontak
        </h5>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="form-container">
        <form action="{{ route('admin.kontak.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <h6 class="section-title"><i class="fas fa-info-circle"></i> Informasi Dasar</h6>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><i class="fas fa-map-marker-alt"></i> Alamat</label>
                    <textarea class="form-control" name="alamat" rows="4">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label><i class="fas fa-phone"></i> Telepon / WhatsApp</label>
                    <input type="text" class="form-control" name="telepon" value="{{ old('telepon', $kontak->telepon ?? '') }}">
                    
                    <label class="mt-3"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $kontak->email ?? '') }}">
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-clock"></i> Jam Operasional</label>
                <textarea class="form-control" name="jam_operasional" rows="2">{{ old('jam_operasional', $kontak->jam_operasional ?? '') }}</textarea>
            </div>
            
            <hr>
            <h6 class="section-title"><i class="fas fa-map-marked-alt"></i> Peta & Lokasi</h6>

            <div class="form-group">
                <label><i class="fas fa-map"></i> Link Google Maps (Embed URL)</label>
                <input type="text" class="form-control" name="map_iframe" value="{{ old('map_iframe', $kontak->map_iframe ?? '') }}">
                <small>Masukkan URL embed Google Maps Anda saja (src dari iframe).</small>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Teks Lokasi (Peta)</label>
                    <textarea class="form-control" name="map_lokasi" rows="2">{{ old('map_lokasi', $kontak->map_lokasi ?? '') }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Teks Lokasi Bawah</label>
                    <textarea class="form-control" name="lokasi_bawah" rows="2">{{ old('lokasi_bawah', $kontak->lokasi_bawah ?? '') }}</textarea>
                </div>
            </div>

            <hr>
            <h6 class="section-title"><i class="fas fa-share-alt"></i> Sosial Media</h6>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Facebook URL</label>
                    <input type="text" class="form-control" name="social_fb" value="{{ old('social_fb', $kontak->social_fb ?? '') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>Instagram URL</label>
                    <input type="text" class="form-control" name="social_ig" value="{{ old('social_ig', $kontak->social_ig ?? '') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>Twitter / X URL</label>
                    <input type="text" class="form-control" name="social_twitter" value="{{ old('social_twitter', $kontak->social_twitter ?? '') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>YouTube URL</label>
                    <input type="text" class="form-control" name="social_youtube" value="{{ old('social_youtube', $kontak->social_youtube ?? '') }}">
                </div>
                <div class="form-group col-md-6">
                    <label>TikTok URL</label>
                    <input type="text" class="form-control" name="social_tiktok" value="{{ old('social_tiktok', $kontak->social_tiktok ?? '') }}">
                </div>
            </div>

            <div class="form-actions text-right mt-4">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .card-table { background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); overflow: hidden; margin-bottom: 30px; }
    .card-header { padding: 18px 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; }
    .card-header h5 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #003366; }
    .card-header h5 i { color: #c6a43b; margin-right: 8px; }
    .form-container { padding: 30px; }
    .section-title { font-weight: 700; color: #003366; margin-bottom: 20px; font-size: 1.05rem; }
    .section-title i { color: #c6a43b; margin-right: 8px; }
    .form-row { display: flex; flex-wrap: wrap; margin-right: -10px; margin-left: -10px; }
    .form-group { padding-right: 10px; padding-left: 10px; margin-bottom: 20px; }
    .col-md-6 { flex: 0 0 50%; max-width: 50%; }
    .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.85rem; color: #1e293b; }
    .form-group label i { color: #c6a43b; margin-right: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: #003366; box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1); }
    textarea.form-control { resize: vertical; min-height: 80px; }
    hr { margin: 30px 0; border: 0; border-top: 1px solid #e2e8f0; }
    .btn-save { background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color: white; padding: 12px 28px; border-radius: 10px; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 8px; }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3); }
    .mt-3 { margin-top: 1rem !important; }
    .mt-4 { margin-top: 1.5rem !important; }
    .text-right { text-align: right; }
    small { font-size: 0.75rem; color: #64748b; margin-top: 5px; display: block; }
    .alert { padding: 12px 16px; border-radius: 10px; margin: 20px 30px 0; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
</style>
@endsection
