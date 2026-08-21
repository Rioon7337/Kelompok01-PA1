<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi untuk tabel destinations.
 * Menyimpan data destinasi wisata (Alam, Buatan, Budaya) dalam satu tabel
 * yang ternormalisasi menggunakan kolom 'category' sebagai pembeda.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();

            // Kategori destinasi: hanya boleh diisi dengan tiga nilai yang sudah ditentukan
            $table->enum('category', ['alam', 'buatan', 'budaya']);

            // Judul destinasi (wajib diisi)
            $table->string('title');

            // Deskripsi lengkap destinasi (tipe TEXT untuk mendukung konten panjang)
            $table->text('description');

            // Path gambar yang disimpan relatif terhadap direktori public/image/destinations/
            $table->string('image_path')->nullable();

            // Status aktif/nonaktif untuk kontrol visibilitas di frontend
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
