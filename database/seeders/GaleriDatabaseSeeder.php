     <?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GaleriDatabaseSeeder extends Seeder
{
    public function run()
    {
        $basePath = public_path('image');
        
        if (!File::exists($basePath)) {
            $this->command->error("Folder image tidak ditemukan!");
            return;
        }
        
        // Kosongkan tabel dulu (opsional)
        DB::table('galeris')->truncate();
        
        $allData = [];
        
        // ==================== 1. FOTO DI FOLDER UTAMA ====================
        $mainFiles = [
            ['file' => 'about-toba.jpg', 'judul' => 'About Danau Toba', 'kategori' => 'about'],
            ['file' => 'batu-bahisan.jpg', 'judul' => 'Batu Bahisan', 'kategori' => 'batu-bahisan'],
            ['file' => 'berita.jpg', 'judul' => 'Berita Geopark', 'kategori' => 'berita'],
            ['file' => 'galeri.jpg', 'judul' => 'Galeri Geopark', 'kategori' => 'galeri'],
            ['file' => 'liang-sipege-hero.jpg', 'judul' => 'Liang Sipege Hero', 'kategori' => 'liang-sipege'],
            ['file' => 'meat-hero.jpg', 'judul' => 'Meat Hero', 'kategori' => 'meat'],
        ];
        
        foreach ($mainFiles as $data) {
            $fullPath = $basePath . '/' . $data['file'];
            if (File::exists($fullPath)) {
                $allData[] = [
                    'judul' => $data['judul'],
                    'deskripsi' => 'Foto ' . $data['kategori'],
                    'gambar' => 'image/' . $data['file'],
                    'kategori' => $data['kategori'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 2. FOTO DI FOLDER galerihome ====================
        $galeriHomePath = $basePath . '/galerihome';
        if (File::exists($galeriHomePath)) {
            $galeriHomeFiles = File::files($galeriHomePath);
            foreach ($galeriHomeFiles as $index => $file) {
                $allData[] = [
                    'judul' => 'Galeri Home ' . ($index + 1),
                    'deskripsi' => 'Foto galeri home ' . ($index + 1),
                    'gambar' => 'image/galerihome/' . $file->getFilename(),
                    'kategori' => 'galeri_home',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 3. FOTO DI FOLDER meat ====================
        $meatPath = $basePath . '/meat';
        if (File::exists($meatPath)) {
            $meatFiles = [
                ['file' => 'batu-detail.jpg', 'judul' => 'Detail Batu Bahisan', 'kategori' => 'batu-bahisan'],
                ['file' => 'liang-detail.jpg', 'judul' => 'Detail Liang Sipege', 'kategori' => 'liang-sipege'],
                ['file' => 'meat-detail.jpg', 'judul' => 'Detail Desa Meat', 'kategori' => 'meat'],
                ['file' => 'slide1.jpg', 'judul' => 'Slide Danau Toba 1', 'kategori' => 'meat'],
                ['file' => 'slide2.jpg', 'judul' => 'Slide Danau Toba 2', 'kategori' => 'meat'],
                ['file' => 'slide3.jpg', 'judul' => 'Slide Danau Toba 3', 'kategori' => 'meat'],
                ['file' => 'slide4.jpg', 'judul' => 'Slide Danau Toba 4', 'kategori' => 'meat'],
                ['file' => 'slide5.jpg', 'judul' => 'Slide Danau Toba 5', 'kategori' => 'meat'],
            ];
            
            foreach ($meatFiles as $data) {
                $fullPath = $meatPath . '/' . $data['file'];
                if (File::exists($fullPath)) {
                    $allData[] = [
                        'judul' => $data['judul'],
                        'deskripsi' => 'Foto ' . $data['kategori'],
                        'gambar' => 'image/meat/' . $data['file'],
                        'kategori' => $data['kategori'],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        
        // ==================== 4. FOTO DI FOLDER meat/galeri ====================
        $galeriMeatPath = $basePath . '/meat/galeri';
        if (File::exists($galeriMeatPath)) {
            $galeriMeatFiles = File::files($galeriMeatPath);
            foreach ($galeriMeatFiles as $index => $file) {
                $allData[] = [
                    'judul' => 'Galeri Meat ' . ($index + 1),
                    'deskripsi' => 'Dokumentasi wisata Desa Meat ' . ($index + 1),
                    'gambar' => 'image/meat/galeri/' . $file->getFilename(),
                    'kategori' => 'meat',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 5. FOTO DI FOLDER meat/meat (penginapan) ====================
        $penginapanPath = $basePath . '/meat/meat';
        if (File::exists($penginapanPath)) {
            $penginapanFiles = File::files($penginapanPath);
            foreach ($penginapanFiles as $index => $file) {
                $allData[] = [
                    'judul' => 'Penginapan Danau Toba ' . ($index + 1),
                    'deskripsi' => 'Akomodasi wisata di sekitar Danau Toba',
                    'gambar' => 'image/meat/meat/' . $file->getFilename(),
                    'kategori' => 'penginapan',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 6. LOGO ====================
        $logoPath = $basePath . '/Logo';
        if (File::exists($logoPath)) {
            $logoFiles = File::files($logoPath);
            foreach ($logoFiles as $index => $file) {
                $allData[] = [
                    'judul' => ($index == 0 ? 'Logo Bank Indonesia' : 'Logo IT Del'),
                    'deskripsi' => 'Logo instansi',
                    'gambar' => 'image/Logo/' . $file->getFilename(),
                    'kategori' => 'logo',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Masukkan semua data ke database
        foreach ($allData as $data) {
            DB::table('galeris')->insert($data);
        }
        
        $this->command->info("");
        $this->command->info("STATISTIK:");
        $this->command->info("   - Total foto masuk database: " . count($allData));
        $this->command->info("");
        $this->command->info("SELESAI!");
        
        // Tampilkan rincian per kategori
        $this->command->info("");
        $this->command->info("RINCIAN PER KATEGORI:");
        
        $kategoris = DB::table('galeris')->select('kategori', DB::raw('count(*) as total'))->groupBy('kategori')->get();
        foreach ($kategoris as $kat) {
            $this->command->info("   - " . $kat->kategori . ": " . $kat->total . " foto");
        }
    }
}