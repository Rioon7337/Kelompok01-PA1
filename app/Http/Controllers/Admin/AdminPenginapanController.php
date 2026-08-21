<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penginapan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPenginapanController extends Controller
{
    public function index()
    {
        $data = Penginapan::latest()->paginate(10);
        return view('admin.penginapan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.penginapan.create');
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
            $destPath = public_path('image/penginapan');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image->move($destPath, $filename);
            $data['gambar'] = 'image/penginapan/' . $filename;
        }

        // Upload gambar tambahan
        if ($request->hasFile('gambar_tambahan')) {
            $image2    = $request->file('gambar_tambahan');
            $filename2 = time() . '_2_' . Str::slug($request->nama) . '.' . $image2->getClientOriginalExtension();
            $destPath  = public_path('image/penginapan');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image2->move($destPath, $filename2);
            $data['gambar_tambahan'] = 'image/penginapan/' . $filename2;
        }

        Penginapan::create($data);

        return redirect()->route('admin.penginapan.index')
            ->with('success', 'Data penginapan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Penginapan::findOrFail($id);
        return view('admin.penginapan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $penginapan = Penginapan::findOrFail($id);

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
            $destPath = public_path('image/penginapan');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image->move($destPath, $filename);
            $updateData['gambar'] = 'image/penginapan/' . $filename;
        }

        // Upload gambar tambahan baru
        if ($request->hasFile('gambar_tambahan')) {
            $image2    = $request->file('gambar_tambahan');
            $filename2 = time() . '_2_' . Str::slug($request->nama) . '.' . $image2->getClientOriginalExtension();
            $destPath  = public_path('image/penginapan');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $image2->move($destPath, $filename2);
            $updateData['gambar_tambahan'] = 'image/penginapan/' . $filename2;
        }

        $penginapan->update($updateData);

        return redirect()->route('admin.penginapan.index')
            ->with('success', 'Data penginapan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $penginapan->delete();

        return redirect()->route('admin.penginapan.index')
            ->with('success', 'Data penginapan berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        $penginapan->status = !$penginapan->status;
        $penginapan->save();

        return response()->json(['success' => true, 'status' => $penginapan->status]);
    }
}
