<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicFasilitasUtamaController extends Controller
{
    /* 
     * Fungsi ini bertugas memanggil tampilan indeks fasilitas.
     * Tidak memerlukan data dinamis dari database karena ini hanya 
     * halaman menu (portal) menuju kategori UMKM atau Penginapan.
     */
    public function index()
    {
        // Ambil semua data fasilitas publik aktif
        $fasilitas = \App\Models\Fasilitas::where('status', 1)
                        ->orderBy('urutan', 'asc')
                        ->get();

        // Ambil jenis-jenis unik dari tabel fasilitas
        $jenisList = \App\Models\Fasilitas::where('status', 1)
                        ->whereNotNull('jenis')
                        ->distinct()
                        ->pluck('jenis');

        // Total data untuk statistik
        $totalPenginapan = \App\Models\Penginapan::where('status', 1)->count() + \App\Models\Fasilitas::where('status', 1)->where(function($q) { $q->whereRaw('LOWER(jenis) LIKE ?', ['%akomodasi%'])->orWhereRaw('LOWER(jenis) LIKE ?', ['%penginapan%']); })->count();
        $totalKuliner    = \App\Models\Kuliner::where('status', 1)->count() + \App\Models\Fasilitas::where('status', 1)->whereRaw('LOWER(jenis) LIKE ?', ['%kuliner%'])->count();
        $totalUmkm       = \App\Models\Umkm::where('status', 'aktif')->count();
        $totalFasilitas  = \App\Models\Fasilitas::where('status', 1)->count();

        return view('pages.fasilitas-index', compact(
            'fasilitas', 
            'jenisList', 
            'totalPenginapan', 
            'totalKuliner', 
            'totalUmkm', 
            'totalFasilitas'
        ));
    }

    /**
     * Halaman listing per-jenis fasilitas (misal: /fasilitas/kategori/akomodasi, /fasilitas/kategori/toilet)
     */
    public function kategori($jenis)
    {
        $jenisSlug = strtolower($jenis);
        $jenisFormatted = str_replace('-', ' ', $jenisSlug);
        
        $categoryLabel = ucwords($jenisFormatted);

        // Kata kunci pencarian di tabel Fasilitas
        $searchTerms = [$jenisFormatted];
        if ($jenisSlug === 'akomodasi' || $jenisSlug === 'penginapan') {
            $searchTerms = ['akomodasi', 'penginapan'];
            $categoryLabel = 'Akomodasi & Penginapan';
        }

        // 1. Ambil data dari tabel Fasilitas
        $fasilitasItems = \App\Models\Fasilitas::where('status', 1)
                    ->where(function($query) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $query->orWhereRaw('LOWER(jenis) LIKE ?', ['%' . $term . '%']);
                        }
                    })
                    ->orderBy('urutan', 'asc')
                    ->latest()
                    ->get();

        // 2. Gabungkan data dari tabel spesifik jika kategori Akomodasi atau Kuliner
        if ($jenisSlug === 'akomodasi' || $jenisSlug === 'penginapan') {
            $penginapanItems = \App\Models\Penginapan::where('status', 1)
                                ->orderBy('urutan', 'asc')
                                ->get();
            foreach ($penginapanItems as $p) {
                $p->jenis = 'akomodasi';
                $p->is_penginapan_model = true;
            }
            $itemsCollection = $fasilitasItems->concat($penginapanItems);
        } elseif ($jenisSlug === 'kuliner') {
            $kulinerItems = \App\Models\Kuliner::where('status', 1)
                                ->orderBy('urutan', 'asc')
                                ->get();
            foreach ($kulinerItems as $k) {
                $k->jenis = 'kuliner';
                $k->is_kuliner_model = true;
            }
            $itemsCollection = $fasilitasItems->concat($kulinerItems);
        } else {
            $itemsCollection = $fasilitasItems;
        }

        // Paginasi manual untuk gabungan Collection
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 6;
        $items = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsCollection->forPage($page, $perPage),
            $itemsCollection->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('pages.fasilitas.kategori', [
            'items'         => $items,
            'jenis'         => $jenis,
            'categoryLabel' => $categoryLabel,
            'subtitle'      => 'Fasilitas ' . $categoryLabel . ' di kawasan Geosite Danau Toba',
        ]);
    }

    /**
     * Halaman detail fasilitas publik (/fasilitas/detail/{id})
     */
    public function detail($id)
    {
        $item = \App\Models\Fasilitas::where('status', 1)->findOrFail($id);

        $related = \App\Models\Fasilitas::where('status', 1)
                        ->where('id', '!=', $id)
                        ->where('jenis', $item->jenis)
                        ->latest()
                        ->take(3)
                        ->get();

        if ($related->isEmpty()) {
            $related = \App\Models\Fasilitas::where('status', 1)
                            ->where('id', '!=', $id)
                            ->latest()
                            ->take(3)
                            ->get();
        }

        return view('pages.fasilitas.detail', compact('item', 'related'));
    }

    public function umkm()
    {
        $umkm = \App\Models\Umkm::where('status', 'aktif')
                    ->orderBy('urutan', 'asc')
                    ->paginate(6);
        return view('pages.umkm', compact('umkm'));
    }

    public function umkmIndex()
    {
        $umkm = \App\Models\Umkm::where('status', 'aktif')
                    ->orderBy('urutan', 'asc')
                    ->paginate(10);
        return view('pages.umkm-index', compact('umkm'));
    }

    public function umkmDetail($id)
    {
        $item = \App\Models\Umkm::findOrFail($id);
        $related = \App\Models\Umkm::where('status', 'aktif')
                        ->where('id', '!=', $id)
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
        return view('pages.umkm-detail', compact('item', 'related'));
    }

    public function penginapan()
    {
        return $this->kategori('akomodasi');
    }

    public function penginapanDetail($id)
    {
        $item = \App\Models\Penginapan::where('status', 1)->findOrFail($id);
        $related = \App\Models\Penginapan::where('status', 1)
                        ->where('id', '!=', $id)
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
        return view('pages.penginapan-detail', compact('item', 'related'));
    }

    public function kuliner()
    {
        return $this->kategori('kuliner');
    }

    public function kulinerDetail($id)
    {
        $item = \App\Models\Kuliner::where('status', 1)->findOrFail($id);
        $related = \App\Models\Kuliner::where('status', 1)
                        ->where('id', '!=', $id)
                        ->inRandomOrder()
                        ->take(3)
                        ->get();
        return view('pages.kuliner-detail', compact('item', 'related'));
    }
}

