<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Fasilitas;
use App\Models\Penginapan;

class PublicGeositeController extends Controller
{
    /**
     * Display Meat geosite page
     */
    public function meat()
    {
        $umkm = Umkm::where('status', true)->latest()->limit(6)->get();
        $fasilitas = Fasilitas::where('status', true)->latest()->limit(6)->get();
        $penginapan = Penginapan::where('status', true)->latest()->limit(6)->get();
        
        return view('geosite.meat', compact('umkm', 'fasilitas', 'penginapan'));
    }
    

    /**
     * Display Batu Bahisan / Batu Basiha geosite page
     */
    public function batuBahisan()
    {
        return view('geosite.batu-bahisan');
    }
    
    /**
     * Display Liang Sipege geosite page
     */
    public function liangSipege()
    {
        return view('geosite.liang-sipege');
    }
}
