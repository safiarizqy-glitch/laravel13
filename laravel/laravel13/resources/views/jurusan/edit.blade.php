<!DOCTYPE html>
<html>
<head>
    <title>Edit Jurusan</title>
</head>
<body>

    <h1>Edit Jurusan</h1>

    <form action="{{ route('jurusan.update', $jurusan->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <input type="text"
               name="nama_jurusan"
               value="{{ $jurusan->nama_jurusan }}">

        <button type="submit">
            Update
        </button>

    </form>

</body>
</html>