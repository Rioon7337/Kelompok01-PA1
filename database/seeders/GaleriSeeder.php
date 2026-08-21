<?php
// database/seeders/GaleriSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        // Data sample untuk Meat
        Galeri::create([
            'judul' => 'Pantai Meat Sunset',
            'kategori' => 'Meat',
            'deskripsi' => 'Pemandangan sunset yang indah di Pantai Meat',
            'gambar' => '/image/meat/galeri/1.jpg',
            'lokasi' => 'Pantai Meat',
            'tanggal_foto' => '2024-01-15',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Rumah Adat Meat',
            'kategori' => 'Meat',
            'deskripsi' => 'Rumah adat Batak khas Meat',
            'gambar' => '/image/meat/galeri/2.jpg',
            'lokasi' => 'Desa Meat',
            'tanggal_foto' => '2024-01-20',
            'status' => true,
        ]);
        
        // Data sample untuk Batu Bahisan
        Galeri::create([
            'judul' => 'Formasi Batu Bahisan',
            'kategori' => 'Batu Bahisan',
            'deskripsi' => 'Formasi batuan unik Batu Bahisan',
            'gambar' => '/image/batu-bahisan/galeri/1.jpg',
            'lokasi' => 'Batu Bahisan',
            'tanggal_foto' => '2024-02-10',
            'status' => true,
        ]);
        
        // Data sample untuk Liang Sipege
        Galeri::create([
            'judul' => 'Mulut Goa Liang Sipege',
            'kategori' => 'Liang Sipege',
            'deskripsi' => 'Pintu masuk Goa Liang Sipege',
            'gambar' => '/image/liang-sipege/galeri/1.jpg',
            'lokasi' => 'Liang Sipege',
            'tanggal_foto' => '2024-03-05',
            'status' => true,
        ]);
    }
}