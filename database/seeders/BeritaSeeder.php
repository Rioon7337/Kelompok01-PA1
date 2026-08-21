<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $berita = [
            [
                'judul' => 'Festival Danau Toba 2024 Siap Digelar',
                'slug' => 'festival-danau-toba-2024',
                'konten' => '<p>Festival Danau Toba tahun 2024 akan digelar pada bulan Juni mendatang. Acara ini akan menampilkan berbagai atraksi budaya, musik tradisional, dan pameran kuliner khas Batak.</p><p>Pengunjung dapat menikmati keindahan Danau Toba sambil menyaksikan berbagai pertunjukan seni yang menarik. Jangan lewatkan kesempatan ini!</p>',
                'gambar' => '/image/toba.jpg',
                'penulis' => 'Admin GeoToba',
                'status' => true,
                'views' => 0
            ],
            [
                'judul' => 'Geopark Danau Toba Resmi Diakui UNESCO',
                'slug' => 'geopark-danau-toba-unesco',
                'konten' => '<p>UNESCO secara resmi mengakui Danau Toba sebagai Global Geopark. Pengakuan ini menjadikan Danau Toba sebagai geopark ke-10 di Indonesia.</p><p>Dengan pengakuan ini, diharapkan pariwisata Danau Toba semakin meningkat dan memberikan manfaat bagi masyarakat sekitar.</p>',
                'gambar' => '/image/balige.jpg',
                'penulis' => 'Admin GeoToba',
                'status' => true,
                'views' => 0
            ],
            [
                'judul' => 'Pembukaan Jalur Tracking Baru di Batu Bahisan',
                'slug' => 'jalur-tracking-batu-bahisan',
                'konten' => '<p>Jalur tracking baru dibuka untuk memudahkan wisatawan menikmati keindahan Batu Bahisan. Jalur ini aman dan dilengkapi dengan spot foto yang menarik.</p><p>Pengunjung kini dapat menikmati pemandangan lebih dekat dengan formasi batuan unik yang ada di Batu Bahisan.</p>',
                'gambar' => '/image/batu.jpg',
                'penulis' => 'Admin GeoToba',
                'status' => true,
                'views' => 0
            ],
        ];

        foreach ($berita as $item) {
            Berita::create($item);
        }
    }
}