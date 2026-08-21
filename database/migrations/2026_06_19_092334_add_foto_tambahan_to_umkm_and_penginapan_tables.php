<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->string('foto_tambahan')->nullable()->after('foto_utama');
        });

        Schema::table('penginapan', function (Blueprint $table) {
            $table->string('gambar_tambahan')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn('foto_tambahan');
        });

        Schema::table('penginapan', function (Blueprint $table) {
            $table->dropColumn('gambar_tambahan');
        });
    }
};
