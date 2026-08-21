<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wisata', function (Blueprint $table) {
            $table->id('id_wisata');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('nama_wisata');
            $table->enum('tipe_wisata', ['alam', 'budaya', 'sejarah', 'buatan'])->default('alam');
            $table->text('sejarah')->nullable();
            $table->text('deskripsi');
            $table->text('keunikan')->nullable();
            $table->string('lokasi');
            $table->string('gambar')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
            
            // Foreign key ke admin
            $table->foreign('admin_id', 'fk_wisata_admin')
                  ->references('id')->on('admin')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};