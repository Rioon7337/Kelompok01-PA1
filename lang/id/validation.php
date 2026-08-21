<?php

return [
    'required'    => 'Kolom :attribute wajib diisi.',
    'email'       => 'Format :attribute harus berupa alamat email yang valid.',
    'min'         => [
        'string'  => ':attribute minimal :min karakter.',
    ],
    'max'         => [
        'string'  => ':attribute maksimal :max karakter.',
        'file'    => ':attribute tidak boleh lebih dari :max kilobytes.',
    ],
    'unique'      => ':attribute sudah digunakan.',
    'confirmed'   => 'Konfirmasi :attribute tidak cocok.',
    'image'       => ':attribute harus berupa gambar.',
    'mimes'       => ':attribute harus berformat: :values.',
    'nullable'    => ':attribute boleh kosong.',
    'numeric'     => ':attribute harus berupa angka.',
    'string'      => ':attribute harus berupa teks.',
    'boolean'     => ':attribute harus berupa true atau false.',
    'date'        => ':attribute harus berupa tanggal yang valid.',
    'url'         => ':attribute harus berupa URL yang valid.',
    'in'          => ':attribute tidak termasuk dalam pilihan yang valid.',

    'attributes'  => [
        'nama'          => 'nama',
        'nama_en'       => 'nama (Inggris)',
        'deskripsi'     => 'deskripsi',
        'deskripsi_en'  => 'deskripsi (Inggris)',
        'judul'         => 'judul',
        'judul_en'      => 'judul (Inggris)',
        'konten'        => 'konten',
        'konten_en'     => 'konten (Inggris)',
        'gambar'        => 'gambar',
        'status'        => 'status',
        'email'         => 'email',
        'password'      => 'kata sandi',
    ],
];
