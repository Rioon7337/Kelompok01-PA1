<h2>Tambah Admin Baru</h2>

<form action="{{ route('admin.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Nama">
    <br><br>

    <input type="email" name="email" placeholder="Email">
    <br><br>

    <input type="password" name="password" placeholder="Password">
    <br><br>

    <button type="submit">
        Tambah Admin
    </button>
</form>