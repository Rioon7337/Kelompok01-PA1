<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';
    
    protected $fillable = [
        'judul',
        'judul_en',     // [BARU] Judul berita versi Inggris
        'slug',
        'konten',
        'konten_en',    // [BARU] Konten berita versi Inggris
        'gambar',
        'penulis',
        'status',
        'views',
    ];

    // =========================================================================
    // ACCESSORS DINAMIS (otomatis memilih bahasa yang aktif)
    // =========================================================================

    /**
     * Mengembalikan judul sesuai locale aktif.
     * Fallback ke Bahasa Indonesia jika versi Inggris kosong.
     */
    public function getJudulTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->judul_en)) {
            return $this->judul_en;
        }
        return $this->judul ?? '';
    }

    /**
     * Mengembalikan konten sesuai locale aktif.
     */
    public function getKontenTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->konten_en)) {
            return $this->konten_en;
        }
        return $this->konten ?? '';
    }

    // =========================================================================
    // ACCESSOR GAMBAR
    // =========================================================================

    /** Accessor untuk URL gambar */
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
        if (file_exists(public_path('image/berita/' . $this->gambar))) {
            return asset('image/berita/' . $this->gambar);
        }
        return asset('image/default.jpg');
    }
}