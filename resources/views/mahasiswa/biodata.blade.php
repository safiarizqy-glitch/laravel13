@extends('layout.app')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Dashboard Mahasiswa
        </h1>

    </div>

    <!-- Card Selamat Datang -->
    <div class="row">

        <div class="col-lg-12">

            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Selamat Datang

                    </h6>

                </div>

                <div class="card-body">

                    <h5>{{ $mahasiswa->nama }}</h5>

                    <p>
                        Selamat datang di Sistem Informasi Akademik.
                        Berikut adalah informasi akademik Anda.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Biodata -->
    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Biodata Mahasiswa

                    </h6>

                </div>

                <div class="card-body">

                    <div class="text-center mb-4">

                        <i class="fas fa-user-circle fa-7x text-secondary"></i>

                    </div>

                    <table class="table table-bordered">

                        <tr>

                            <th width="200">NIM</th>

                            <td>{{ $mahasiswa->nim }}</td>

                        </tr>

                        <tr>

                            <th>Nama</th>

                            <td>{{ $mahasiswa->nama }}</td>

                        </tr>

                        <tr>

                            <th>Program Studi</th>

                            <td>{{ $mahasiswa->prodi->nama_prodi }}</td>

                        </tr>

                        <tr>

                            <th>Jurusan</th>

                            <td>{{ $mahasiswa->prodi->jurusan->nama_jurusan }}</td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection