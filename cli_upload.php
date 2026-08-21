<?php
// cli_upload.php - Upload foto via CLI/terminal

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "========================================\n";
echo "     UPLOAD FOTO KE DATABASE (CLI)\n";
echo "========================================\n\n";

// Folder tempat foto
$folder = __DIR__ . '/public/image/meat/';

// Buat folder jika belum ada
if (!File::exists($folder)) {
    File::makeDirectory($folder, 0755, true);
    echo "📁 Folder created: $folder\n\n";
}

// Daftar file yang diperlukan
$files = [
    'slide1.jpg',
    'slide2.jpg',
    'slide3.jpg',
    'slide4.jpg',
    'slide5.jpg',
    'meat-detail.jpg',
    'batu-detail.jpg',
    'liang-detail.jpg',
    'berita.jpg',
    '1.jpg',
    '2.jpg',
    '3.jpg',
    '4.jpg',
    '5.jpg',
    '6.jpg',
    '7.jpg',
    '8.jpg',
    'batu-bahisan.jpg',
     'del.jpg',
     'galeri.jpg',
     'gallery1.jpg',
        'gallery2.jpg',
        'gallery3.jpg',
        'gallery4.jpg',
        'logobankindonesia.jpg',
        'meat-hero.jpg'
];

echo "📁 Folder: $folder\n\n";

$success = 0;
$failed = 0;

foreach ($files as $file) {
    $filePath = $folder . $file;
    
    if (File::exists($filePath)) {
        $content = File::get($filePath);
        $size = round(strlen($content) / 1024 / 1024, 2);
        
        $existing = DB::table('koleksi_fotos')->where('nama_foto', $file)->first();
        
        if ($existing) {
            DB::table('koleksi_fotos')->where('nama_foto', $file)->update([
                'file_foto' => $content,
                'updated_at' => now(),
            ]);
            echo "🔄 UPDATE: $file ($size MB)\n";
        } else {
            DB::table('koleksi_fotos')->insert([
                'nama_foto' => $file,
                'file_foto' => $content,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "✅ INSERT: $file ($size MB)\n";
        }
        $success++;
    } else {
        echo "❌ FILE NOT FOUND: $file\n";
        echo "   Letakkan file di: $filePath\n";
        $failed++;
    }
}

echo "\n========================================\n";
echo "HASIL:\n";
echo "✅ Berhasil: $success foto\n";
echo "❌ Gagal: $failed foto\n";
echo "📊 Total database: " . DB::table('koleksi_fotos')->count() . " foto\n";
echo "========================================\n";