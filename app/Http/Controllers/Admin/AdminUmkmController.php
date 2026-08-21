<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminUmkmController extends Controller
{
    public function index()
    {
        $data = Umkm::latest()->paginate(10);
        return view('admin.umkm.index', compact('data'));
    }

    public function create()
    {
        return view('admin.umkm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'kontak' => 'nullable|regex:/^[0-9]{12,15}$/',
            'urutan' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ],[
            'kontak.regex' => 'Masukkan nomor telepon dengan 12-15 digit angka.',
        ]
        );

        $data = [
            'nama_usaha' => $request->nama_usaha,
            'nama_usaha_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'pemilik' => $request->pemilik ?? 'Admin',
            'alamat' => $request->lokasi ?? 'Desa Meat',
            'no_telepon' => $request->kontak ?? '-',
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'urutan' => $request->urutan ?? 0,
            'status' => $request->has('status') ? 'aktif' : 'nonaktif',
        ];

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('image/umkm');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);
            $data['foto_utama'] = 'image/umkm/' . $filename;
        }

        if ($request->hasFile('foto_tambahan')) {
            $image2 = $request->file('foto_tambahan');
            $filename2 = time() . '_2_' . Str::slug($request->nama) . '.' . $image2->getClientOriginalExtension();
            
            $destinationPath = public_path('image/umkm');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image2->move($destinationPath, $filename2);
            $data['foto_tambahan'] = 'image/umkm/' . $filename2;
        }

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = Umkm::findOrFail($id);
        // Mapping untuk form edit
        $data->nama = $data->nama_usaha;
        $data->lokasi = $data->alamat;
        $data->kontak = $data->no_telepon;
        $data->gambar = $data->foto_utama;
        // foto_tambahan dibiarkan bernama foto_tambahan
        return view('admin.umkm.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_tambahan' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $updateData = [
            'nama_usaha' => $request->nama,
            'nama_usaha_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->nama),
            'pemilik' => $request->pemilik ?? 'Admin',
            'alamat' => $request->lokasi ?? 'Desa Meat',
            'no_telepon' => $request->kontak ?? '-',
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'urutan' => $request->urutan ?? 0,
            'status' => $request->has('status') ? 'aktif' : 'nonaktif',
        ];

        // Handle hapus gambar utama
        if ($request->has('hapus_gambar') && $request->hapus_gambar == 1) {
            $updateData['foto_utama'] = null;
        }

        // Handle hapus foto tambahan
        if ($request->has('hapus_foto_tambahan') && $request->hapus_foto_tambahan == 1) {
            $updateData['foto_tambahan'] = null;
        }

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('image/umkm');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);
            $updateData['foto_utama'] = 'image/umkm/' . $filename;
        }

        // Handle upload foto tambahan baru
        if ($request->hasFile('foto_tambahan')) {
            $image2 = $request->file('foto_tambahan');
            $filename2 = time() . '_2_' . Str::slug($request->nama) . '.' . $image2->getClientOriginalExtension();
            
            $destinationPath = public_path('image/umkm');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image2->move($destinationPath, $filename2);
            $updateData['foto_tambahan'] = 'image/umkm/' . $filename2;
        }

        $umkm->update($updateData);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diupdate!');
    }

    public function destroy($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->delete();

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->status = $umkm->status == 'aktif' ? 'nonaktif' : 'aktif';
        $umkm->save();

        return response()->json(['success' => true, 'status' => $umkm->status]);
    }
}
