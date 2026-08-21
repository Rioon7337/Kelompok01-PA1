<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'judul_en',
        'isi',
        'isi_en',
        'gambar',
        'tanggal_terbit',
        'urutan',
        'status',
    ];

    public function getJudulTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->judul_en)) {
            return $this->judul_en;
        }
        return $this->judul ?? '';
    }

    public function getIsiTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->isi_en)) {
            return $this->isi_en;
        }
        return $this->isi ?? '';
    }

    public function getGambarUrlAttribute(): string
    {
        if (!$this->gambar) {
            return asset('image/default.jpg');
        }
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        if (file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        if (file_exists(public_path('image/pengumuman/' . $this->gambar))) {
            return asset('image/pengumuman/' . $this->gambar);
        }
        return asset('image/default.jpg');
    }
}
