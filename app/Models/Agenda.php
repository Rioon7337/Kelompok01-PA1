<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';

    protected $fillable = [
        'judul',
        'judul_en',
        'deskripsi',
        'deskripsi_en',
        'gambar',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'penyelenggara',
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

    public function getDeskripsiTransAttribute(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->deskripsi_en)) {
            return $this->deskripsi_en;
        }
        return $this->deskripsi ?? '';
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
        if (file_exists(public_path('image/agenda/' . $this->gambar))) {
            return asset('image/agenda/' . $this->gambar);
        }
        return asset('image/default.jpg');
    }
}
