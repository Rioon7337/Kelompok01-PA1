<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontak;
use App\Mail\KontakMail;
use Illuminate\Support\Facades\Mail;

class PublicKontakController extends Controller
{
    public function index()
    {
        $kontak = Kontak::first();
        if (!$kontak) {
            $kontak = new Kontak();
        }
        return view('pages.kontak', compact('kontak'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'nama'    => 'required',
            'email'   => 'required|email',
            'subjek'  => 'required',
            'pesan'   => 'required',
        ]);

        try {
            Mail::to('ambaritatuktuktomokadmingeosit@gmail.com')->send(
                new KontakMail(
                    $request->nama,
                    $request->email,
                    $request->telepon ?? '-',
                    $request->subjek,
                    $request->pesan
                )
            );
            return back()->with('success', 'Pesan berhasil dikirim!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim pesan, pastikan konfigurasi email sudah benar.');
        }
    }
}
