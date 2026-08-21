<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'penulis' => 'nullable|string|max:100',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'slug' => Str::slug($request->judul) . '-' . time(),
            'konten' => $request->konten,
            'konten_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->konten),
            'penulis' => $request->penulis ?? 'Admin',
            'status' => $request->has('status') ? 1 : 0,
            'views' => 0
        ];

        // SIMPAN GAMBAR KE PUBLIC/IMAGE/BERITA (SEPERTI GALERI)
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_berita_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            // Buat folder jika belum ada
            $destinationPath = public_path('image/berita');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/berita/' . $filename;
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'penulis' => 'nullable|string|max:100',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'slug' => Str::slug($request->judul) . '-' . time(),
            'konten' => $request->konten,
            'konten_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->konten),
            'penulis' => $request->penulis ?? 'Admin',
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($berita->gambar && file_exists(public_path($berita->gambar))) {
                unlink(public_path($berita->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_berita_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/berita');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/berita/' . $filename;
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diupdate!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Hapus file gambar
        if ($berita->gambar && file_exists(public_path($berita->gambar))) {
            unlink(public_path($berita->gambar));
        }
        
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->status = !$berita->status;
        $berita->save();
        
        return response()->json(['success' => true, 'status' => $berita->status]);
    }
}

