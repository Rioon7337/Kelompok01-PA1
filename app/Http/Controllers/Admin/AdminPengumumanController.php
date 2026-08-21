<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_terbit' => 'nullable|date',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'isi' => $request->isi,
            'isi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->isi),
            'tanggal_terbit' => $request->tanggal_terbit ?? now(),
            'status' => $request->has('status') ? 1 : 0
        ];

        // SIMPAN GAMBAR KE PUBLIC/IMAGE/PENGUMUMAN
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_pengumuman_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            // Buat folder jika belum ada
            $destinationPath = public_path('image/pengumuman');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/pengumuman/' . $filename;
        }

        Pengumuman::create($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_terbit' => 'nullable|date',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'isi' => $request->isi,
            'isi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->isi),
            'tanggal_terbit' => $request->tanggal_terbit ?? $pengumuman->tanggal_terbit,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($pengumuman->gambar && file_exists(public_path($pengumuman->gambar))) {
                unlink(public_path($pengumuman->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_pengumuman_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/pengumuman');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/pengumuman/' . $filename;
        }

        $pengumuman->update($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        
        // Hapus file gambar
        if ($pengumuman->gambar && file_exists(public_path($pengumuman->gambar))) {
            unlink(public_path($pengumuman->gambar));
        }
        
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->status = !$pengumuman->status;
        $pengumuman->save();
        
        return response()->json(['success' => true, 'status' => $pengumuman->status]);
    }
}

