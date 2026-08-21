<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CulturalDiversity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCulturalDiversityController extends Controller
{
    public function index(Request $request)
    {
        $query = CulturalDiversity::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('kategori', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status == 'active' ? 1 : 0);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        $kategoriOptions = ['tarian', 'musik', 'upacara', 'kerajinan', 'kuliner'];

        return view('admin.cultural-diversity.index', compact('data', 'kategoriOptions'));
    }

    public function create()
    {
        return view('admin.cultural-diversity.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:tarian,musik,upacara,kerajinan,kuliner',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|string|max:500',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'nama' => $request->nama,
            'nama_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'slug' => Str::slug($request->nama) . '-' . time(),
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'lokasi' => $request->lokasi,
            'video_url' => $request->video_url,
            'status' => $request->has('status') ? 1 : 0,
            'views' => 0
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_cultural_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/cultural-diversity');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/cultural-diversity/' . $filename;
        }

        CulturalDiversity::create($data);
        return redirect()->route('admin.cultural-diversity.index')
            ->with('success', 'Data Cultural Diversity berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = CulturalDiversity::findOrFail($id);
        return view('admin.cultural-diversity.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $cultural = CulturalDiversity::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:tarian,musik,upacara,kerajinan,kuliner',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|string|max:500',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'nama' => $request->nama,
            'nama_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'slug' => Str::slug($request->nama) . '-' . time(),
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'lokasi' => $request->lokasi,
            'video_url' => $request->video_url,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            if ($cultural->gambar && file_exists(public_path($cultural->gambar))) {
                unlink(public_path($cultural->gambar));
            }
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($cultural->gambar && file_exists(public_path($cultural->gambar))) {
                unlink(public_path($cultural->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_cultural_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/cultural-diversity');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/cultural-diversity/' . $filename;
        }

        $cultural->update($data);
        return redirect()->route('admin.cultural-diversity.index')
            ->with('success', 'Data Cultural Diversity berhasil diupdate!');
    }

    public function destroy($id)
    {
        $cultural = CulturalDiversity::findOrFail($id);
        if ($cultural->gambar && file_exists(public_path($cultural->gambar))) {
            unlink(public_path($cultural->gambar));
        }
        $cultural->delete();
        return redirect()->route('admin.cultural-diversity.index')
            ->with('success', 'Data Cultural Diversity berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $cultural = CulturalDiversity::findOrFail($id);
        $cultural->status = !$cultural->status;
        $cultural->save();
        return response()->json(['success' => true, 'status' => $cultural->status]);
    }
}

