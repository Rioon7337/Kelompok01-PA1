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
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('location')->nullable()->after('title');
            $table->string('operational_hours')->nullable()->after('location');
            $table->string('ticket_price')->nullable()->after('operational_hours');
            $table->string('tags')->nullable()->after('ticket_price');
            $table->text('short_description')->nullable()->after('tags');
            $table->string('hero_image_path')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'operational_hours',
                'ticket_price',
                'tags',
                'short_description',
                'hero_image_path'
            ]);
        });
    }
};
