<?php

namespace App\Http\Controllers;

use App\Models\Geodiversitas;
use Illuminate\Http\Request;

class PublicGeodiversitasController extends Controller
{
    public function index()
    {
        $data = Geodiversitas::where('status', true)->latest()->paginate(12);
        return view('pages.geodiversitas', compact('data'));
    }

    public function show($slug)
    {
        $item = Geodiversitas::where('slug', $slug)->where('status', true)->firstOrFail();
        $item->increment('views');
        
        $rekomendasi = Geodiversitas::where('status', true)
            ->where('id', '!=', $item->id)
            ->where('tipe_geologi', $item->tipe_geologi)
            ->limit(4)
            ->get();
            
        return view('pages.geodiversitas-detail', compact('item', 'rekomendasi'));
    }
}
