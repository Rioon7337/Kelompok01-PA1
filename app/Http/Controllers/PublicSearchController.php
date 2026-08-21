<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Umkm;
use App\Models\Penginapan;
use App\Models\Biodiversitas;
use App\Models\Geodiversitas;
use App\Models\CulturalDiversity;

class PublicSearchController extends Controller
{
    /**
     * Endpoint pencarian global.
     * Menerima parameter GET ?q=... dan mencari ke seluruh tabel utama.
     * Mengembalikan respons JSON yang berisi kumpulan hasil dari semua tabel.
     */
    public function search(Request $request)
    {
        // Ambil dan bersihkan kata kunci dari request
        $query = trim($request->get('q', ''));

        // Jika query kurang dari 3 karakter, kembalikan array kosong
        // (validasi ini juga ada di frontend, tapi perlu double-check di backend)
        if (mb_strlen($query) < 3) {
            return response()->json([]);
        }

        $results = collect();

        // ============================================================
        // 1. CARI DI TABEL BERITA
        // Hanya cari berita yang berstatus aktif (status = 1)
        // ============================================================
        $berita = Berita::where('status', 1)
            ->where('judul', 'LIKE', "%{$query}%")
            ->select('id', 'judul', 'slug', 'gambar', 'penulis')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'type'        => 'Berita',        // Label kategori hasil
                    'icon'        => 'fa-newspaper',   // Ikon FontAwesome
                    'nama' => $item->judul_trans ?? $item->judul,     // Nama yang ditampilkan
                    'sub'         => $item->penulis ?? 'Redaksi', // Info tambahan
                    'url'         => url('/berita/' . $item->slug), // URL tujuan klik
                    'gambar_url'  => $item->gambar_url,
                ];
            });

        // ============================================================
        // 2. CARI DI TABEL UMKM
        // Hanya tampilkan UMKM dengan status aktif
        // ============================================================
        $umkm = Umkm::where('status', 'aktif')
            ->where('nama_usaha', 'LIKE', "%{$query}%")
            ->select('id', 'nama_usaha', 'pemilik', 'alamat', 'foto_utama')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                // Resolusi URL gambar UMKM mengikuti logika yang sama dengan HomeController
                $gambarUrl = null;
                if (!empty($item->foto_utama)) {
                    if (str_starts_with($item->foto_utama, 'image/') || str_starts_with($item->foto_utama, 'storage/')) {
                        $gambarUrl = asset($item->foto_utama);
                    } elseif (file_exists(public_path('image/umkm/' . $item->foto_utama))) {
                        $gambarUrl = asset('image/umkm/' . $item->foto_utama);
                    } else {
                        $gambarUrl = asset($item->foto_utama);
                    }
                }

                return [
                    'type'        => 'UMKM',
                    'icon'        => 'fa-store',
                    'nama' => $item->nama_usaha_trans ?? $item->nama_usaha,
                    'sub'         => $item->alamat ?? 'Desa Meat',
                    'url'         => url('/umkm/' . $item->id),
                    'gambar_url'  => $gambarUrl,
                ];
            });

        // ============================================================
        // 3. CARI DI TABEL PENGINAPAN
        // Cari berdasarkan nama atau lokasi, hanya yang aktif (status = 1)
        // ============================================================
        $penginapan = Penginapan::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'lokasi', 'harga', 'gambar')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'type'        => 'Penginapan',
                    'icon'        => 'fa-hotel',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'         => $item->lokasi ?? '-',
                    'url'         => url('/penginapan/' . $item->id),
                    'gambar_url'  => $item->gambar_url, // Menggunakan accessor yang sudah ada di model
                ];
            });

        // ============================================================
        // 4. CARI DI TABEL BIODIVERSITAS
        // Hanya tampilkan yang berstatus aktif (status = true)
        // ============================================================
        $biodiversitas = Biodiversitas::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'slug', 'kategori', 'lokasi', 'gambar')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'type'        => 'Biodiversitas',
                    'icon'        => 'fa-leaf',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'         => $item->kategori ?? $item->lokasi,
                    'url'         => url('/biodiversitas/' . $item->slug),
                    'gambar_url'  => $item->gambar_url,
                ];
            });

        // ============================================================
        // 5. CARI DI TABEL GEODIVERSITAS
        // Hanya tampilkan yang berstatus aktif (status = true)
        // ============================================================
        $geodiversitas = Geodiversitas::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'slug', 'tipe_geologi', 'lokasi', 'gambar')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'type'        => 'Geodiversitas',
                    'icon'        => 'fa-gem',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'         => $item->tipe_geologi ?? $item->lokasi,
                    'url'         => url('/geodiversitas/' . $item->slug),
                    'gambar_url'  => $item->gambar_url,
                ];
            });

        // ============================================================
        // 6. CARI DI TABEL CULTURAL DIVERSITY
        // Hanya tampilkan yang berstatus aktif (status = true)
        // ============================================================
        $cultural = CulturalDiversity::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'slug', 'kategori', 'lokasi', 'gambar')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                return [
                    'type'        => 'Budaya',
                    'icon'        => 'fa-people-arrows',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'         => $item->kategori ?? $item->lokasi,
                    'url'         => url('/cultural-diversity/' . $item->slug),
                    'gambar_url'  => $item->gambar_url,
                ];
            });

        // ============================================================
        // 7. CARI DI DATA DESTINASI (HARDCODED)
        // Data Destinasi berada secara hardcoded di DestinasiController
        // ============================================================
        $hardcodedDestinasi = [
            ['nama' => 'Pantai Meat', 'kategori' => 'alam', 'slug' => 'desa-wisata-meat', 'lokasi' => 'Kec. Tampahan, Kab. Toba Samosir', 'foto' => 'image/meat/meat-detail.jpg'],
            ['nama' => 'Batu Basiha', 'kategori' => 'alam', 'slug' => 'geosite-batu-basiha', 'lokasi' => 'Desa Aek Bolon, Balige', 'foto' => 'image/meat/batubasiha1.png'],
            ['nama' => 'Gua Liang Sipege', 'kategori' => 'alam', 'slug' => 'liang-sipege', 'lokasi' => 'Desa Simarmar Pea Talun Hutagaol', 'foto' => 'image/meat/liang-sipege-hero.jpg'],
            ['nama' => 'Sentra Tenun Ulos', 'kategori' => 'budaya', 'slug' => 'sentra-tenun-ulos', 'lokasi' => 'Desa Meat, Kec. Tampahan', 'foto' => 'image/meat/ulos.jpg'],
            ['nama' => 'Rumah Adat Batak', 'kategori' => 'budaya', 'slug' => 'rumah-adat-batak', 'lokasi' => 'Desa Meat, Kec. Tampahan', 'foto' => 'image/meat/jabubatak.jpg'],
            ['nama' => 'Spot Pantai Meat', 'kategori' => 'buatan', 'slug' => 'spot-pantai-meat', 'lokasi' => 'Desa Meat, Kec. Tampahan', 'foto' => 'image/meat/meat.jpeg'],
            ['nama' => 'Homestay Meat', 'kategori' => 'buatan', 'slug' => 'homestay-meat', 'lokasi' => 'Desa Meat, Kec. Tampahan', 'foto' => 'image/meat/meat1.jpeg'],
            ['nama' => 'Jalur Trekking Sawah', 'kategori' => 'buatan', 'slug' => 'jalur-trekking-sawah', 'lokasi' => 'Desa Meat, Kec. Tampahan', 'foto' => 'image/destinasi/buatan3.jpg'],
        ];

        $destinasiResults = collect($hardcodedDestinasi)->filter(function ($item) use ($query) {
            return stripos($item['nama'], $query) !== false || stripos($item['lokasi'], $query) !== false;
        })->take(4)->map(function ($item) {
            return [
                'type'        => 'Destinasi',
                'icon'        => 'fa-map-marked-alt',
                'nama'        => $item['nama'],
                'sub'         => $item['lokasi'],
                'url'         => url('/destinasi/' . $item['kategori'] . '/' . $item['slug']),
                'gambar_url'  => asset($item['foto']),
            ];
        });

        // ============================================================
        // GABUNGKAN SEMUA HASIL DARI SEMUA TABEL
        // Menggunakan merge() dari Laravel Collection agar rapi dan efisien
        // ============================================================
        $results = $results
            ->merge($destinasiResults)
            ->merge($berita)
            ->merge($umkm)
            ->merge($penginapan)
            ->merge($biodiversitas)
            ->merge($geodiversitas)
            ->merge($cultural);

        // Kembalikan hasil sebagai respons JSON
        return response()->json($results->values()->all());
    }

    /**
     * Halaman Hasil Pencarian Penuh.
     * Dipanggil ketika pengguna menekan Enter atau mengklik ikon pencarian.
     * Menerima parameter GET ?q=... dan mengembalikan Blade View khusus.
     */
    public function searchResults(Request $request)
    {
        // Ambil dan bersihkan kata kunci dari request
        $query = trim($request->get('q', ''));

        // Inisialisasi collection kosong untuk menampung semua hasil
        $results = collect();

        // Jika query kosong, langsung kembalikan tampilan dengan hasil kosong
        if (mb_strlen($query) < 1) {
            return view('pages.search-results', [
                'query'   => $query,
                'results' => $results,
            ]);
        }

        // ============================================================
        // 1. CARI DI TABEL BERITA
        // ============================================================
        $berita = \App\Models\Berita::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('judul', 'LIKE', "%{$query}%")
                  ->orWhere('konten', 'LIKE', "%{$query}%")
                  ->orWhere('penulis', 'LIKE', "%{$query}%");
            })
            ->select('id', 'judul', 'slug', 'gambar', 'penulis', 'created_at', 'konten')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'type'        => 'Berita',
                    'icon'        => 'fa-newspaper',
                    'nama' => $item->judul_trans ?? $item->judul,
                    'sub'         => $item->penulis ?? 'Redaksi',
                    'deskripsi' => $item->konten_trans ?? $item->konten,
                    'url'         => url('/berita/' . $item->slug),
                    'gambar_url'  => $item->gambar_url,
                    'tanggal'     => $item->created_at ? $item->created_at->format('d M Y') : null,
                ];
            });

        // ============================================================
        // 2. CARI DI TABEL UMKM
        // ============================================================
        $umkm = \App\Models\Umkm::where('status', 'aktif')
            ->where(function ($q) use ($query) {
                $q->where('nama_usaha', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%")
                  ->orWhere('alamat', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama_usaha', 'pemilik', 'alamat', 'foto_utama', 'deskripsi', 'no_telepon')
            ->get()
            ->map(function ($item) {
                // Resolusi URL gambar UMKM
                $gambarUrl = null;
                if (!empty($item->foto_utama)) {
                    if (str_starts_with($item->foto_utama, 'image/') || str_starts_with($item->foto_utama, 'storage/')) {
                        $gambarUrl = asset($item->foto_utama);
                    } elseif (file_exists(public_path('image/umkm/' . $item->foto_utama))) {
                        $gambarUrl = asset('image/umkm/' . $item->foto_utama);
                    } else {
                        $gambarUrl = asset($item->foto_utama);
                    }
                }
                return [
                    'type'        => 'UMKM',
                    'icon'        => 'fa-store',
                    'nama' => $item->nama_usaha_trans ?? $item->nama_usaha,
                    'sub'         => $item->alamat ?? 'Desa Meat',
                    'deskripsi' => $item->deskripsi_trans ?? $item->deskripsi,
                    'kontak'      => $item->no_telepon,
                    'url'         => url('/fasilitas/umkm/' . $item->id),
                    'gambar_url'  => $gambarUrl,
                ];
            });

        // ============================================================
        // 3. CARI DI TABEL PENGINAPAN
        // ============================================================
        $penginapan = \App\Models\Penginapan::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'lokasi', 'harga', 'gambar', 'deskripsi', 'kontak')
            ->get()
            ->map(function ($item) {
                return [
                    'type'       => 'Penginapan',
                    'icon'       => 'fa-hotel',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'        => $item->lokasi ?? '-',
                    'deskripsi' => $item->deskripsi_trans ?? $item->deskripsi,
                    'harga'      => $item->harga,
                    'kontak'     => $item->kontak,
                    'url'        => url('/fasilitas/penginapan/' . $item->id),
                    'gambar_url' => $item->gambar_url,
                ];
            });

        // ============================================================
        // 4. CARI DI TABEL BIODIVERSITAS
        // ============================================================
        $biodiversitas = \App\Models\Biodiversitas::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'slug', 'kategori', 'lokasi', 'gambar', 'deskripsi')
            ->get()
            ->map(function ($item) {
                return [
                    'type'       => 'Biodiversitas',
                    'icon'       => 'fa-leaf',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'        => $item->kategori ?? $item->lokasi,
                    'deskripsi' => $item->deskripsi_trans ?? $item->deskripsi,
                    'url'        => url('/biodiversitas/' . $item->slug),
                    'gambar_url' => $item->gambar_url,
                ];
            });

        // ============================================================
        // 5. CARI DI TABEL GEODIVERSITAS
        // ============================================================
        $geodiversitas = \App\Models\Geodiversitas::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'slug', 'tipe_geologi', 'lokasi', 'gambar', 'deskripsi')
            ->get()
            ->map(function ($item) {
                return [
                    'type'       => 'Geodiversitas',
                    'icon'       => 'fa-gem',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'        => $item->tipe_geologi ?? $item->lokasi,
                    'deskripsi' => $item->deskripsi_trans ?? $item->deskripsi,
                    'url'        => url('/geodiversitas/' . $item->slug),
                    'gambar_url' => $item->gambar_url,
                ];
            });

        // ============================================================
        // 6. CARI DI TABEL CULTURAL DIVERSITY
        // ============================================================
        $cultural = \App\Models\CulturalDiversity::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('lokasi', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%");
            })
            ->select('id', 'nama', 'slug', 'kategori', 'lokasi', 'gambar', 'deskripsi')
            ->get()
            ->map(function ($item) {
                return [
                    'type'       => 'Budaya',
                    'icon'       => 'fa-people-arrows',
                    'nama' => $item->nama_trans ?? $item->nama,
                    'sub'        => $item->kategori ?? $item->lokasi,
                    'deskripsi' => $item->deskripsi_trans ?? $item->deskripsi,
                    'url'        => url('/cultural-diversity/' . $item->slug),
                    'gambar_url' => $item->gambar_url,
                ];
            });

        // ============================================================
        // 7. CARI DI DATA DESTINASI (HARDCODED)
        // ============================================================
        $hardcodedDestinasi = [
            ['nama' => 'Pantai Meat',          'kategori' => 'alam',    'slug' => 'desa-wisata-meat',    'lokasi' => 'Kec. Tampahan, Kab. Toba Samosir', 'foto' => 'image/meat/meat-detail.jpg',         'deskripsi' => 'Pantai Meat adalah destinasi wisata alam yang indah di tepi Danau Toba.'],
            ['nama' => 'Batu Basiha',          'kategori' => 'alam',    'slug' => 'geosite-batu-basiha', 'lokasi' => 'Desa Aek Bolon, Balige',           'foto' => 'image/meat/batubasiha1.png',         'deskripsi' => 'Formasi batuan unik dengan nilai geologi dan budaya yang tinggi.'],
            ['nama' => 'Gua Liang Sipege',     'kategori' => 'alam',    'slug' => 'liang-sipege',         'lokasi' => 'Desa Simarmar Pea Talun Hutagaol','foto' => 'image/meat/liang-sipege-hero.jpg',   'deskripsi' => 'Gua alam eksotis dengan stalaktit dan stalakmit yang memukau.'],
            ['nama' => 'Sentra Tenun Ulos',    'kategori' => 'budaya',  'slug' => 'sentra-tenun-ulos',    'lokasi' => 'Desa Meat, Kec. Tampahan',          'foto' => 'image/meat/ulos.jpg',                'deskripsi' => 'Pusat kerajinan tenun ulos khas Batak yang terkenal.'],
            ['nama' => 'Rumah Adat Batak',     'kategori' => 'budaya',  'slug' => 'rumah-adat-batak',     'lokasi' => 'Desa Meat, Kec. Tampahan',          'foto' => 'image/meat/jabubatak.jpg',           'deskripsi' => 'Rumah adat Batak tradisional yang masih terjaga keasliannya.'],
            ['nama' => 'Spot Pantai Meat',     'kategori' => 'buatan',  'slug' => 'spot-pantai-meat',     'lokasi' => 'Desa Meat, Kec. Tampahan',          'foto' => 'image/meat/meat.jpeg',               'deskripsi' => 'Spot foto terbaik dengan pemandangan Danau Toba yang memukau.'],
            ['nama' => 'Homestay Meat',        'kategori' => 'buatan',  'slug' => 'homestay-meat',         'lokasi' => 'Desa Meat, Kec. Tampahan',          'foto' => 'image/meat/meat1.jpeg',              'deskripsi' => 'Penginapan homestay dengan nuansa lokal yang hangat dan nyaman.'],
            ['nama' => 'Jalur Trekking Sawah', 'kategori' => 'buatan',  'slug' => 'jalur-trekking-sawah', 'lokasi' => 'Desa Meat, Kec. Tampahan',          'foto' => 'image/destinasi/buatan3.jpg',        'deskripsi' => 'Jalur trekking melewati hamparan sawah hijau yang menakjubkan.'],
        ];

        $destinasiResults = collect($hardcodedDestinasi)
            ->filter(function ($item) use ($query) {
                return stripos($item['nama'], $query) !== false
                    || stripos($item['lokasi'], $query) !== false
                    || stripos($item['deskripsi'], $query) !== false;
            })
            ->map(function ($item) {
                return [
                    'type'       => 'Destinasi',
                    'icon'       => 'fa-map-marked-alt',
                    'nama'       => $item['nama'],
                    'sub'        => $item['lokasi'],
                    'deskripsi'  => $item['deskripsi'],
                    'url'        => url('/destinasi/' . $item['kategori'] . '/' . $item['slug']),
                    'gambar_url' => asset($item['foto']),
                ];
            });

        // ============================================================
        // GABUNGKAN SEMUA HASIL
        // ============================================================
        $results = collect()
            ->merge($destinasiResults)
            ->merge($berita)
            ->merge($umkm)
            ->merge($penginapan)
            ->merge($biodiversitas)
            ->merge($geodiversitas)
            ->merge($cultural);

        // Kembalikan sebagai Blade View (bukan JSON)
        return view('pages.search-results', [
            'query'   => $query,
            'results' => $results->values(),
        ]);
    }
}


