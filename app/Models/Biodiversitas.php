<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Biodiversitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nama_en',              // [BARU] Nama biodiversitas versi Inggris
        'slug',
        'kategori',
        'deskripsi',
        'deskripsi_en',         // [BARU] Deskripsi biodiversitas versi Inggris
        'lokasi',
        'gambar',
        'status_keberadaan',
        'status',
        'views',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // =========================================================================
    // ACCESSORS DINAMIS (otomatis memilih bahasa yang aktif)
    // =========================================================================

    /**
     * Mengembalikan nama sesuai locale aktif.
     * Fallback ke Bahasa Indonesia jika versi Inggris kosong.
     */
    public function getNamaTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->nama_en)) {
            return $this->nama_en;
        }
        return $this->nama ?? '';
    }

    /**
     * Mengembalikan deskripsi sesuai locale aktif.
     */
    public function getDeskripsiTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->deskripsi_en)) {
            return $this->deskripsi_en;
        }
        return $this->deskripsi ?? '';
    }

    // =========================================================================
    // ACCESSOR GAMBAR
    // =========================================================================

    public function getGambarUrlAttribute(): string
    {
        if (! $this->gambar) {
            return asset('image/default.jpg');
        }
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        if (file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        return asset('image/default.jpg');
    }

    // =========================================================================
    // MUTATORS
    // =========================================================================

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value) . '-' . time();
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}