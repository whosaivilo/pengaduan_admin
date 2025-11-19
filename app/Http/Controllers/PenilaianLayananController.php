<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Models\PenilaianLayanan;
use App\Http\Controllers\Controller;

class PenilaianLayananController extends Controller
{
    public function index(Request $request)
    {
        $filterableColumns = ['rating'];
        $searchableColumns = ['komentar'];
        $semua_penilaian = PenilaianLayanan::with('pengaduan')
        ->filter($request, $filterableColumns)
        ->search($request, $searchableColumns)
        ->paginate(10)
        ->withQueryString()
        ->onEachSide(1);

        // Mengirim variabel ke view
        return view('pages.penilaian_layanan.index', compact('semua_penilaian'));
    }
    public function create()
    {
        $pengaduan = Pengaduan::where('status', 'selesai')
                                ->whereDoesntHave('penilaianLayanan')
                                ->get();

        return view('pages.penilaian_layanan.create', compact('pengaduan'));
    }

    public function show($id)
    {
        $penilaian = PenilaianLayanan::with(['pengaduan.tindak_lanjut'])
            ->findOrFail($id);

        return view('pages.penilaian_layanan.show', compact('penilaian'));
    }
    public function store(Request $request)
    {
        // 1. Validasi Input (Rating dan Foreign Key)
        $validatedData = $request->validate([
            'pengaduan_id' => [
                'required',
                'exists:pengaduan,pengaduan_id', // Memastikan ID Pengaduan ada
                'unique:penilaian_layanan,pengaduan_id',
            ],
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        // 2. Simpan Data ke Tabel penilaian_layanan
        PenilaianLayanan::create([
            'pengaduan_id' => $validatedData['pengaduan_id'],
            'rating' => $validatedData['rating'],
            'komentar' => $validatedData['komentar'],
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('penilaian.index')->with('success', 'Penilaian layanan berhasil disimpan!');
    }
}
