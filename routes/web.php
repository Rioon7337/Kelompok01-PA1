<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminGaleriController;
use App\Http\Controllers\Admin\AdminBeritaController;

use App\Http\Controllers\Admin\AdminUmkmController;
use App\Http\Controllers\Admin\AdminFasilitasController;
use App\Http\Controllers\Admin\AdminPenginapanController;
use App\Http\Controllers\Admin\AdminKulinerController;
use App\Http\Controllers\Admin\AdminAgendaController;
use App\Http\Controllers\Admin\AdminPengumumanController;


use App\Http\Controllers\Admin\AdminDestinationController;
use App\Http\Controllers\Admin\AdminPengelolaGeositeController;
use App\Http\Controllers\PublicDestinasiController;
use App\Http\Controllers\PublicDestinationController;
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\Admin\AdminKontakController;
use App\Http\Controllers\PublicGaleriController;
use App\Http\Controllers\PublicGeositeController;

use App\Http\Controllers\Admin\AdminSejarahWisataController;
use App\Http\Controllers\PublicSearchController;
use App\Http\Controllers\PublicTentangGeositeController;
use App\Http\Controllers\PublicBiodiversitasController;
use App\Http\Controllers\PublicGeodiversitasController;
use App\Http\Controllers\PublicCulturalDiversityController;
use App\Http\Controllers\PublicFasilitasUtamaController;
use App\Http\Controllers\PublicBeritaController;
use Illuminate\Support\Facades\DB;

// ========================================
// ========== FRONTEND ROUTES (PUBLIC) ==========
// ========================================
use App\Http\Controllers\PublicKontakController;

Route::get('/kontak', [PublicKontakController::class, 'index'])->name('kontak');
Route::post('/kontak/kirim', [PublicKontakController::class, 'kirim'])->name('kontak.kirim');

Route::get('/', [PublicHomeController::class, 'index'])->name('home');

// ========================================
// ========== GLOBAL SEARCH ==========
// ========================================
Route::get('/search', [PublicSearchController::class, 'search'])->name('search');
Route::get('/search-results', [PublicSearchController::class, 'searchResults'])->name('search.results');

// ========================================
// ========== TENTANG GEOSITE ==========
// ========================================
Route::get('/tentang-geosite', [PublicTentangGeositeController::class, 'index'])->name('tentang-geosite');

// ========================================
// ========== DESTINASI (PUBLIC) ==========
// ========================================
Route::get('/destinasi', [PublicDestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/alam', [PublicDestinationController::class, 'alam'])->name('destinasi.alam');
Route::get('/destinasi/buatan', [PublicDestinationController::class, 'buatan'])->name('destinasi.buatan');
Route::get('/destinasi/budaya', [PublicDestinationController::class, 'budaya'])->name('destinasi.budaya');
Route::get('/destinasi/{category}/{id}', [PublicDestinationController::class, 'show'])->name('destinasi.detail');

// ========================================
// ========== DIVERSITY ==========
// ========================================

// BIODIVERSITAS
Route::get('/biodiversitas', [PublicBiodiversitasController::class, 'index'])->name('biodiversitas');
Route::get('/biodiversitas/{slug}', [PublicBiodiversitasController::class, 'show'])->name('biodiversitas.detail');
Route::get('/biodiversitas/kategori/{kategori}', [PublicBiodiversitasController::class, 'kategori'])->name('biodiversitas.kategori');

// GEODIVERSITAS
Route::get('/geodiversitas', [PublicGeodiversitasController::class, 'index'])->name('geodiversitas');
Route::get('/geodiversitas/{slug}', [PublicGeodiversitasController::class, 'show'])->name('geodiversitas.detail');

// CULTURAL DIVERSITY
Route::get('/cultural-diversity', [PublicCulturalDiversityController::class, 'index'])->name('cultural-diversity');
Route::get('/cultural-diversity/{slug}', [PublicCulturalDiversityController::class, 'show'])->name('cultural-diversity.detail');

// ========================================
// ========== BERITA & INFORMASI ==========
// ========================================

// Portal Utama Berita & Informasi
Route::get('/berita', [PublicBeritaController::class, 'index'])->name('berita');

// Sub-menu: Berita Terkini
Route::get('/berita/terkini', [PublicBeritaController::class, 'terkini'])->name('berita.terkini');
Route::get('/berita/{slug}', [PublicBeritaController::class, 'detail'])->name('berita.detail');

// Sub-menu: Agenda & Event
Route::get('/agenda', [PublicBeritaController::class, 'agenda'])->name('agenda.index');
Route::get('/agenda/{id}', [PublicBeritaController::class, 'agendaDetail'])->name('agenda.detail');

// Sub-menu: Pengumuman
Route::get('/pengumuman', [PublicBeritaController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PublicBeritaController::class, 'pengumumanDetail'])->name('pengumuman.detail');

// ========================================
// ========== FASILITAS ==========
// ========================================

// Halaman Utama Fasilitas
Route::get('/fasilitas', [PublicFasilitasUtamaController::class, 'index'])->name('fasilitas.index');
Route::get('/fasilitas/kategori/{jenis}', [PublicFasilitasUtamaController::class, 'kategori'])->name('fasilitas.kategori');
Route::get('/fasilitas/detail/{id}', [PublicFasilitasUtamaController::class, 'detail'])->name('fasilitas.detail');

// UMKM
Route::get('/fasilitas/umkm', [PublicFasilitasUtamaController::class, 'umkm'])->name('fasilitas.umkm');
Route::get('/fasilitas/umkm/{id}', [PublicFasilitasUtamaController::class, 'umkmDetail'])->name('fasilitas.umkm.detail');

// SOVENIR & UMKM (BARU)
Route::get('/sovenir-umkm', [PublicFasilitasUtamaController::class, 'umkmIndex'])->name('umkm.index');

// PENGINAPAN - Public Routes
Route::get('/penginapan', [PublicFasilitasUtamaController::class, 'penginapan'])->name('penginapan.index');
Route::get('/penginapan/{id}', [PublicFasilitasUtamaController::class, 'penginapanDetail'])->name('penginapan.detail');

// KULINER - Public Routes
Route::get('/kuliner', [PublicFasilitasUtamaController::class, 'kuliner'])->name('kuliner.index');
Route::get('/kuliner/{id}', [PublicFasilitasUtamaController::class, 'kulinerDetail'])->name('kuliner.detail');

// ========================================
// ========== GALERI ==========
// ========================================
Route::get('/galeri', [PublicGaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/{slug}', function ($slug) {
    $galeri = App\Models\Galeri::where('slug', $slug)->firstOrFail();
    $galeri->increment('views');
    return view('pages.galeri-detail', compact('galeri'));
})->name('galeri.detail');



// ========================================


// ========================================
// ========== GEOSITE ==========
// ========================================
Route::get('/geosite/balige', [PublicGeositeController::class, 'balige'])->name('geosite.balige');
Route::get('/geosite/meat', [PublicGeositeController::class, 'meat'])->name('geosite.meat');
Route::get('/geosite/batu-basiha', [PublicGeositeController::class, 'batuBasiha'])->name('geosite.batu-basiha');
Route::get('/geosite/batu-bahisan', [PublicGeositeController::class, 'batuBahisan'])->name('geosite.batu-bahisan');
Route::get('/geosite/liang-sipege', [PublicGeositeController::class, 'liangSipege'])->name('geosite.liang-sipege');

// Detail artikel sejarah
Route::get('/sejarah/{slug}', [PublicGeositeController::class, 'detail'])->name('sejarah.detail');

// ========================================
// ========== API ROUTES ==========
// ========================================
Route::post('/api/berita/{id}/view', function ($id) {
    $berita = App\Models\Berita::find($id);
    if ($berita) {
        $berita->increment('views');
        return response()->json(['success' => true, 'views' => $berita->views]);
    }
    return response()->json(['success' => false], 404);
});

Route::post('/api/agenda/{id}/view', function ($id) {
    $agenda = App\Models\Agenda::find($id);
    if ($agenda) {
        $agenda->increment('views');
        return response()->json(['success' => true, 'views' => $agenda->views]);
    }
    return response()->json(['success' => false], 404);
});

Route::post('/api/pengumuman/{id}/view', function ($id) {
    $pengumuman = App\Models\Pengumuman::find($id);
    if ($pengumuman) {
        $pengumuman->increment('views');
        return response()->json(['success' => true, 'views' => $pengumuman->views]);
    }
    return response()->json(['success' => false], 404);
});

// ========================================
// ========== AUTH ROUTES ==========
// ========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ========================================
// ========== ADMIN ROUTES (PROTECTED) ==========
// ========================================
Route::prefix('admin')->middleware(['auth'])->as('admin.')->group(function () {

    // ========== DASHBOARD ==========
    Route::get('/', function () {
        $totalGaleri       = DB::table('galeri')->count();
        $totalBerita       = DB::table('beritas')->count();
        $totalAgenda       = DB::table('agendas')->count();
        $totalPengumuman   = DB::table('pengumuman')->count();
        $totalUmkm         = DB::table('umkm')->count();
        $totalFasilitas    = DB::table('fasilitas')->count();
        $totalPenginapan   = DB::table('penginapan')->count();
        $totalBiodiversitas= DB::table('biodiversitas')->count();
        $totalSejarah      = DB::table('sejarah_wisata')->count();
        $totalViews        = 0;
        $beritaTerbaru     = App\Models\Berita::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalGaleri',
            'totalBerita',
            'totalAgenda',
            'totalPengumuman',
            'totalUmkm',
            'totalFasilitas',
            'totalPenginapan',
            'totalBiodiversitas',
            'totalSejarah',
            'totalViews',
            'beritaTerbaru'
        ));
    })->name('dashboard');

    // ========== DIVERSITY CRUD ==========
    Route::resource('biodiversitas', App\Http\Controllers\Admin\AdminBiodiversitasController::class);
    Route::post('biodiversitas/toggle-status/{id}', [App\Http\Controllers\Admin\AdminBiodiversitasController::class, 'toggleStatus'])->name('biodiversitas.toggle-status');

    Route::resource('geodiversitas', App\Http\Controllers\Admin\AdminGeodiversitasController::class);
    Route::post('geodiversitas/toggle-status/{id}', [App\Http\Controllers\Admin\AdminGeodiversitasController::class, 'toggleStatus'])->name('geodiversitas.toggle-status');

    Route::resource('cultural-diversity', App\Http\Controllers\Admin\AdminCulturalDiversityController::class);
    Route::post('cultural-diversity/toggle-status/{id}', [App\Http\Controllers\Admin\AdminCulturalDiversityController::class, 'toggleStatus'])->name('cultural-diversity.toggle-status');


    // ========== SLIDER CRUD ==========
    Route::resource('slider', App\Http\Controllers\Admin\AdminSliderController::class);


    // ========== SEJARAH WISATA ==========
    Route::resource('sejarah-wisata', AdminSejarahWisataController::class);
    Route::post('sejarah-wisata/toggle-status/{id}', [AdminSejarahWisataController::class, 'toggleStatus'])->name('sejarah-wisata.toggle-status');
    Route::get('sejarah-wisata/filter/{geosite}', [AdminSejarahWisataController::class, 'filter'])->name('sejarah-wisata.filter');

    // ========== RESOURCE CRUD ==========
    Route::resource('galeri', AdminGaleriController::class);
    Route::resource('berita', AdminBeritaController::class);
    Route::resource('agenda', AdminAgendaController::class);
    Route::resource('pengumuman', AdminPengumumanController::class);
    Route::resource('umkm', AdminUmkmController::class);
    Route::resource('fasilitas', AdminFasilitasController::class);
    Route::resource('penginapan', AdminPenginapanController::class);
    Route::post('penginapan/toggle-status/{id}', [AdminPenginapanController::class, 'toggleStatus'])->name('penginapan.toggle-status');

    Route::resource('kuliner', AdminKulinerController::class);
    Route::post('kuliner/toggle-status/{id}', [AdminKulinerController::class, 'toggleStatus'])->name('kuliner.toggle-status');

    Route::resource('pengelola-geosite', AdminPengelolaGeositeController::class);


    // ========== TOGGLE STATUS ==========
    Route::post('galeri/toggle-status/{id}', [AdminGaleriController::class, 'toggleStatus'])->name('galeri.toggle-status');
    Route::post('berita/toggle-status/{id}', [AdminBeritaController::class, 'toggleStatus'])->name('berita.toggle-status');
    Route::post('agenda/toggle-status/{id}', [AdminAgendaController::class, 'toggleStatus'])->name('agenda.toggle-status');
    Route::post('pengumuman/toggle-status/{id}', [AdminPengumumanController::class, 'toggleStatus'])->name('pengumuman.toggle-status');


    // ========== GALERI UNGGULAN ==========
    Route::post('galeri/toggle-unggulan/{id}', [AdminGaleriController::class, 'toggleUnggulan'])->name('galeri.toggle-unggulan');

    // ========== KONTAK ==========
    Route::get('/kontak', [AdminKontakController::class, 'index'])->name('kontak.index');
    Route::put('/kontak', [AdminKontakController::class, 'update'])->name('kontak.update');

    // ========================================
    // ========== DESTINATION CRUD ==========
    // ========================================

    // --- DESTINASI ALAM ---
    Route::get('destination/alam',             [AdminDestinationController::class, 'index'])->defaults('category', 'alam')->name('destination.alam.index');
    Route::get('destination/alam/create',      [AdminDestinationController::class, 'create'])->defaults('category', 'alam')->name('destination.alam.create');
    Route::post('destination/alam',            [AdminDestinationController::class, 'store'])->defaults('category', 'alam')->name('destination.alam.store');
    Route::get('destination/alam/{id}/edit',   [AdminDestinationController::class, 'edit'])->defaults('category', 'alam')->name('destination.alam.edit');
    Route::put('destination/alam/{id}',        [AdminDestinationController::class, 'update'])->defaults('category', 'alam')->name('destination.alam.update');
    Route::delete('destination/alam/{id}',     [AdminDestinationController::class, 'destroy'])->defaults('category', 'alam')->name('destination.alam.destroy');

    // --- DESTINASI BUATAN ---
    Route::get('destination/buatan',           [AdminDestinationController::class, 'index'])->defaults('category', 'buatan')->name('destination.buatan.index');
    Route::get('destination/buatan/create',    [AdminDestinationController::class, 'create'])->defaults('category', 'buatan')->name('destination.buatan.create');
    Route::post('destination/buatan',          [AdminDestinationController::class, 'store'])->defaults('category', 'buatan')->name('destination.buatan.store');
    Route::get('destination/buatan/{id}/edit', [AdminDestinationController::class, 'edit'])->defaults('category', 'buatan')->name('destination.buatan.edit');
    Route::put('destination/buatan/{id}',      [AdminDestinationController::class, 'update'])->defaults('category', 'buatan')->name('destination.buatan.update');
    Route::delete('destination/buatan/{id}',   [AdminDestinationController::class, 'destroy'])->defaults('category', 'buatan')->name('destination.buatan.destroy');

    // --- DESTINASI BUDAYA ---
    Route::get('destination/budaya',           [AdminDestinationController::class, 'index'])->defaults('category', 'budaya')->name('destination.budaya.index');
    Route::get('destination/budaya/create',    [AdminDestinationController::class, 'create'])->defaults('category', 'budaya')->name('destination.budaya.create');
    Route::post('destination/budaya',          [AdminDestinationController::class, 'store'])->defaults('category', 'budaya')->name('destination.budaya.store');
    Route::get('destination/budaya/{id}/edit', [AdminDestinationController::class, 'edit'])->defaults('category', 'budaya')->name('destination.budaya.edit');
    Route::put('destination/budaya/{id}',      [AdminDestinationController::class, 'update'])->defaults('category', 'budaya')->name('destination.budaya.update');
    Route::delete('destination/budaya/{id}',   [AdminDestinationController::class, 'destroy'])->defaults('category', 'budaya')->name('destination.budaya.destroy');
});

Route::get('/debug-lang', function() { return 'Locale: ' . app()->getLocale() . ' Session: ' . session('locale'); });




