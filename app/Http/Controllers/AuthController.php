<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if(Auth::user()->role == 'admin')
            {
                return redirect('/admin/dashboard');
            }

            if(Auth::user()->role == 'mahasiswa')
            {
                return redirect('/mahasiswa/biodata');
            }
        }

        return back()
            ->withInput()
            ->with('error', 'Username atau Password salah');
    }

   
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}