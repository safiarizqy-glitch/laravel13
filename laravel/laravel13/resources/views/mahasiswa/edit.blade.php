<!DOCTYPE html>
<html>
<head>
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h1>Edit Mahasiswa</h1>
    <form action="{{ route('mahasiswa.update', $prodi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Prodi</label>

            <select name="prodi_id">

                @foreach($prodis as $prodi)

                <option value="{{ $prodi->id }}"
                    {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>

                    {{ $prodi->nama_prodi }}

                </option>

                @endforeach

            </select>

        </div>

        <br>
        <div>
            <label>NIM</label>
            <input type="text" name="nim" value="{{ $mahasiswa->nim }}">
        </div>
        <br>
        <div>
            <label>Nama</label>
            <input type="text"  name="nama" value="{{ $mahasiswa->nama }}">

        </div>
        <br>
        <div>
            <label>Alamat</label>
            <textarea name="alamat" cols="20" rows="5">{{ $mahasiswa->alamat }}</textarea>
        </div>
        <br>
        <button type="submit">
            Update
        </button>
    </form>
</body>
</html>