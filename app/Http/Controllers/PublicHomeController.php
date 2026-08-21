<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Berita;
use App\Models\Informasi;
use App\Models\Umkm;
use App\Models\Fasilitas;
use App\Models\Penginapan;
use App\Models\Kontak;
use App\Models\Destination;
use App\Models\Slider;
use Illuminate\Http\Request;

class PublicHomeController extends Controller
{
    public function index()
    {
        // Slider
        $homeSliders = Slider::latest()->get();

        // Ambil data untuk ditampilkan di home
        $galeri = Galeri::where('status', true)->latest()->limit(6)->get();
        $berita = Berita::where('status', true)->latest()->limit(3)->get();
        $umkm = Umkm::where('status', 'aktif')->latest()->limit(4)->get();
        $penginapan = Penginapan::where('status', true)->latest()->limit(4)->get();
        $fasilitas = Fasilitas::where('status', true)->latest()->limit(4)->get();
        
        // Destinasi Unggulan
        $featuredDestinations = Destination::where('status', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        // Data kontak
        $kontak = Kontak::first();

        // Data untuk statistik (opsional)
        $totalGaleri = Galeri::count();
        $totalBerita = Berita::count();
        $totalUmkm = Umkm::count();
        $totalPenginapan = Penginapan::count();

        return view('pages.home', compact(
            'galeri', 
            'berita', 
            'umkm', 
            'penginapan', 
            'fasilitas',
            'kontak',
            'featuredDestinations',
            'totalGaleri',
            'totalBerita',
            'totalUmkm',
            'totalPenginapan',
            'homeSliders'
        ));
    }

    public function kontak()
    {
        $kontak = Kontak::first();
        return view('pages.kontak', compact('kontak'));
    }

    public function budaya()
    {
        return view('pages.budaya');
    }
}

