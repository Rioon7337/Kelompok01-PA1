<?php

use App\Models\Slider;
use App\Models\PengelolaGeosite;
use Illuminate\Support\Facades\File;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting migration...\n";

// 1. Move folders
$sliderSource = storage_path('app/public/slider');
$sliderDest = public_path('image/slider');
if (file_exists($sliderSource)) {
    if (!file_exists($sliderDest)) {
        File::makeDirectory($sliderDest, 0755, true);
    }
    File::copyDirectory($sliderSource, $sliderDest);
    echo "Copied slider directory.\n";
}

$pengelolaSource = storage_path('app/public/image/pengelola');
$pengelolaDest = public_path('image/pengelola');
if (file_exists($pengelolaSource)) {
    if (!file_exists($pengelolaDest)) {
        File::makeDirectory($pengelolaDest, 0755, true);
    }
    File::copyDirectory($pengelolaSource, $pengelolaDest);
    echo "Copied pengelola directory.\n";
}

// 2. Update DB
$sliders = Slider::all();
foreach ($sliders as $s) {
    if ($s->image_path && !str_starts_with($s->image_path, 'image/')) {
        $s->image_path = 'image/' . ltrim($s->image_path, '/');
        $s->save();
        echo "Updated slider: " . $s->id . "\n";
    }
}

$pengelolas = PengelolaGeosite::all();
foreach ($pengelolas as $p) {
    if ($p->image && !str_starts_with($p->image, 'image/')) {
        $p->image = 'image/' . ltrim($p->image, '/');
        $p->save();
        echo "Updated pengelola: " . $p->id . "\n";
    }
}

// 3. Update Views
$dir = new RecursiveDirectoryIterator(resource_path('views'));
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        // Remove 'storage/' . from asset()
        $newContent = preg_replace('/asset\(\s*\'storage\/\'\s*\.\s*/', 'asset(', $content);
        // Also handle \"/storage/\" just in case
        $newContent = str_replace('asset(\'/storage/\' . ', 'asset(', $newContent);
        
        if ($newContent !== $content) {
            file_put_contents($path, $newContent);
            echo 'Updated blade: ' . $path . "\n";
        }
    }
}

echo "Done.\n";
