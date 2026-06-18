<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
    $jurusans = Jurusan::all();

    return view('jurusan.index', [
        'jurusans' => $jurusans,
        'title'    => 'Data Jurusan'
    ]);
    }
    

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        Jurusan:: create ([
            'nama_jurusan' => $request->nama_jurusan
        ]);

        return redirect()->route('jurusan.index');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrfail($id);

        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrfail($id);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan
        ]);

        return redirect()->route('jurusan.index');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrfail($id);
        
        $jurusan->delete();

        return redirect()->route('jurusan.index');
    }
}
