<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicDestinasiController extends Controller
{
    // Halaman utama destinasi
    public function index()
    {
        return view('destinasi.index');
    }
}
