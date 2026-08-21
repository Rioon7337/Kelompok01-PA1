<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geodiversitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('tipe_geologi'); // batuan, mineral, fosil, formasi
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('usia_geologi')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geodiversitas');
    }
};