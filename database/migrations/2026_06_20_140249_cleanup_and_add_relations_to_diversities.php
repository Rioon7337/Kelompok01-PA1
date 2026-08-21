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
        // 1. Drop unused tables
        Schema::dropIfExists('informasis');
        Schema::dropIfExists('kategoris');
        Schema::dropIfExists('koleksi_fotos');

        // 2. Add admin_id relations to diversities
        $tables = [
            'biodiversitas',
            'geodiversitas',
            'cultural_diversities'
        ];


        

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                if (!Schema::hasColumn($tableName, 'admin_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->unsignedBigInteger('admin_id')->nullable()->after('id');
                    });
                }
                
                // Add foreign key
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->foreign('admin_id', "fk_{$tableName}_admin")
                          ->references('id')->on('admin')
                          ->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert relations
        $tables = [
            'biodiversitas',
            'geodiversitas',
            'cultural_diversities'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    try {
                        $table->dropForeign("fk_{$tableName}_admin");
                    } catch (\Exception $e) {}
                    
                    if (Schema::hasColumn($tableName, 'admin_id')) {
                        $table->dropColumn('admin_id');
                    }
                });
            }
        }

        // We do not recreate dropped tables in down() as they are considered permanently removed unused data in this context.
    }
};
