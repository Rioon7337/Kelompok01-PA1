<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Agenda;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PublicBeritaController extends Controller
{
    // ========================================
    // PORTAL BERITA & INFORMASI
    // ========================================
    public function index()
    {
        return view('pages.berita-index');
    }

    // ========================================
    // BERITA TERKINI
    // ========================================
    public function terkini()
    {
        $berita = Berita::where('status', true)->latest()->paginate(9);
        return view('pages.berita', compact('berita'));
    }

    public function detail($slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', true)->firstOrFail();
        $berita->increment('views');
        return view('pages.berita-detail', compact('berita'));
    }

    // ========================================
    // AGENDA / EVENT
    // ========================================
    public function agenda()
    {
        $agenda = Agenda::where('status', true)
                        ->orderBy('tanggal_mulai', 'desc')
                        ->paginate(9);
        return view('pages.agenda', compact('agenda'));
    }

    public function agendaDetail($id)
    {
        $agenda = Agenda::where('status', true)->findOrFail($id);
        $agenda->increment('views');
        return view('pages.agenda-detail', compact('agenda'));
    }

    // ========================================
    // PENGUMUMAN
    // ========================================
    public function pengumuman()
    {
        $pengumuman = Pengumuman::where('status', true)
                                ->orderBy('tanggal_terbit', 'desc')
                                ->paginate(9);
        return view('pages.pengumuman', compact('pengumuman'));
    }

    public function pengumumanDetail($id)
    {
        $pengumuman = Pengumuman::where('status', true)->findOrFail($id);
        $pengumuman->increment('views');
        return view('pages.pengumuman-detail', compact('pengumuman'));
    }
}
