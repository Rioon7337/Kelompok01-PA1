<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminAgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::latest()->paginate(10);
        return view('admin.agenda.index', compact('agenda'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'lokasi' => $request->lokasi,
            'penyelenggara' => $request->penyelenggara,
            'status' => $request->has('status') ? 1 : 0
        ];

        // SIMPAN GAMBAR KE PUBLIC/IMAGE/AGENDA (SEPERTI GALERI)
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_agenda_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            // Buat folder jika belum ada
            $destinationPath = public_path('image/agenda');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/agenda/' . $filename;
        }

        Agenda::create($data);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'judul_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->judul),
            'deskripsi' => $request->deskripsi,
            'deskripsi_en' => \App\Helpers\TranslateHelper::translateToEnglish($request->deskripsi),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'lokasi' => $request->lokasi,
            'penyelenggara' => $request->penyelenggara,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($agenda->gambar && file_exists(public_path($agenda->gambar))) {
                unlink(public_path($agenda->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_agenda_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('image/agenda');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['gambar'] = 'image/agenda/' . $filename;
        }

        $agenda->update($data);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diupdate!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        
        // Hapus file gambar
        if ($agenda->gambar && file_exists(public_path($agenda->gambar))) {
            unlink(public_path($agenda->gambar));
        }
        
        $agenda->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->status = !$agenda->status;
        $agenda->save();
        
        return response()->json(['success' => true, 'status' => $agenda->status]);
    }
}

