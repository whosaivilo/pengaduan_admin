<?php
namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriPengaduanController extends Controller
{
    public function index(Request $request)
    {
        $filterableColumns = ['prioritas'];
        $searchableColumns = ['nama', 'sla_hari'];
        $semua_kategori = KategoriPengaduan::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(5)
            ->withQueryString()
            ->onEachSide(1);
        return view('pages.kategori.index', compact('semua_kategori'));
    }
    public function create()
    {
        $semua_kategori = KategoriPengaduan::all();
        return view('pages.kategori.create', compact('semua_kategori'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100|unique:kategori_pengaduan,nama',
            'sla_hari'  => 'required|integer|min:1',
            'prioritas' => 'required|in:Tinggi,Sedang,Rendah',
        ]);

        KategoriPengaduan::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori pengaduan berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        return view('pages.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        // 1. VALIDASI: Tambahkan pengecualian UNIQUE
        $validated = $request->validate([
            'nama'      => 'required|string|max:100|unique:kategori_pengaduan,nama,' . $id . ',kategori_id', // <-- PERBAIKAN KRITIS
            'sla_hari'  => 'required|integer|min:1',
            'prioritas' => 'required|in:Urgent,Important,Not Urgent,Not Important',
        ], [
            'nama.required'      => 'Nama kategori wajib diisi',
            'nama.string'        => 'Nama kategori harus berupa teks',
            'nama.max'           => 'Nama kategori maksimal 100 karakter',
            'nama.unique'        => 'Nama kategori sudah ada dalam database',
            'sla_hari.required'  => 'SLA hari wajib diisi',
            'sla_hari.integer'   => 'SLA hari harus berupa angka',
            'sla_hari.min'       => 'SLA hari minimal 1 hari',
            'prioritas.required' => 'Prioritas wajib diisi',
            'prioritas.in'       => 'Prioritas tidak valid',
        ]);

        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori pengaduan berhasil dihapus.');
    }
}
