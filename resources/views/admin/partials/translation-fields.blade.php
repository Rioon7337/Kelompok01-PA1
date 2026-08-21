<div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:20px; border:1px solid #e2e8f0;">
    <h6 style="margin-top:0; margin-bottom:15px; color:#0f172a; font-weight:700; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-language" style="color:#2563eb;"></i> Terjemahan Bahasa Inggris
    </h6>
    
    <div style="margin-bottom:15px;">
        <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">{{ $labelId ?? 'Nama' }} (English)</label>
        <input type="text" name="{{ $nameId ?? 'nama_en' }}" class="form-control" value="{{ $valueId ?? '' }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px;" readonly>
        <small style="color:#64748b; font-size:0.75rem; margin-top:5px; display:block;">*Terjemahan akan dibuat/diperbarui secara otomatis oleh sistem saat disimpan.</small>
    </div>

    <div style="margin-bottom:15px;">
        <label style="display:block; margin-bottom:8px; font-weight:600; font-size:0.85rem; color:#1e293b;">{{ $labelDesc ?? 'Deskripsi' }} (English)</label>
        <textarea name="{{ $nameDesc ?? 'deskripsi_en' }}" class="form-control" rows="{{ $rowsDesc ?? 6 }}" style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; resize:vertical;" readonly>{{ $valueDesc ?? '' }}</textarea>
        <small style="color:#64748b; font-size:0.75rem; margin-top:5px; display:block;">*Terjemahan akan dibuat/diperbarui secara otomatis oleh sistem saat disimpan.</small>
    </div>
</div>
