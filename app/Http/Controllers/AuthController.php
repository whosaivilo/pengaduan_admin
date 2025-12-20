<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    //Memproses halaman login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        // dd($request->all());
        //Cek user berdasarkan email
        $users = User::where('email', $request->email)->first();

        if ($users && Hash::check($request->password, $users->password)) {

            Auth::login($users);
            session(['last_login' => now()]);
            return redirect()->route('dashboard')->with('success', "Login Berhasil! Selamat datang " . $users->name);
        }
        return redirect()->route('auth')->with('error', 'Login Gagal! Periksa kembali username dan password Anda.'); //Login gagal
    }

    public function daftar()
    {
        return view('pages.auth.register');
    }

    //Proses halaman register
    public function register(Request $request)
    {
        //Validasi input
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email', //Email harus unik
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi',
            'email.required'     => 'Email wajib diisi',
            'email.email'        => 'Format email tidak valid',
            'email.unique'       => 'Email sudah terdaftar',
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        //dd($request->all());
        $users = [
            'name'     => $request->name,
            'email'    => $validated['email'],
            'password' => Hash::make($request->password),

        ];
        // Simpan Data ke Tabel User
        User::create($users);

        //Redirect ke halaman login dengan pesan sukses
        return redirect()->route('daftar')->with('success', 'Pendaftaran Berhasil! Silakan login ulang!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth');
    }

}
