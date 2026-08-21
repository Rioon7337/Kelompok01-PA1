<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GaleriTableSeeder extends Seeder
{
    public function run()
    {
        $basePath = public_path('image');
        
        if (!File::exists($basePath)) {
            $this->command->error("Folder image tidak ditemukan!");
            return;
        }
        
        // Hapus data lama (opsional)
        DB::table('galeris')->truncate();
        
        // Mapping file ke kategori
        $fileMapping = [
            // Meat (Desa Meat)
            ['file' => 'meat/1.jpg', 'judul' => 'Suasana Desa Meat', 'kategori' => 'meat', 'deskripsi' => 'Keindahan alam Desa Meat'],
            ['file' => 'meat/2.jpg', 'judul' => 'Kegiatan Warga Meat', 'kategori' => 'meat', 'deskripsi' => 'Aktivitas sehari-hari masyarakat'],
            ['file' => 'meat/3.jpg', 'judul' => 'Pemandangan Meat', 'kategori' => 'meat', 'deskripsi' => 'Panorama indah Desa Meat'],
            ['file' => 'meat/4.jpg', 'judul' => 'Budaya Meat', 'kategori' => 'meat', 'deskripsi' => 'Kearifan lokal Desa Meat'],
            ['file' => 'meat/5.jpg', 'judul' => 'Wisata Meat', 'kategori' => 'meat', 'deskripsi' => 'Objek wisata unggulan'],
            ['file' => 'meat/6.jpg', 'judul' => 'Keunikan Meat', 'kategori' => 'meat', 'deskripsi' => 'Spot foto menarik'],
            ['file' => 'meat/7.jpg', 'judul' => 'Persawahan Meat', 'kategori' => 'meat', 'deskripsi' => 'Hamparan sawah hijau'],
            ['file' => 'meat/8.jpg', 'judul' => 'Rumah Adat Meat', 'kategori' => 'meat', 'deskripsi' => 'Arsitektur tradisional Batak'],
            
            // Batu Bahisan
            ['file' => 'batu-bahisan/1.jpg', 'judul' => 'Batu Bahisan Utama', 'kategori' => 'batu-bahisan', 'deskripsi' => 'Formasi batu unik'],
            ['file' => 'batu-bahisan/2.jpg', 'judul' => 'Spot Foto Batu Bahisan', 'kategori' => 'batu-bahisan', 'deskripsi' => 'Lokasi favorit berfoto'],
            ['file' => 'batu-bahisan/3.jpg', 'judul' => 'Panorama Batu Bahisan', 'kategori' => 'batu-bahisan', 'deskripsi' => 'Pemandangan sekitar'],
            
            // Liang Sipege
            ['file' => 'liang-sipege/1.jpg', 'judul' => 'Mulut Gua Liang Sipege', 'kategori' => 'liang-sipege', 'deskripsi' => 'Pintu masuk gua'],
            ['file' => 'liang-sipege/2.jpg', 'judul' => 'Di Dalam Gua', 'kategori' => 'liang-sipege', 'deskripsi' => 'Keindahan stalaktit'],
            ['file' => 'liang-sipege/3.jpg', 'judul' => 'Ekspedisi Liang Sipege', 'kategori' => 'liang-sipege', 'deskripsi' => 'Penjelajahan gua'],
            
            // Slide/Hero (opsional untuk galeri)
            ['file' => 'slide1.jpg', 'judul' => 'Danau Toba 1', 'kategori' => 'meat', 'deskripsi' => 'Keindahan Danau Toba'],
            ['file' => 'slide2.jpg', 'judul' => 'Danau Toba 2', 'kategori' => 'meat', 'deskripsi' => 'Panorama Danau Toba'],
            ['file' => 'slide3.jpg', 'judul' => 'Danau Toba 3', 'kategori' => 'meat', 'deskripsi' => 'Pesona Danau Toba'],
            ['file' => 'slide4.jpg', 'judul' => 'Danau Toba 4', 'kategori' => 'meat', 'deskripsi' => 'Keindahan Alam'],
            ['file' => 'slide5.jpg', 'judul' => 'Danau Toba 5', 'kategori' => 'meat', 'deskripsi' => 'Spot Favorit'],
            
            // Detail destinasi
            ['file' => 'meat-detail.jpg', 'judul' => 'Detail Desa Meat', 'kategori' => 'meat', 'deskripsi' => 'Keunikan Desa Meat'],
            ['file' => 'batu-detail.jpg', 'judul' => 'Detail Batu Bahisan', 'kategori' => 'batu-bahisan', 'deskripsi' => 'Formasi batu eksotis'],
            ['file' => 'liang-detail.jpg', 'judul' => 'Detail Liang Sipege', 'kategori' => 'liang-sipege', 'deskripsi' => 'Keindahan dalam gua'],
            
            // Penginapan
            ['file' => 'penginapan1.jpg', 'judul' => 'Penginapan Mewah', 'kategori' => 'meat', 'deskripsi' => 'Akomodasi nyaman'],
            ['file' => 'penginapan2.jpg', 'judul' => 'Resort Danau Toba', 'kategori' => 'meat', 'deskripsi' => 'Resort bintang 5'],
            ['file' => 'penginapan3.jpg', 'judul' => 'Villa Keluarga', 'kategori' => 'meat', 'deskripsi' => 'Villa untuk keluarga'],
        ];
        
        $count = 0;
        
        foreach ($fileMapping as $data) {
            $fullPath = $basePath . '/' . $data['file'];
            
            // Cek apakah file ada
            if (File::exists($fullPath)) {
                DB::table('galeris')->insert([
                    'judul' => $data['judul'],
                    'slug' => Str::slug($data['judul']) . '-' . uniqid(),
                    'deskripsi' => $data['deskripsi'],
                    'gambar' => 'image/' . $data['file'],
                    'kategori' => $data['kategori'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $count++;
                $this->command->info("✓ " . $data['file']);
            } else {
                $this->command->warn("✗ File tidak ditemukan: " . $data['file']);
            }
        }
        
        $this->command->info("");
        $this->command->info(" SELESAI! Total $count foto masuk database.");
    }
}