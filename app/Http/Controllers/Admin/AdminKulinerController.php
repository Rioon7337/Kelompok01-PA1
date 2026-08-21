<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminKulinerController extends Controller
{
    public function index()
    {
        $data = Kuliner::latest()->paginate(10);
        return view('admin.Kuliner.index', compact('data'));
    }

    public function create()
    {
        return view('admin.Kuliner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'harga'           => 'nullable|string|max:100',
            'lokasi'          => 'nullable|string|max:255',
            'kontak'          => 'nullable|string|max:100',
            'urutan'          => 'nullable|integer',
            'status'          => 'nullable|boolean',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gambar_tambahan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'nama'       => $request->nama,
            'nama_en'    => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'deskripsi'  => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'harga'      => $request->harga,
            'lokasi'     => $request->lokasi,
            'kontak'     => $request->kontak,
            'urutan'     => $request->urutan ?? 0,
            'status'     => $request->has('status') ? 1 : 0,
        ];

        // Upload gambar utama
        if ($request->hasFile('gambar')) {
            $image    = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            $destPath = public_path('image/Kuliner');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image->move($destPath, $filename);
            $data['gambar'] = 'image/Kuliner/' . $filename;
        }

        // Upload gambar tambahan
        if ($request->hasFile('gambar_tambahan')) {
            $image2    = $request->file('gambar_tambahan');
            $filename2 = time() . '_2_' . Str::slug($request->nama) . '.' . $image2->getClientOriginalExtension();
            $destPath  = public_path('image/Kuliner');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image2->move($destPath, $filename2);
            $data['gambar_tambahan'] = 'image/Kuliner/' . $filename2;
        }

        Kuliner::create($data);

        return redirect()->route('admin.Kuliner.index')
            ->with('success', 'Data Kuliner berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Kuliner::findOrFail($id);
        return view('admin.Kuliner.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $Kuliner = Kuliner::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'harga'           => 'nullable|string|max:100',
            'lokasi'          => 'nullable|string|max:255',
            'kontak'          => 'nullable|string|max:100',
            'urutan'          => 'nullable|integer',
            'status'          => 'nullable|boolean',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gambar_tambahan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $updateData = [
            'nama'         => $request->nama,
            'nama_en'      => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'deskripsi'    => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'harga'        => $request->harga,
            'lokasi'       => $request->lokasi,
            'kontak'       => $request->kontak,
            'urutan'       => $request->urutan ?? 0,
            'status'       => $request->has('status') ? 1 : 0,
        ];

        // Hapus gambar utama
        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            $updateData['gambar'] = null;
        }

        // Hapus gambar tambahan
        if ($request->has('hapus_gambar_tambahan') && $request->hapus_gambar_tambahan == 1) {
            $updateData['gambar_tambahan'] = null;
        }

        // Upload gambar utama baru
        if ($request->hasFile('gambar')) {
            $image    = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            $destPath = public_path('image/Kuliner');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image->move($destPath, $filename);
            $updateData['gambar'] = 'image/Kuliner/' . $filename;
        }

        // Upload gambar tambahan baru
        if ($request->hasFile('gambar_tambahan')) {
            $image2    = $request->file('gambar_tambahan');
            $filename2 = time() . '_2_' . Str::slug($request->nama) . '.' . $image2->getClientOriginalExtension();
            $destPath  = public_path('image/Kuliner');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image2->move($destPath, $filename2);
            $updateData['gambar_tambahan'] = 'image/Kuliner/' . $filename2;
        }

        $Kuliner->update($updateData);

        return redirect()->route('admin.Kuliner.index')
            ->with('success', 'Data Kuliner berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $Kuliner = Kuliner::findOrFail($id);
        $Kuliner->delete();

        return redirect()->route('admin.Kuliner.index')
            ->with('success', 'Data Kuliner berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $Kuliner = Kuliner::findOrFail($id);
        $Kuliner->status = !$Kuliner->status;
        $Kuliner->save();

        return response()->json(['success' => true, 'status' => $Kuliner->status]);
    }
}
