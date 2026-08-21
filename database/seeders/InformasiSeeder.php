<?php

namespace Database\Seeders;

use App\Models\Informasi;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Sejarah Danau Toba',
                'konten' => 'Danau Toba adalah danau vulkanik terbesar di dunia yang terbentuk dari letusan supervolcano sekitar 74.000 tahun yang lalu.',
                'gambar' => null,
                'status' => 1,
                'urutan' => 1,
                'views' => 0,
                'geosite' => 'meat',
            ],
            [
                'judul' => 'Geosite Batu Bahisan',
                'konten' => 'Batu Bahisan adalah formasi batuan unik di sekitar Danau Toba yang memiliki nilai geologi tinggi.',
                'gambar' => null,
                'status' => 1,
                'urutan' => 2,
                'views' => 0,
                'geosite' => 'batu_bahisan',
            ],
            [
                'judul' => 'Geosite Liang Sipege',
                'konten' => 'Liang Sipege adalah situs geologi yang menampilkan struktur batuan unik dengan nilai edukasi tinggi.',
                'gambar' => null,
                'status' => 1,
                'urutan' => 3,
                'views' => 0,
                'geosite' => 'liang_sipege',
            ],
        ];

        foreach ($data as $item) {
            Informasi::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }

        $this->command->info('✅ Data informasi berhasil ditambahkan ke tabel informasis!');
    }
}