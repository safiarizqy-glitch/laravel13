@extends('layout.app')
@section('content')

<div class="container-fluid">

                    <!-- Judul -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                            Dashboard Sistem Akademik
                        </h1>
                    </div>

                    <!-- Statistik -->
                    <div class="row">

                        <!-- Jurusan -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Jurusan
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                2
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-building fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Prodi -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Prodi
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                3
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mahasiswa -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Mahasiswa
                                            </div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                150
                                            </div>
                                        </div>

                                        <div class="col-auto">
                                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Informasi Sistem -->
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card shadow mb-4">

                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        Selamat Datang
                                    </h6>
                                </div>

                                <div class="card-body">

                                    <h5>Sistem Informasi Akademik</h5>

                                    <p>
                                        Sistem ini digunakan untuk mengelola data Jurusan,
                                        Program Studi, dan Mahasiswa.
                                    </p>

                                    <p>
                                        Gunakan menu pada sidebar untuk mengakses data:
                                    </p>

                                    <ul>
                                        <li>Data Jurusan</li>
                                        <li>Data Prodi</li>
                                        <li>Data Mahasiswa</li>
                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
@endsection