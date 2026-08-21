<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

/**
 * PublicDestinationController menangani tampilan publik untuk ketiga
 * sub-kategori destinasi wisata yang dikelola via CRUD admin.
 * Menggunakan paginate(6) agar server tidak kelebihan beban.
 */
class PublicDestinationController extends Controller
{
    // ==============================================================
    // DESTINASI ALAM — /wisata/alam
    // ==============================================================

    public function alam()
    {
        // Ambil hanya data aktif, kategori alam, 6 per halaman
        $destinations = Destination::active()
            ->ofCategory('alam')
            ->latest()
            ->paginate(6);

        return view('pages.wisata.alam', [
            'destinations' => $destinations,
            'category'     => 'alam',
            'categoryLabel'=> 'Destinasi Alam',
            'icon'         => '🌿',
            'subtitle'     => 'Keindahan alam Geosite Danau Toba yang memukau',
        ]);
    }

    // ==============================================================
    // DESTINASI BUATAN — /wisata/buatan
    // ==============================================================

    public function buatan()
    {
        $destinations = Destination::active()
            ->ofCategory('buatan')
            ->latest()
            ->paginate(6);

        return view('pages.wisata.buatan', [
            'destinations' => $destinations,
            'category'     => 'buatan',
            'categoryLabel'=> 'Destinasi Buatan',
            'icon'         => '🏛️',
            'subtitle'     => 'Fasilitas dan wisata buatan di kawasan Geosite Toba',
        ]);
    }

    // ==============================================================
    // DESTINASI BUDAYA — /wisata/budaya
    // ==============================================================

    public function budaya()
    {
        $destinations = Destination::active()
            ->ofCategory('budaya')
            ->latest()
            ->paginate(6);

        return view('pages.wisata.budaya', [
            'destinations' => $destinations,
            'category'     => 'budaya',
            'categoryLabel'=> 'Destinasi Budaya',
            'icon'         => '🎭',
            'subtitle'     => 'Warisan budaya dan tradisi Batak di Geosite Danau Toba',
        ]);
    }

    // ==============================================================
    // DETAIL DESTINASI — /wisata/{category}/{id}
    // ==============================================================

    public function show(string $category, int $id)
    {
        // Pastikan destination ditemukan dan sesuai kategorinya
        $destination = Destination::active()
            ->ofCategory($category)
            ->findOrFail($id);

        // Ambil 3 destinasi lain di kategori yang sama sebagai rekomendasi
        $related = Destination::active()
            ->ofCategory($category)
            ->where('id', '!=', $id)
            ->latest()
            ->limit(3)
            ->get();

        return view('pages.wisata.detail', compact('destination', 'related', 'category'));
    }
}
