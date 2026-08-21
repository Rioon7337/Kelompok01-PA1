<?php

return [
    'required'    => 'The :attribute field is required.',
    'email'       => 'The :attribute must be a valid email address.',
    'min'         => [
        'string'  => 'The :attribute must be at least :min characters.',
    ],
    'max'         => [
        'string'  => 'The :attribute must not exceed :max characters.',
        'file'    => 'The :attribute must not exceed :max kilobytes.',
    ],
    'unique'      => 'The :attribute has already been taken.',
    'confirmed'   => 'The :attribute confirmation does not match.',
    'image'       => 'The :attribute must be an image.',
    'mimes'       => 'The :attribute must be a file of type: :values.',
    'nullable'    => 'The :attribute may be empty.',
    'numeric'     => 'The :attribute must be a number.',
    'string'      => 'The :attribute must be a string.',
    'boolean'     => 'The :attribute must be true or false.',
    'date'        => 'The :attribute must be a valid date.',
    'url'         => 'The :attribute must be a valid URL.',
    'in'          => 'The selected :attribute is invalid.',

    'attributes'  => [
        'nama'          => 'name',
        'nama_en'       => 'name (English)',
        'deskripsi'     => 'description',
        'deskripsi_en'  => 'description (English)',
        'judul'         => 'title',
        'judul_en'      => 'title (English)',
        'konten'        => 'content',
        'konten_en'     => 'content (English)',
        'gambar'        => 'image',
        'status'        => 'status',
        'email'         => 'email',
        'password'      => 'password',
    ],
];
