<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::with('jurusan')->get();

        return view('prodi.index', compact('prodis')); 
    }

    public function create()
    {
        $jurusans = Jurusan::all();

        return view('prodi.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        Prodi::create([
            'jurusan_id' => $request->jurusan_id,
            'nama_prodi' => $request->nama_prodi
        ]);
        
        return redirect()->route('prodi.index');
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id); 
        $jurusans = Jurusan::all();
        
        return view('prodi.edit', compact('prodi', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id); 

        $prodi->update([
            'jurusan_id' => $request->jurusan_id,
            'nama_prodi' => $request->nama_prodi,
        ]);

        return redirect()->route('prodi.index');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id); 

        $prodi->delete();

        return redirect()->route('prodi.index');
    }
}