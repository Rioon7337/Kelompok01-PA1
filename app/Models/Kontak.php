<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';

    protected $fillable = [
        'alamat',
        'telepon',
        'email',
        'link_maps',
        'embed_maps',
        'jam_operasional',
        'map_iframe',
        'map_lokasi',
        'lokasi_bawah',
        'social_fb',
        'social_ig',
        'social_twitter',
        'social_youtube',
        'social_tiktok'
    ];
}