<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Geodiversitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminGeodiversitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Geodiversitas::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('tipe_geologi', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter tipe geologi
        if ($request->filled('tipe_geologi')) {
            $query->where('tipe_geologi', $request->tipe_geologi);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status == 'active' ? 1 : 0);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        $tipeOptions = ['batuan', 'mineral', 'fosil', 'formasi'];

        return view('admin.geodiversitas.index', compact('data', 'tipeOptions'));
    }

    public function create()
    {
        return view('admin.geodiversitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe_geologi' => 'required|in:batuan,mineral,fosil,formasi',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'usia_geologi' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'nama' => $request->nama,
            'nama_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'slug' => Str::slug($request->nama) . '-' . time(),
            'tipe_geologi' => $request->tipe_geologi,
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'lokasi' => $request->lokasi,
            'usia_geologi' => $request->usia_geologi,
            'status' => $request->has('status') ? 1 : 0,
            'views' => 0
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_geodiversitas_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/geodiversitas');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/geodiversitas/' . $filename;
        }

        Geodiversitas::create($data);
        return redirect()->route('admin.geodiversitas.index')
            ->with('success', 'Data Geodiversitas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Geodiversitas::findOrFail($id);
        return view('admin.geodiversitas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $geodiversitas = Geodiversitas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe_geologi' => 'required|in:batuan,mineral,fosil,formasi',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'usia_geologi' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'nama' => $request->nama,
            'nama_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'slug' => Str::slug($request->nama) . '-' . time(),
            'tipe_geologi' => $request->tipe_geologi,
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'lokasi' => $request->lokasi,
            'usia_geologi' => $request->usia_geologi,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            if ($geodiversitas->gambar && file_exists(public_path($geodiversitas->gambar))) {
                unlink(public_path($geodiversitas->gambar));
            }
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($geodiversitas->gambar && file_exists(public_path($geodiversitas->gambar))) {
                unlink(public_path($geodiversitas->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_geodiversitas_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/geodiversitas');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/geodiversitas/' . $filename;
        }

        $geodiversitas->update($data);
        return redirect()->route('admin.geodiversitas.index')
            ->with('success', 'Data Geodiversitas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $geodiversitas = Geodiversitas::findOrFail($id);
        if ($geodiversitas->gambar && file_exists(public_path($geodiversitas->gambar))) {
            unlink(public_path($geodiversitas->gambar));
        }
        $geodiversitas->delete();
        return redirect()->route('admin.geodiversitas.index')
            ->with('success', 'Data Geodiversitas berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $geodiversitas = Geodiversitas::findOrFail($id);
        $geodiversitas->status = !$geodiversitas->status;
        $geodiversitas->save();
        return response()->json(['success' => true, 'status' => $geodiversitas->status]);
    }
}

