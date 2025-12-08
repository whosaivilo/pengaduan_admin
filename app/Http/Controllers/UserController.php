<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filterableColumns = ['role'];
        $searchableColumns = ['name', 'email'];
        $users             = User::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->onEachSide(2)
            ->withQueryString();
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'            => 'required|string|in:admin,user',
        ]);

        // Hash password
        $validated['password'] = Hash::make($request->password);

        // Upload foto (jika ada)
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        }

        User::create($validated);

        return redirect()->route('user.index')
            ->with('success', 'User ' . $validated['name'] . ' berhasil ditambahkan!');
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
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'            => 'required|in:admin,user',
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
        if ($request->hasFile('profile_picture')) {

            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $validated['profile_picture'] = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        }

        // 5. UPDATE DATA
        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'Data user ' . $user->name . ' berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data user ' . $user->name . ' berhasil dihapus!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();      // Hapus semua session
        $request->session()->regenerateToken(); // Cegah CSRF

        // Redirect ke halaman login
    }
}
