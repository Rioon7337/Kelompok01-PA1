<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;
    
    protected $table = 'umkm';
    
    protected $fillable = [
        'nama_usaha',
        'nama_usaha_en',    // [BARU] Nama usaha versi Inggris
        'pemilik',
        'alamat',
        'no_telepon',
        'deskripsi',
        'deskripsi_en',     // [BARU] Deskripsi UMKM versi Inggris
        'foto_utama',
        'foto_tambahan',
        'status',
        'urutan',
    ];
    
    protected $casts = [
        'status' => 'string',
    ];

    // =========================================================================
    // ACCESSORS DINAMIS (otomatis memilih bahasa yang aktif)
    // =========================================================================

    /**
     * Mengembalikan nama usaha sesuai locale aktif.
     * Fallback ke Bahasa Indonesia jika versi Inggris kosong.
     */
    public function getNamaUsahaTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->nama_usaha_en)) {
            return $this->nama_usaha_en;
        }
        return $this->nama_usaha ?? '';
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
}