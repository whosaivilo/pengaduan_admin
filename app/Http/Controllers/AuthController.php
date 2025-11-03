<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
            // 'name'     => 'required|string|max:100',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ] ,[
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        // dd($request->all());

        // if ($request->email == 'theresaoliviaa@gmail.com' && $request->password == 'There123') {
        //     // Simpan data user ke session
        //     $request->session()->put('user', [
        //         // 'name'  => $request->name,
        //         'email' => $request->email,

        //     ]);

        //     return redirect()->route('dashboard')->with('success', "Login Berhasil! Selamat datang " . $request->email);
        // } else {
        //     return redirect()->back()->with('error', 'Login Gagal! Periksa kembali username dan password Anda.');
        // }
        //Cek user berdasarkan email
        $users = User::where('email', $request->email)->first();

        if ($users && Hash::check($request->password, $users->password)) {
            Auth::login($users);

            return redirect()->route('dashboard')->with('success', "Login Berhasil! Selamat datang " . $users->email);
        }
            return redirect()->back()->with('error', 'Login Gagal! Periksa kembali username dan password Anda.'); //Login gagal
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
            'name'   => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email', //Email harus unik
            'password' => 'required|min:6',
        ]);

        // dd($validated);
        $users = [
            'name'     => $request->name,
            'email'    => $validated['email'],
            'password' => Hash::make($request->password),

        ];
        // Simpan Data ke Tabel User
        User::create($users);

        //Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran Berhasil! Silakan login ulang!');
    }
}

