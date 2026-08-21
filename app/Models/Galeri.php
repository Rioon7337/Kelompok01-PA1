<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;
    
    protected $table = 'galeri';
    
    protected $fillable = [
        'judul', 
        'slug', 
        'deskripsi', 
        'gambar', 
        'kategori', 
        'lokasi', 
        'tanggal_foto', 
        'status', 
        'views',
        'is_unggulan'  // <-- tambahan
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_unggulan' => 'boolean'
    ];

    // Accessor untuk URL gambar
    public function getGambarUrlAttribute()
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
        if (file_exists(public_path('image/galeri/' . $this->gambar))) {
            return asset('image/galeri/' . $this->gambar);
        }
        return asset('image/default.jpg');
    }

    // Scope untuk galeri unggulan
    public function scopeUnggulan($query)
    {
        return $query->where('is_unggulan', true)->where('status', true);
    }

    // Auto generate slug
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value) . '-' . time();
    }
}   