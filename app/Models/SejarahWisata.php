<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SejarahWisata extends Model
{
    use HasFactory;

    protected $table = 'sejarah_wisata';

    protected $fillable = [
        'judul',
        'judul_en',     // [BARU] Judul sejarah wisata versi Inggris
        'slug',
        'geosite',
        'kategori',
        'konten',
        'konten_en',    // [BARU] Konten sejarah wisata versi Inggris
        'gambar',
        'lokasi',
        'penulis',
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

    /** Accessor untuk gambar */
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
        if (file_exists(public_path('image/sejarah/' . $this->gambar))) {
            return asset('image/sejarah/' . $this->gambar);
        }
        return asset('image/default.jpg');
    }

    // =========================================================================
    // MUTATORS
    // =========================================================================

    /** Auto generate slug dari judul */
    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug']  = Str::slug($value) . '-' . time();
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByGeosite($query, $geosite)
    {
        return $query->where('geosite', $geosite);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // =========================================================================
    // HELPERS (Label Geosite & Kategori — otomatis multi-bahasa)
    // =========================================================================

    /** Label geosite yang mendukung dua bahasa */
    public function getGeositeLabelAttribute(): string
    {
        $labels = [
            'balige'        => 'Balige',
            'meat'          => 'Meat',
            'batu-basiha'   => 'Batu Basiha',
            'liang-sipege'  => 'Liang Sipege',
        ];
        return $labels[$this->geosite] ?? $this->geosite;
    }

    /** Label kategori yang mendukung dua bahasa */
    public function getKategoriLabelAttribute(): string
    {
        if (app()->getLocale() === 'en') {
            $labels = [
                'sejarah'   => 'History',
                'legenda'   => 'Legend',
                'budaya'    => 'Culture',
                'informasi' => 'Information',
                'tokoh'     => 'Figures',
            ];
        } else {
            $labels = [
                'sejarah'   => 'Sejarah',
                'legenda'   => 'Legenda',
                'budaya'    => 'Budaya',
                'informasi' => 'Informasi',
                'tokoh'     => 'Tokoh',
            ];
        }
        return $labels[$this->kategori] ?? $this->kategori;
    }
}