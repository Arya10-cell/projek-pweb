<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Edit Pasien</title></head>
<body>
    <h1>Edit Pasien</h1>

    <form method="POST" action="{{ route('admin.pasien.update', $pasien) }}">
        @method('PUT')
        @include('admin.pasien._form')
        <button type="submit">Perbarui</button>
        <a href="{{ route('admin.pasien.index') }}">Batal</a>
    </form>
</body>
</html>