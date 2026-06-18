<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $title = 'Mahasiswa';
        $mahasiswas = Mahasiswa::with('prodi')->get();

        return view('mahasiswa.index', compact('mahasiswas','title'));
    }
    
    public function create()
    {
        $prodis = Prodi::all();

        return view('mahasiswa.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $user = User::create([
          'name' => $request->nama,
          'username' => $request->nim,
          'password' => '123456',
          'role' => 'mahasiswa',
        ]);
        Mahasiswa::create([
            'user_id' => $user->id,
            'prodi_id' => $request->prodi_id,
            'nim' => $request->nim,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('mahasiswa.index');
    }

    public function edit($id)
    {
        $title = 'Mahasiswa';
        $mahasiswa = Mahasiswa::findOrFail($id);

        $prodis = Prodi::all();

        return view('mahasiswa.edit', compact(
            'mahasiswa',
            'prodis',
            'title'
        ));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'prodi_id' => $request->prodi_id,
            'nim' => $request->nim,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return redirect('/mahasiswa');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->delete();

        return redirect('/mahasiswa');
    }
}