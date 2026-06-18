<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    public function index(){
        $title = 'Biodata';
        $mahasiswa = Auth::user()->mahasiswa;
        return view('mahasiswa.biodata', compact('mahasiswa','title'));
    }
}