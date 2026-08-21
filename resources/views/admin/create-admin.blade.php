@extends('layouts.admin')

@section('title', 'Tambah Admin')

@section('content')

<h2 style="margin-bottom:20px;">Tambah Admin Baru</h2>

@if ($errors->any())
    <div style="background:red; color:white; padding:10px; margin-bottom:15px; border-radius:5px;">

        <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
@endif

<form action="{{ route('admin.store') }}" method="POST">

    @csrf

    <div style="margin-bottom:15px;">
        <label>Nama</label><br>
        <input type="text" name="name" required
        style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Email</label><br>
        <input type="email" name="email" required
        style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Password</label><br>
        <input type="password" name="password" required
        style="width:100%; padding:10px;">
    </div>

    <button type="submit" class="btn-primary">
        Tambah Admin
    </button>

</form>

@endsection