<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminFasilitasController extends Controller
{
    public function index()
    {
        $data = Fasilitas::latest()->paginate(10);
        return view('admin.fasilitas.index', compact('data'));
    }

   public function create()
    {
    $jenisList = [
        'akomodasi',
        'kuliner',
        'pusat informasi',
        'toilet',
        'parkir',
        'akses jalan',
        'pemandu lokal'
    ];

    return view('admin.fasilitas.create', compact('jenisList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = [
            'nama' => $request->nama,
            'nama_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'kontak' => $request->kontak,
            'urutan' => $request->urutan ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            
            // Simpan ke public/image/fasilitas/
            $destinationPath = public_path('image/fasilitas');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);
            $data['gambar'] = 'image/fasilitas/' . $filename;
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function edit($id)
    {
    $data = Fasilitas::findOrFail($id);

    $jenisList = [
        'akomodasi',
        'kuliner',
        'pusat informasi',
        'toilet',
        'parkir',
        'akses jalan',
        'pemandu lokal'
    ];

    return view('admin.fasilitas.edit', compact('data', 'jenisList'));
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'nama_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'kontak' => $request->kontak,
            'urutan' => $request->urutan ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ];

        // Handle hapus gambar
        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            $updateData['gambar'] = null;
        }

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            
            // Simpan ke public/image/fasilitas/
            $destinationPath = public_path('image/fasilitas');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);
            $updateData['gambar'] = 'image/fasilitas/' . $filename;
        }

        $fasilitas->update($updateData);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->status = !$fasilitas->status;
        $fasilitas->save();

        return response()->json(['success' => true, 'status' => $fasilitas->status]);
    }
}
