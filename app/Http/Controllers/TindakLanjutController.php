<?php
namespace App\Http\Controllers;


use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TindakLanjutController extends Controller
{
    /** Menampilkan daftar Tindak Lanjut (READ: Index) */
    public function index()
    {
        // Biasanya akan menampilkan daftar Tindak Lanjut untuk semua pengaduan atau pengaduan tertentu.
        $tindakLanjut = TindakLanjut::all();
        return view('pages.tindak_lanjut.index', compact('tindakLanjut'));
    }

    /** Menampilkan form tambah Tindak Lanjut (CREATE Form) */
    public function create()
    {
        // Di sini Anda bisa mengambil data Pengaduan yang akan ditindak lanjuti
        return view('pages.tindak_lanjut.create');
    }

    /** Menyimpan Tindak Lanjut baru (CREATE Store) */
    public function store(Request $request)
    {
        // 1. Validasi: Pastikan pengaduan_id ada dan field aksi/catatan diisi
        $validated = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,pengaduan_id',
            'petugas'      => 'required|string|max:100', // Petugas yang melakukan tindak lanjut
            'aksi'         => 'required|string',
            'catatan'      => 'nullable|string',
        ]);

        // 2. Simpan Data
        TindakLanjut::create($validated);

        return redirect()->route('tindak_lanjut.index')->with('success', 'Tindak Lanjut berhasil dicatat.');
    }


    public function destroy($id)
    {
        $tindakLanjut = TindakLanjut::findOrFail($id);
        $tindakLanjut->delete();
        return redirect()->route('tindak_lanjut.index')->with('success', 'Tindak Lanjut berhasil dihapus.');
    }
}
