@extends('layouts.admin')

@section('content')

<div class="container">

    <h3>Pengaturan Kontak</h3>

    @if(session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
    @endif

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.kontak.update') }}"
          method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Alamat</label>
            <textarea class="form-control"
                      name="alamat"
                      rows="3">{{ $kontak->alamat ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text"
                   class="form-control"
                   name="telepon"
                   value="{{ $kontak->telepon ?? '' }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   class="form-control"
                   name="email"
                   value="{{ $kontak->email ?? '' }}">
        </div>
        <div class="mb-3">
            <label>Link Google Maps</label>
            <input type="text"
                   class="form-control"
                   name="link_maps"
                   value="{{ $kontak->link_maps ?? '' }}">
        </div>
        <button class="btn btn-primary">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
