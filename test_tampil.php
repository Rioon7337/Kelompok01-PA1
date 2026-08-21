<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$foto = DB::table('koleksi_fotos')->where('nama_foto', 'slide1.jpg')->first();

echo "<h1>Test Foto: " . $foto->nama_foto . "</h1>";

if ($foto && $foto->file_foto) {
    echo "<img src='data:image/jpeg;base64," . base64_encode($foto->file_foto) . "' style='max-width: 100%;'>";
    echo "<p>Ukuran: " . round(strlen($foto->file_foto) / 1024 / 1024, 2) . " MB</p>";
} else {
    echo "<p>Foto tidak ditemukan atau BLOB kosong!</p>";
}
?>