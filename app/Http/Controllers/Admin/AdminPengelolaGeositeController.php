<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengelolaGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengelolaGeositeController extends Controller
{
    public function index()
    {
        $pengelolas = PengelolaGeosite::orderBy('urutan', 'asc')->get();
        return view('admin.pengelola_geosite.index', compact('pengelolas'));
    }

    public function create()
    {
        return view('admin.pengelola_geosite.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');
        $data['urutan'] = $request->urutan ?? 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_pengelola_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/pengelola');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['image'] = 'image/pengelola/' . $filename;
        }

        PengelolaGeosite::create($data);

        return redirect()->route('admin.pengelola-geosite.index')
            ->with('success', 'Data pengelola berhasil ditambahkan.');
    }

    public function edit(PengelolaGeosite $pengelolaGeosite)
    {
        return view('admin.pengelola_geosite.edit', compact('pengelolaGeosite'));
    }

    public function update(Request $request, PengelolaGeosite $pengelolaGeosite)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');
        $data['urutan'] = $request->urutan ?? 0;

        if ($request->hasFile('image')) {
            if ($pengelolaGeosite->image && file_exists(public_path($pengelolaGeosite->image))) {
                unlink(public_path($pengelolaGeosite->image));
            }
            $file = $request->file('image');
            $filename = time() . '_pengelola_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/pengelola');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $data['image'] = 'image/pengelola/' . $filename;
        }

        $pengelolaGeosite->update($data);

        return redirect()->route('admin.pengelola-geosite.index')
            ->with('success', 'Data pengelola berhasil diperbarui.');
    }

    public function destroy(PengelolaGeosite $pengelolaGeosite)
    {
        if ($pengelolaGeosite->image && file_exists(public_path($pengelolaGeosite->image))) {
            unlink(public_path($pengelolaGeosite->image));
        }
        
        $pengelolaGeosite->delete();

        return redirect()->route('admin.pengelola-geosite.index')
            ->with('success', 'Data pengelola berhasil dihapus.');
    }
}

