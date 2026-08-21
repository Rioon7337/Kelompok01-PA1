<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SejarahWisata;
use App\Models\PengelolaGeosite;

class PublicTentangGeositeController extends Controller
{
    public function index()
    {
        // Ambil data geosite untuk ditampilkan
        $geositeList = [
            'balige' => SejarahWisata::where('geosite', 'balige')->where('status', true)->limit(3)->get(),
            'meat' => SejarahWisata::where('geosite', 'meat')->where('status', true)->limit(3)->get(),
            'batu-basiha' => SejarahWisata::where('geosite', 'batu-basiha')->where('status', true)->limit(3)->get(),
            'liang-sipege' => SejarahWisata::where('geosite', 'liang-sipege')->where('status', true)->limit(3)->get(),
        ];

        // Ambil data pengelola
        $pengelolas = PengelolaGeosite::orderBy('urutan', 'asc')->get();

        return view('pages.tentang-geosite', compact('geositeList', 'pengelolas'));
    }
}
