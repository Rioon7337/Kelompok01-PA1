<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    use HasFactory;

    protected $table = 'penginapan';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nama_en',          // [BARU] Nama penginapan versi Inggris
        'deskripsi',
        'deskripsi_en',     // [BARU] Deskripsi penginapan versi Inggris
        'gambar',
        'gambar_tambahan',
        'harga',
        'lokasi',
        'kontak',
        'urutan',
        'status',
    ];

    // =========================================================================
    // ACCESSORS DINAMIS (otomatis memilih bahasa yang aktif)
    // =========================================================================

    /**
     * Mengembalikan nama penginapan sesuai locale aktif.
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

    /** Accessor untuk URL gambar */
    public function getGambarUrlAttribute(): string
    {
        if (! $this->gambar) {
            return asset('image/penginapan/default.jpg');
        }
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        if (file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        if (file_exists(public_path('image/penginapan/' . $this->gambar))) {
            return asset('image/penginapan/' . $this->gambar);
        }
        return asset('image/penginapan/default.jpg');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    /** Scope untuk filter aktif */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}