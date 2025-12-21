<?php
namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // [route: warga.index]
    {
        $filterableColumns = ['jenis_kelamin'];
        $searchableColumns = ['nama', 'agama', 'pekerjaan', 'telp', 'email'];
        $semua_warga       = Warga::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->withQueryString()
            ->onEachSide(1);
        return view('pages.warga.index', compact('semua_warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // [route: warga.store]
    {
        // 1. VALIDATION
        $validated = $request->validate([
            'no_ktp'        => 'required|unique:warga|digits:16',
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pekerjaan'     => 'required|string',
            'telp'          => 'required|max:15',
            'email'         => 'nullable|email|max:100',
        ], [
            'no_ktp.required'        => 'Nomor KTP wajib diisi.',
            'no_ktp.unique'          => 'Nomor KTP sudah terdaftar.',
            'no_ktp.digits'          => 'Nomor KTP harus terdiri dari 16 digit angka.',
            'nama.required'          => 'Nama wajib diisi.',
            'nama.string'            => 'Nama harus berupa teks.',
            'nama.max'               => 'Nama maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus dipilih antara Laki-laki atau Perempuan.',
            'agama.required'         => 'Agama wajib dipilih.',
            'pekerjaan.required'     => 'Pekerjaan wajib diisi.',
            'pekerjaan.string'       => 'Pekerjaan harus berupa teks.',
            'pekerjaan.max'          => 'Pekerjaan maksimal 100 karakter.',
            'telp.required'          => 'Nomor telepon wajib diisi.',
            'telp.string'            => 'Nomor telepon harus berupa teks.',
            'telp.max'               => 'Nomor telepon maksimal 15 karakter.',
            'email.email'            => 'Format email tidak valid.',
            'email.max'              => 'Email maksimal 100 karakter.',
        ]);

        // dd($validated);
        // 2. SIMPAN DATA
        Warga::create($validated);

        // 3. REDIRECT & FLASH DATA
        return redirect()->route('warga.index')->with('success', 'Data warga **' . $validated['nama'] . '** berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($warga_id)
    {
        $warga = Warga::findOrFail($warga_id);

        // Mengirim objek $warga ke view detail
        return view('pages.warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($warga_id) // [route: warga.edit]
    {

        $warga = Warga::findOrFail($warga_id);
        return view('pages.warga.edit', compact('warga'));
    }

    public function update(Request $request, $warga_id)
    {
        $warga = Warga::findOrFail($warga_id);

        $validated = $request->validate([
            'no_ktp'        => 'required|digits:16|unique:warga,no_ktp,' . $warga_id . ',warga_id',
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:20',
            'pekerjaan'     => 'required|string|max:50',
            'telp'          => 'required|string|max:15',
            'email'         => 'nullable|email',
        ]);

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga ' . $warga->nama . ' berhasil diperbarui!');
    }

    public function destroy($warga_id)
    {
        // 1. Cari data Warga yang akan dihapus
        $warga = Warga::findOrFail($warga_id);
        // $nama_warga = $warga->nama; // Simpan nama untuk Flash Data

        // 2. Hapus Data
        $warga->delete();

        // 3. REDIRECT & FLASH DATA (Wajib Tugas)
        return redirect()->route('warga.index')->with('success', 'Data warga **' . $warga->nama . '** berhasil dihapus!');
    }
}
