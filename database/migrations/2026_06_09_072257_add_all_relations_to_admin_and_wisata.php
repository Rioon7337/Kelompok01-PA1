<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Daftar tabel yang akan ditambahi relasi
        $tables = [
            'beritas',
            'informasis', 
            'galeri',
            'umkm',
            'fasilitas',
            'penginapan',
            'kontak'
        ];
        
        // ==================== 1. TAMBAH KOLOM admin_id DAN wisata_id ====================
        
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                // Tambah kolom admin_id
                if (!Schema::hasColumn($tableName, 'admin_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->unsignedBigInteger('admin_id')->nullable()->after('id');
                    });
                }
                
                // Tambah kolom wisata_id
                if (!Schema::hasColumn($tableName, 'wisata_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->unsignedBigInteger('wisata_id')->nullable()->after('admin_id');
                    });
                }
            }
        }
        
        // Koleksi_fotos (tabel terpisah)
        if (Schema::hasTable('koleksi_fotos')) {
            if (!Schema::hasColumn('koleksi_fotos', 'admin_id')) {
                Schema::table('koleksi_fotos', function (Blueprint $table) {
                    $table->unsignedBigInteger('admin_id')->nullable()->after('id');
                });
            }
            
            if (!Schema::hasColumn('koleksi_fotos', 'wisata_id')) {
                Schema::table('koleksi_fotos', function (Blueprint $table) {
                    $table->unsignedBigInteger('wisata_id')->nullable()->after('admin_id');
                });
            }
        }
        
        // ==================== 2. BUAT FOREIGN KEY KE ADMIN ====================
        
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'admin_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->foreign('admin_id', "fk_{$tableName}_admin")
                          ->references('id')->on('admin')
                          ->onDelete('set null');
                });
            }
        }
        
        // Koleksi_fotos ke Admin
        if (Schema::hasTable('koleksi_fotos') && Schema::hasColumn('koleksi_fotos', 'admin_id')) {
            Schema::table('koleksi_fotos', function (Blueprint $table) {
                $table->foreign('admin_id', 'fk_koleksifotos_admin')
                      ->references('id')->on('admin')
                      ->onDelete('set null');
            });
        }
        
        // ==================== 3. BUAT FOREIGN KEY KE WISATA ====================
        
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'wisata_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->foreign('wisata_id', "fk_{$tableName}_wisata")
                          ->references('id_wisata')->on('wisata')
                          ->onDelete('set null');
                });
            }
        }
        
        // Koleksi_fotos ke Wisata
        if (Schema::hasTable('koleksi_fotos') && Schema::hasColumn('koleksi_fotos', 'wisata_id')) {
            Schema::table('koleksi_fotos', function (Blueprint $table) {
                $table->foreign('wisata_id', 'fk_koleksifotos_wisata')
                      ->references('id_wisata')->on('wisata')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        $tables = ['beritas', 'informasis', 'galeri', 'umkm', 'fasilitas', 'penginapan', 'kontak', 'koleksi_fotos'];
        
        // Hapus semua foreign key
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    try {
                        $table->dropForeign("fk_{$tableName}_admin");
                    } catch (\Exception $e) {}
                    
                    try {
                        $table->dropForeign("fk_{$tableName}_wisata");
                    } catch (\Exception $e) {}
                });
            }
        }
        
        // Hapus kolom admin_id dan wisata_id
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                if (Schema::hasColumn($tableName, 'admin_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->dropColumn('admin_id');
                    });
                }
                
                if (Schema::hasColumn($tableName, 'wisata_id')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->dropColumn('wisata_id');
                    });
                }
            }
        }
    }
};