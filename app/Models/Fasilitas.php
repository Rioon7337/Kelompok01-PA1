<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;
    
    protected $table = 'fasilitas';
    
    protected $fillable = [
        'nama',
        'nama_en',          // [BARU] Nama fasilitas versi Inggris
        'jenis',
        'deskripsi',
        'deskripsi_en',     // [BARU] Deskripsi fasilitas versi Inggris
        'harga',
        'lokasi',
        'kontak',
        'urutan',
        'status',
        'gambar',
    ];
    
    protected $casts = [
        'status' => 'boolean',
    ];

    // =========================================================================
    // ACCESSORS DINAMIS (otomatis memilih bahasa yang aktif)
    // =========================================================================

    /**
     * Mengembalikan nama fasilitas sesuai locale aktif.
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

    /** Accessor untuk mendapatkan URL gambar */
    public function getGambarUrlAttribute(): string
    {
        if (empty($this->gambar)) {
            return asset('image/fasilitas/default.jpg');
        }
        if (str_starts_with($this->gambar, 'data:image')) {
            return $this->gambar;
        }
        if (str_starts_with($this->gambar, 'http')) {
            return $this->gambar;
        }
        if (str_starts_with($this->gambar, 'storage/')) {
            return asset($this->gambar);
        }
        if (file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        return asset('image/fasilitas/default.jpg');
    }
}