<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class PublicGaleriController extends Controller
{
    public function index()
    {
        // Ambil semua galeri yang statusnya aktif
        $galeri = Galeri::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Debug: lihat data kategori di log
        \Log::info('Data Galeri:', $galeri->pluck('kategori')->toArray());
        
        // Kirim variabel $galeri ke view
        return view('pages.galeri', compact('galeri'));
    }
}
