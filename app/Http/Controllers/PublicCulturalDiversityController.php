<?php

namespace App\Http\Controllers;

use App\Models\CulturalDiversity;
use Illuminate\Http\Request;

class PublicCulturalDiversityController extends Controller
{
    public function index()
    {
        $data = CulturalDiversity::where('status', true)->latest()->paginate(12);
        return view('pages.cultural-diversity', compact('data'));
    }

    public function show($slug)
    {
        $item = CulturalDiversity::where('slug', $slug)->where('status', true)->firstOrFail();
        $item->increment('views');
        
        $rekomendasi = CulturalDiversity::where('status', true)
            ->where('id', '!=', $item->id)
            ->where('kategori', $item->kategori)
            ->limit(4)
            ->get();
            
        return view('pages.cultural-diversity-detail', compact('item', 'rekomendasi'));
    }
}
