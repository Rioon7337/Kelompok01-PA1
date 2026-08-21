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
        Schema::table('kontak', function (Blueprint $table) {
            $table->string('jam_operasional')->nullable()->after('email');
            $table->text('map_iframe')->nullable()->after('jam_operasional');
            $table->text('map_lokasi')->nullable()->after('map_iframe');
            $table->text('lokasi_bawah')->nullable()->after('map_lokasi');
            $table->string('social_fb')->nullable()->after('lokasi_bawah');
            $table->string('social_ig')->nullable()->after('social_fb');
            $table->string('social_twitter')->nullable()->after('social_ig');
            $table->string('social_youtube')->nullable()->after('social_twitter');
            $table->string('social_tiktok')->nullable()->after('social_youtube');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontak', function (Blueprint $table) {
            $table->dropColumn([
                'jam_operasional',
                'map_iframe',
                'map_lokasi',
                'lokasi_bawah',
                'social_fb',
                'social_ig',
                'social_twitter',
                'social_youtube',
                'social_tiktok'
            ]);
        });
    }
};
