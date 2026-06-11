<!DOCTYPE html>
<html>
<head>
    <title>Tambah Jurusan</title>
</head>
<body>

    <h1>Tambah Jurusan</h1>

    <form action="{{ route('jurusan.index') }}" method="POST">

        @csrf

        <input type="text"
               name="nama_jurusan"
               placeholder="Nama Jurusan">

        <button type="submit">
            Simpan
        </button>

    </form>

</body>
</html>