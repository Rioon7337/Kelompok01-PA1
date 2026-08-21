<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Pesan Baru dari Form Kontak</h2>
    <p><strong>Nama:</strong> {{ $nama }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Telepon:</strong> {{ $telepon }}</p>
    <p><strong>Subjek:</strong> {{ $subjek }}</p>
    <hr>
    <p><strong>Pesan:</strong></p>
    <p>{{ $pesan }}</p>
</body>
</html>
