@extends('layout.app')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Data Mahasiswa</h1>
        <p class="mb-4">
            Daftar mahasiswa yang terdaftar pada sistem akademik.
        </p>

        <!-- Data Mahasiswa -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Data Mahasiswa
                </h6>

                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Mahasiswa
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Prodi</th>
                                <th>Alamat</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($mahasiswas as $item)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $item->nim }}</td>

                                    <td>{{ $item->nama }}</td>

                                    <td>
                                        {{ $item->prodi->nama_prodi }}
                                    </td>

                                    <td>{{ $item->alamat }}</td>

                                    <td>

                                        <a href="{{ route('mahasiswa.edit', $item->id) }}"" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>

                                        </form>

                                    </td>

                                </tr>
                            @endforeach





                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>
@endsection