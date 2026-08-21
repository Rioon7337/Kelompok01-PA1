<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sejarah_wisata', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('geosite', ['balige', 'meat', 'batu-basiha', 'liang-sipege']);
            $table->enum('kategori', ['sejarah', 'legenda', 'budaya', 'informasi', 'tokoh']);
            $table->longText('konten');
            $table->string('gambar')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penulis')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sejarah_wisata');
    }
};