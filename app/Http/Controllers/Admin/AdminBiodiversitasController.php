<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biodiversitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBiodiversitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Biodiversitas::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('status_keberadaan', 'LIKE', '%' . $request->search . '%');
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

        $kategoriOptions = ['flora', 'fauna', 'ekosistem'];

        return view('admin.biodiversitas.index', compact('data', 'kategoriOptions'));
    }

    public function create()
    {
        return view('admin.biodiversitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:flora,fauna,ekosistem',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'status_keberadaan' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
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
            'status_keberadaan' => $request->status_keberadaan,
            'status' => $request->has('status') ? 1 : 0,
            'views' => 0
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_biodiversitas_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/biodiversitas');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/biodiversitas/' . $filename;
        }

        Biodiversitas::create($data);
        return redirect()->route('admin.biodiversitas.index')
            ->with('success', 'Data Biodiversitas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Biodiversitas::findOrFail($id);
        return view('admin.biodiversitas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $biodiversitas = Biodiversitas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:flora,fauna,ekosistem',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'status_keberadaan' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
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
            'status_keberadaan' => $request->status_keberadaan,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            if ($biodiversitas->gambar && file_exists(public_path($biodiversitas->gambar))) {
                unlink(public_path($biodiversitas->gambar));
            }
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($biodiversitas->gambar && file_exists(public_path($biodiversitas->gambar))) {
                unlink(public_path($biodiversitas->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_biodiversitas_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/biodiversitas');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/biodiversitas/' . $filename;
        }

        $biodiversitas->update($data);
        return redirect()->route('admin.biodiversitas.index')
            ->with('success', 'Data Biodiversitas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $biodiversitas = Biodiversitas::findOrFail($id);
        if ($biodiversitas->gambar && file_exists(public_path($biodiversitas->gambar))) {
            unlink(public_path($biodiversitas->gambar));
        }
        $biodiversitas->delete();
        return redirect()->route('admin.biodiversitas.index')
            ->with('success', 'Data Biodiversitas berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $biodiversitas = Biodiversitas::findOrFail($id);
        $biodiversitas->status = !$biodiversitas->status;
        $biodiversitas->save();
        return response()->json(['success' => true, 'status' => $biodiversitas->status]);
    }
}

