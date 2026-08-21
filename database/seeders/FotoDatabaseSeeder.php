<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FotoDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Path utama folder image kamu
        $path = public_path('image');

        if (File::exists($path)) {
            // allFiles akan mengambil SEMUA file di dalam folder image 
            // termasuk di dalam sub-folder (meat, galerihome, logo, dll)
            $files = File::allFiles($path);

            foreach ($files as $file) {
                // Kita hanya ambil file gambar saja
                $extension = strtolower($file->getExtension());
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    
                    DB::table('koleksi_fotos')->insert([
                        'nama_foto' => $file->getFilename(),
                        'file_foto' => file_get_contents($file->getRealPath()),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $this->command->info('Mantap! Semua foto dari berbagai folder sudah masuk ke database.');
        } else {
            $this->command->error('Folder public/image tidak ditemukan!');
        }
    }
}