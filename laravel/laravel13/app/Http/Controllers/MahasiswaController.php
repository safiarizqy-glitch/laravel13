<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa; 
use App\Models\Prodi;  
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('prodi')->get();

        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        $prodis = Prodi::all();

        return view('mahasiswa.create', compact('prodis'));
    } 

    public function store(Request $request)
    {
        Mahasiswa::create([
            'prodi_id' => $request->prodi_id,
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'alamat'   => $request->alamat,
        ]);

        return redirect()->route('mahasiswa.index');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id); 
        $prodis = Prodi::all();

        return view('mahasiswa.edit', compact(
            'mahasiswa', 
            'prodis'
        ));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id); 

        $mahasiswa->update([
            'prodi_id' => $request->prodi_id,
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'alamat'   => $request->alamat,
        ]);

        return redirect()->route('mahasiswa.index');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id); 
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index');
    }
} 