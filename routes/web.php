<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
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

Route::middleware(['auth','admin'])->prefix('admin')->group(function() {


    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::resource('jurusan', JurusanController::class);

    Route::resource('prodi', ProdiController::class);

    Route::resource('mahasiswa', MahasiswaController::class);

    

});


Route::middleware(['auth'])->prefix('mahasiswa')->group(function() {
   
   
   Route::get('/biodata',[BiodataController::class,'index']);
   

});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
