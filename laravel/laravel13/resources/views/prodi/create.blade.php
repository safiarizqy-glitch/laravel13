<!DOCTYPE html>
<html>
<head>
    <title>Tambah Prodi</title>
</head>
<body>

    <h1>Tambah Prodi</h1>

    <form action="{{ route('prodi.index')}}" method="POST">
        @csrf
        <div>
            <label>Jurusan</label>
            <select name="jurusan_id">

                @foreach($jurusans as $jurusan)

                <option value="{{ $jurusan->id }}">
                    {{ $jurusan->nama_jurusan }}
                </option>
                @endforeach
            </select>
        </div>
        <br>
        
        <div>

            <label>Nama Prodi</label>

            <input type="text"
                   name="nama_prodi">

        </div>

        <br>

        <button type="submit">
            Simpan
        </button>

    </form>

</body>
</html>