@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div style="background:white; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.08); overflow:hidden;">

    {{-- ── HEADER ── --}}
    <div style="padding:18px 24px; background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <h5 style="margin:0; font-size:1.1rem; font-weight:700; color:#003366; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-pencil-alt" style="color:#c6a43b;"></i>
            Edit Galeri
        </h5>
        <a href="{{ route('admin.galeri.index') }}"
           style="background:#f1f5f9; color:#475569; padding:7px 16px; border-radius:10px; font-size:0.82rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="padding:28px;">

        {{-- ── TAMPILKAN SEMUA PESAN ERROR ── --}}
        @if($errors->any())
        <div style="background:#ffebee; color:#c62828; padding:14px 18px; border-radius:12px; margin-bottom:24px; border-left:4px solid #c62828;">
            <strong style="font-size:0.85rem; display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:
            </strong>
            <ul style="margin:0; padding-left:20px; font-size:0.83rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ── FORM EDIT DATA ── --}}
        <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div style="margin-bottom:22px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                    Judul <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" placeholder="Contoh: Pemandangan Danau Toba di Pagi Hari..."
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                       onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                {{-- Kategori --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Kategori <span style="color:#dc2626;">*</span>
                    </label>
                    <select name="kategori"
                            style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s; background:white;"
                            onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Meat" {{ $galeri->kategori == 'Meat' ? 'selected' : '' }}>Meat</option>
                        <option value="Batu Bahisan" {{ $galeri->kategori == 'Batu Bahisan' ? 'selected' : '' }}>Batu Bahisan</option>
                        <option value="Liang Sipege" {{ $galeri->kategori == 'Liang Sipege' ? 'selected' : '' }}>Liang Sipege</option>
                        <option value="Balige" {{ $galeri->kategori == 'Balige' ? 'selected' : '' }}>Balige</option>
                    </select>
                </div>

                {{-- Lokasi --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Lokasi
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $galeri->lokasi) }}" placeholder="Contoh: Pulau Samosir, Danau Toba"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            {{-- Deskripsi --}}
            <div style="margin-bottom:22px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                    Deskripsi <span style="color:#dc2626;">*</span>
                </label>
                <textarea name="deskripsi" placeholder="Jelaskan tentang foto ini..." rows="4"
                          style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s; resize:vertical;"
                          onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'" required>{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                {{-- Gambar --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Gambar
                    </label>
                    @if($galeri->gambar && file_exists(public_path($galeri->gambar)))
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset($galeri->gambar) }}" alt="Current image" style="max-width:120px; height:auto; border-radius:10px; border:2px solid #c6a43b; padding:2px;">
                    </div>
                    @endif
                    <input type="file" name="gambar" id="inputGambar" accept="image/*"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; cursor:pointer;"
                           onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                    <div style="font-size:0.75rem; color:#94a3b8; margin-top:6px;">
                        <i class="fas fa-info-circle"></i> Format: JPG, PNG, WebP. Maks: 10MB
                    </div>
                    <img id="previewImage" style="margin-top:12px; max-width:120px; border-radius:10px; display:none;">
                </div>

                {{-- Tanggal Foto --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Tanggal Foto
                    </label>
                    <input type="date" name="tanggal_foto" value="{{ old('tanggal_foto', $galeri->tanggal_foto) }}"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            {{-- Toggle status aktif --}}
            <div style="display:flex; align-items:center; gap:10px; margin:22px 0; padding:14px 18px; background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0;">
                <input type="checkbox" name="status" value="1" id="status" {{ $galeri->status ? 'checked' : '' }}
                       style="width:18px; height:18px; cursor:pointer; accent-color:#003366;">
                <div>
                    <label for="status" style="margin:0; cursor:pointer; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Aktifkan Galeri
                    </label>
                    <div style="font-size:0.72rem; color:#94a3b8; margin-top:2px;">
                        Jika dicentang, galeri akan ditampilkan di halaman publik.
                    </div>
                </div>
            </div>

            {{-- Toggle unggulan --}}
            <div style="display:flex; align-items:center; gap:10px; margin:0 0 22px 0; padding:14px 18px; background:#fff7ed; border-radius:12px; border:1px solid #f5d0a9;">
                <input type="checkbox" name="is_unggulan" value="1" id="is_unggulan" {{ old('is_unggulan', $galeri->is_unggulan) ? 'checked' : '' }}
                       style="width:18px; height:18px; cursor:pointer; accent-color:#f59e0b;">
                <div>
                    <label for="is_unggulan" style="margin:0; cursor:pointer; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Tandai sebagai Galeri Unggulan
                    </label>
                    <div style="font-size:0.72rem; color:#92400e; margin-top:2px;">
                        Ditampilkan di bagian Galeri Unggulan di halaman utama.
                    </div>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div style="display:flex; gap:12px; margin-top:24px; padding-top:24px; border-top:1px solid #e2e8f0;">
                <button type="submit" style="background:linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color:white; padding:10px 24px; border-radius:12px; font-weight:600; font-size:0.85rem; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
                    <i class="fas fa-check"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.galeri.index') }}" style="background:#f1f5f9; color:#475569; padding:10px 24px; border-radius:12px; font-weight:600; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>

<script>
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewImage = document.getElementById('previewImage');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                previewImage.src = event.target.result;
                previewImage.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
        }
    });
</script>
@endsection