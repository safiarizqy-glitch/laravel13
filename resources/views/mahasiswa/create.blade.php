<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mahasiswa</title>
</head>
<body>
    <h1>Tambah Mahasiswa</h1>
    <form action="{{ route('mahasiswa.index') }}" method="POST">
        @csrf
        <div>
            <label>Prodi</label>

            <select name="prodi_id">
                @foreach($prodis as $prodi)

                <option value="{{ $prodi->id }}">
                    {{ $prodi->nama_prodi }}
                </option>
                @endforeach

            </select>
        </div>

        <br>
        <div>
            <label>NIM</label>
            <input type="text" name="nim">
        </div>
        <br>
        <div>
            <label>Nama</label>

            <input type="text" name="nama">
        </div>

        <br>

        <div>
            <label>Alamat</label>

            <textarea name="alamat" cols="20" rows="5"></textarea>
        </div>
        <br>
        <button type="submit">
            Simpan
        </button>
    </form>
</body>
</html>