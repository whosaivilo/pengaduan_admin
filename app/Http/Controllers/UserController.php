<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        //1. Validasi Data
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        //2. Hash Password
        $validated['password'] = Hash::make($request->password);

        //3. Simpan Data
        User::create($validated);

        return redirect()->route('user.index')->with('success', 'User ' . $validated['name'] . ' berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Terapkan User::findOrfail($id) [cite: 15]
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            // Rule unique email: Wajib mengabaikan user dengan ID saat ini ($user->id)
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        // 2. BLOK IF PERTAMA: Tambahkan aturan Password HANYA JIKA field diisi di form
        if ($request->filled('password')) {
            // Jika password diisi, terapkan semua aturan password
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        // 3. JALANKAN VALIDASI dengan aturan yang sudah diperbarui
        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            // HASH password baru sebelum diupdate
            $validated['password'] = Hash::make($request->password);
        } else {
            // Hapus field password dari $validated agar tidak diupdate
            unset($validated['password']);
        }

        // 5. UPDATE DATA
        // $validated sekarang hanya berisi: {name, email} ATAU {name, email, password (hashed)}
        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'Data user ' . $user->name . ' berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data user ' . $user->name . ' berhasil dihapus!');
    }
}
