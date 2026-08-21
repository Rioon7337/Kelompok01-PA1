@extends('layouts.admin')

@section('title', 'Tambah ' . $config['label'])

@section('content')
<div style="background:white; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.08); overflow:hidden;">

    {{-- ── HEADER ── --}}
    <div style="padding:18px 24px; background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <h5 style="margin:0; font-size:1.1rem; font-weight:700; color:#003366; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-plus-circle" style="color:#c6a43b;"></i>
            Tambah {{ $config['label'] }}
        </h5>
        <a href="{{ route('admin.destination.' . $category . '.index') }}"
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

        {{-- ── FORM TAMBAH DATA ── --}}
        <form action="{{ route('admin.destination.' . $category . '.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            {{-- Judul --}}
            <div style="margin-bottom:22px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                    Judul <span style="color:#dc2626;">*</span>
                </label>
                <input type="text" name="title"
                       value="{{ old('title') }}"
                       placeholder="Contoh: Pantai Meat, Air Terjun Situmurun..."
                       style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                       onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'"
                       required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                {{-- Lokasi --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Lokasi
                    </label>
                    <input type="text" name="location"
                           value="{{ old('location') }}"
                           placeholder="Contoh: Kec. Tampahan, Kab. Toba Samosir"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                </div>

                {{-- Jam Operasional --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Jam Operasional
                    </label>
                    {{-- Input tersembunyi yang menampung nilai gabungan jam buka & tutup --}}
                    <input type="hidden" name="operational_hours" id="operational_hours_create">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="flex:1;">
                            <label style="display:block; margin-bottom:5px; font-size:0.78rem; color:#64748b;">Jam Buka</label>
                            <input type="time" id="jam_buka_create"
                                   style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                                   onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <span style="color:#64748b; font-weight:600; padding-top:20px;">—</span>
                        <div style="flex:1;">
                            <label style="display:block; margin-bottom:5px; font-size:0.78rem; color:#64748b;">Jam Tutup</label>
                            <input type="time" id="jam_tutup_create"
                                   style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                                   onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                    </div>
                    <p style="font-size:0.75rem; color:#94a3b8; margin-top:6px;">Pilih jam buka dan jam tutup menggunakan time picker di atas.</p>
                </div>
                <script>
                    (function() {
                        function updateOpHours() {
                            var buka  = document.getElementById('jam_buka_create').value;
                            var tutup = document.getElementById('jam_tutup_create').value;
                            var result = '';
                            if (buka && tutup) result = buka + ' - ' + tutup;
                            else if (buka)    result = buka + ' - ';
                            else if (tutup)   result = ' - ' + tutup;
                            document.getElementById('operational_hours_create').value = result;
                        }
                        document.getElementById('jam_buka_create').addEventListener('change', updateOpHours);
                        document.getElementById('jam_tutup_create').addEventListener('change', updateOpHours);
                    })();
                </script>

                {{-- Harga --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Harga
                    </label>
                    <input type="text" name="ticket_price"
                           value="{{ old('ticket_price') }}"
                           placeholder="Contoh: Rp 5.000 per orang"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                </div>

                {{-- Tags --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Tags
                    </label>
                    <input type="text" name="tags"
                           value="{{ old('tags') }}"
                           placeholder="Contoh: Sawah Terasering, Panorama, Spot Foto"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; outline:none; transition:border-color 0.2s;"
                           onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">
                    <small style="font-size:0.72rem; color:#94a3b8; margin-top:5px; display:block;">
                        Pisahkan dengan koma.
                    </small>
                </div>
            </div>

            {{-- Deskripsi Singkat --}}
            <div style="margin-bottom:22px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                    Deskripsi Singkat
                </label>
                <textarea name="short_description" rows="3"
                          placeholder="Tulis ringkasan destinasi yang akan muncul di bawah lokasi..."
                          style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; resize:vertical; outline:none; line-height:1.7; transition:border-color 0.2s;"
                          onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'">{{ old('short_description') }}</textarea>
            </div>


            {{-- Deskripsi --}}
            <div style="margin-bottom:22px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                    Deskripsi <span style="color:#dc2626;">*</span>
                </label>
                <textarea name="description" rows="7"
                          placeholder="Tulis deskripsi lengkap destinasi ini..."
                          style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; resize:vertical; outline:none; line-height:1.7; transition:border-color 0.2s;"
                          onfocus="this.style.borderColor='#003366'" onblur="this.style.borderColor='#e2e8f0'"
                          required>{{ old('description') }}</textarea>
                <small style="font-size:0.72rem; color:#94a3b8; margin-top:5px; display:block;">
                    Tulis deskripsi selengkap mungkin untuk meningkatkan kualitas konten.
                </small>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                {{-- Upload gambar dengan preview --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Gambar Utama / Card <span style="font-size:0.75rem; color:#94a3b8; font-weight:400;">(opsional)</span>
                    </label>
                    <input type="file" name="image" id="inputGambar"
                           accept="image/jpeg,image/png,image/webp"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.85rem;">
                    <small style="font-size:0.72rem; color:#94a3b8; margin-top:5px; display:block;">
                        Gambar yang muncul di samping konten.
                    </small>
                    <div id="previewWrapper" style="display:none; margin-top:12px;">
                        <img id="previewImage"
                             style="max-width:200px; max-height:150px; object-fit:cover; border-radius:10px; border:2px solid #e2e8f0;">
                    </div>
                </div>

                {{-- Upload gambar hero dengan preview --}}
                <div style="margin-bottom:22px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Gambar Hero Header <span style="font-size:0.75rem; color:#94a3b8; font-weight:400;">(opsional)</span>
                    </label>
                    <input type="file" name="hero_image" id="inputHeroGambar"
                           accept="image/jpeg,image/png,image/webp"
                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.85rem;">
                    <small style="font-size:0.72rem; color:#94a3b8; margin-top:5px; display:block;">
                        Gambar latar lebar di bagian paling atas halaman.
                    </small>
                    <div id="previewHeroWrapper" style="display:none; margin-top:12px;">
                        <img id="previewHeroImage"
                             style="max-width:100%; max-height:150px; object-fit:cover; border-radius:10px; border:2px solid #e2e8f0;">
                    </div>
                </div>
            </div>

            {{-- Toggle status aktif --}}
            <div style="display:flex; align-items:center; gap:10px; margin:22px 0; padding:14px 18px; background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0;">
                <input type="checkbox" name="status" value="1" id="status"
                       {{ old('status', 1) ? 'checked' : '' }}
                       style="width:18px; height:18px; cursor:pointer; accent-color:#003366;">
                <div>
                    <label for="status" style="margin:0; cursor:pointer; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Aktifkan destinasi ini
                    </label>
                    <div style="font-size:0.72rem; color:#94a3b8; margin-top:2px;">
                        Jika dicentang, destinasi akan ditampilkan di halaman publik.
                    </div>
                </div>
            </div>

            {{-- Toggle destinasi unggulan --}}
            <div style="display:flex; align-items:center; gap:10px; margin:0 0 22px 0; padding:14px 18px; background:#fff7ed; border-radius:12px; border:1px solid #f5d0a9;">
                <input type="checkbox" name="is_featured" value="1" id="is_featured"
                       {{ old('is_featured') ? 'checked' : '' }}
                       style="width:18px; height:18px; cursor:pointer; accent-color:#f59e0b;">
                <div>
                    <label for="is_featured" style="margin:0; cursor:pointer; font-weight:600; font-size:0.85rem; color:#1e293b;">
                        Tandai sebagai Destinasi Unggulan
                    </label>
                    <div style="font-size:0.72rem; color:#92400e; margin-top:2px;">
                        Ditampilkan di halaman utama sebagai destinasi rekomendasi.
                    </div>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div style="display:flex; gap:12px; margin-top:28px; padding-top:20px; border-top:1px solid #f1f5f9;">
                <button type="submit"
                        style="background:linear-gradient(135deg, #003366 0%, #1a4a7a 100%); color:white; padding:11px 28px; border-radius:10px; font-weight:700; border:none; cursor:pointer; font-size:0.88rem; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
                <a href="{{ route('admin.destination.' . $category . '.index') }}"
                   style="background:#f1f5f9; color:#475569; padding:11px 24px; border-radius:10px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:0.88rem;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Script preview gambar sebelum upload --}}
<script>
    document.getElementById('inputGambar').addEventListener('change', function (e) {
        const file    = e.target.files[0];
        const preview = document.getElementById('previewImage');
        const wrapper = document.getElementById('previewWrapper');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src       = event.target.result;
                wrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            wrapper.style.display = 'none';
        }
    });

    document.getElementById('inputHeroGambar').addEventListener('change', function (e) {
        const file    = e.target.files[0];
        const preview = document.getElementById('previewHeroImage');
        const wrapper = document.getElementById('previewHeroWrapper');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src       = event.target.result;
                wrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            wrapper.style.display = 'none';
        }
    });
</script>
@endsection
