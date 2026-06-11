<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Route Setelah Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    Route::resource('admin/jurusan', JurusanController::class);

    Route::resource('admin/prodi', ProdiController::class);

    Route::resource('admin/mahasiswa', MahasiswaController::class);

    /*
    |--------------------------------------------------------------------------
    | Mahasiswa
    |--------------------------------------------------------------------------
    */

    Route::get('/mahasiswa/biodata', function () {
        return 'Halaman Biodata Mahasiswa';
    });

});