<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SejarahWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSejarahWisataController extends Controller
{
    public function index()
    {
        $data = SejarahWisata::latest()->paginate(10);
        return view('admin.sejarah-wisata.index', compact('data'));
    }

    public function create()
    {
        return view('admin.sejarah-wisata.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'geosite' => 'required|in:balige,meat,batu-basiha,liang-sipege',
            'kategori' => 'required|in:sejarah,legenda,budaya,informasi,tokoh',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'lokasi' => 'nullable|string|max:255',
            'penulis' => 'nullable|string|max:100',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'slug' => Str::slug($request->judul) . '-' . time(),
            'geosite' => $request->geosite,
            'kategori' => $request->kategori,
            'konten' => $request->konten,
            'konten_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->konten),
            'lokasi' => $request->lokasi,
            'penulis' => $request->penulis ?? 'Admin',
            'status' => $request->has('status') ? 1 : 0,
            'views' => 0
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_sejarah_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/sejarah');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/sejarah/' . $filename;
        }

        SejarahWisata::create($data);
        return redirect()->route('admin.sejarah-wisata.index')
            ->with('success', 'Data sejarah berhasil ditambahkan!');
    }

    public function show($id)
    {
        $data = SejarahWisata::findOrFail($id);
        return view('admin.sejarah-wisata.show', compact('data'));
    }

    public function edit($id)
    {
        $data = SejarahWisata::findOrFail($id);
        return view('admin.sejarah-wisata.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $sejarah = SejarahWisata::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'geosite' => 'required|in:balige,meat,batu-basiha,liang-sipege',
            'kategori' => 'required|in:sejarah,legenda,budaya,informasi,tokoh',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'lokasi' => 'nullable|string|max:255',
            'penulis' => 'nullable|string|max:100',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'slug' => Str::slug($request->judul) . '-' . time(),
            'geosite' => $request->geosite,
            'kategori' => $request->kategori,
            'konten' => $request->konten,
            'konten_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->konten),
            'lokasi' => $request->lokasi,
            'penulis' => $request->penulis ?? 'Admin',
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            if ($sejarah->gambar && file_exists(public_path($sejarah->gambar))) {
                unlink(public_path($sejarah->gambar));
            }
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($sejarah->gambar && file_exists(public_path($sejarah->gambar))) {
                unlink(public_path($sejarah->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_sejarah_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/sejarah');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/sejarah/' . $filename;
        }

        $sejarah->update($data);
        return redirect()->route('admin.sejarah-wisata.index')
            ->with('success', 'Data sejarah berhasil diupdate!');
    }

    public function destroy($id)
    {
        $sejarah = SejarahWisata::findOrFail($id);
        if ($sejarah->gambar && file_exists(public_path($sejarah->gambar))) {
            unlink(public_path($sejarah->gambar));
        }
        $sejarah->delete();
        return redirect()->route('admin.sejarah-wisata.index')
            ->with('success', 'Data sejarah berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $sejarah = SejarahWisata::findOrFail($id);
        $sejarah->status = !$sejarah->status;
        $sejarah->save();
        return response()->json(['success' => true, 'status' => $sejarah->status]);
    }

    // Filter by geosite
    public function filter($geosite)
    {
        $data = SejarahWisata::where('geosite', $geosite)->latest()->paginate(10);
        return view('admin.sejarah-wisata.index', compact('data'));
    }
}

