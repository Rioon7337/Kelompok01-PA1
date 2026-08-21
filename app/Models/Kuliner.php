<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    use HasFactory;

    protected $table = 'kuliners';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nama_en',
        'deskripsi',
        'deskripsi_en',
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

    public function getNamaTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->nama_en)) {
            return $this->nama_en;
        }
        return $this->nama ?? '';
    }

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
            return asset('image/kuliner/default.jpg');
        }
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        if (file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        if (file_exists(public_path('image/kuliner/' . $this->gambar))) {
            return asset('image/kuliner/' . $this->gambar);
        }
        return asset('image/kuliner/default.jpg');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
