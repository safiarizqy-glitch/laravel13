
@extends('layout.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Jurusan</h1>
    <p class="mb-4">
        Daftar jurusan yang tersedia pada sistem akademik.
    </p>

    <!-- Data Jurusan -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Jurusan
            </h6>

            <a href="{{ route('jurusan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Tambah Jurusan
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead class="thead-light">
                        <tr>
                            <th width="80">No</th>
                            <th>Nama Jurusan</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                           @foreach($jurusans as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_jurusan }}</td>
            <td>

                <a href="{{ route('jurusan.edit', $item->id) }}""   class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form action="{{ route('jurusan.destroy', $item->id) }}"
                      method="POST" style="display:inline;">

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