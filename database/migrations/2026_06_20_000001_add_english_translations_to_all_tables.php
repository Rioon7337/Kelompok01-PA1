<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi untuk menambahkan kolom terjemahan Bahasa Inggris (_en)
 * ke semua tabel yang memiliki konten dinamis yang perlu diterjemahkan.
 *
 * Pendekatan: menambah kolom terpisah per bahasa (paling aman untuk data yang sudah ada).
 * Semua kolom bersifat nullable agar data lama tidak rusak.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi: tambah kolom _en ke semua tabel.
     */
    public function up(): void
    {
        // ─────────────────────────────────────────────────────────
        // TABEL: wisata
        // ─────────────────────────────────────────────────────────
        Schema::table('wisata', function (Blueprint $table) {
            $table->string('nama_wisata_en')->nullable()->after('nama_wisata')
                  ->comment('Nama wisata dalam Bahasa Inggris');
            $table->text('sejarah_en')->nullable()->after('sejarah')
                  ->comment('Sejarah dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi dalam Bahasa Inggris');
            $table->text('keunikan_en')->nullable()->after('keunikan')
                  ->comment('Keunikan dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: beritas
        // ─────────────────────────────────────────────────────────
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul')
                  ->comment('Judul berita dalam Bahasa Inggris');
            $table->longText('konten_en')->nullable()->after('konten')
                  ->comment('Konten berita dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: informasis
        // ─────────────────────────────────────────────────────────
        Schema::table('informasis', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul')
                  ->comment('Judul informasi dalam Bahasa Inggris');
            $table->longText('konten_en')->nullable()->after('konten')
                  ->comment('Konten informasi dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: umkm
        // ─────────────────────────────────────────────────────────
        Schema::table('umkm', function (Blueprint $table) {
            $table->string('nama_usaha_en')->nullable()->after('nama_usaha')
                  ->comment('Nama usaha dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi UMKM dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: penginapan
        // ─────────────────────────────────────────────────────────
        Schema::table('penginapan', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama')
                  ->comment('Nama penginapan dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi penginapan dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: fasilitas
        // ─────────────────────────────────────────────────────────
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama')
                  ->comment('Nama fasilitas dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi fasilitas dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: biodiversitas
        // ─────────────────────────────────────────────────────────
        Schema::table('biodiversitas', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama')
                  ->comment('Nama biodiversitas dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi biodiversitas dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: geodiversitas
        // ─────────────────────────────────────────────────────────
        Schema::table('geodiversitas', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama')
                  ->comment('Nama geodiversitas dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi geodiversitas dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: cultural_diversities
        // ─────────────────────────────────────────────────────────
        Schema::table('cultural_diversities', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama')
                  ->comment('Nama cultural diversity dalam Bahasa Inggris');
            $table->text('deskripsi_en')->nullable()->after('deskripsi')
                  ->comment('Deskripsi cultural diversity dalam Bahasa Inggris');
        });

        // ─────────────────────────────────────────────────────────
        // TABEL: sejarah_wisata
        // ─────────────────────────────────────────────────────────
        Schema::table('sejarah_wisata', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul')
                  ->comment('Judul sejarah wisata dalam Bahasa Inggris');
            $table->longText('konten_en')->nullable()->after('konten')
                  ->comment('Konten sejarah wisata dalam Bahasa Inggris');
        });
    }

    /**
     * Batalkan migrasi: hapus kolom _en dari semua tabel.
     */
    public function down(): void
    {
        Schema::table('wisata', function (Blueprint $table) {
            $table->dropColumn(['nama_wisata_en', 'sejarah_en', 'deskripsi_en', 'keunikan_en']);
        });

        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['judul_en', 'konten_en']);
        });

        Schema::table('informasis', function (Blueprint $table) {
            $table->dropColumn(['judul_en', 'konten_en']);
        });

        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn(['nama_usaha_en', 'deskripsi_en']);
        });

        Schema::table('penginapan', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('fasilitas', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('biodiversitas', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('geodiversitas', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('cultural_diversities', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('sejarah_wisata', function (Blueprint $table) {
            $table->dropColumn(['judul_en', 'konten_en']);
        });
    }
};
