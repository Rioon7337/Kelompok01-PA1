<?php

namespace App\Http\Controllers;

use App\Models\Biodiversitas;
use Illuminate\Http\Request;

class PublicBiodiversitasController extends Controller
{
    public function index()
    {
        $data = Biodiversitas::where('status', true)->latest()->paginate(12);
        return view('pages.biodiversitas', compact('data'));
    }

    public function show($slug)
    {
        $item = Biodiversitas::where('slug', $slug)->where('status', true)->firstOrFail();
        $item->increment('views');
        
        // Rekomendasi
        $rekomendasi = Biodiversitas::where('status', true)
            ->where('id', '!=', $item->id)
            ->where('kategori', $item->kategori)
            ->limit(4)
            ->get();
            
        return view('pages.biodiversitas-detail', compact('item', 'rekomendasi'));
    }

    public function kategori($kategori)
    {
        $data = Biodiversitas::where('status', true)
            ->where('kategori', $kategori)
            ->latest()
            ->paginate(12);
        return view('pages.biodiversitas', compact('data'));
    }
}
