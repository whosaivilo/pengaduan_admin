<?php
namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // [route: warga.index]
    {
        $semua_warga = Warga::latest()->get();
        return view('admin.warga.index', compact('semua_warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warga.create');
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
            'agama'         => 'required|string',
            'pekerjaan'     => 'required|string',
            'telp'          => 'required|max:15',
            'email'         => 'nullable|email|max:100',
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
        return view('admin.warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($warga_id) // [route: warga.edit]
    {
        // 1. Ambil data Warga berdasarkan Primary Key (PK)
        //    findOrFail akan menampilkan 404 jika data tidak ditemukan
        $warga = Warga::findOrFail($warga_id);

        // 2. Tampilkan View Form Edit
        //    View ini sama dengan form create, tapi diisi data lama
        return view('admin.warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $warga_id) //[route: warga.update]
    {
        // 1. Cari data Warga yang akan diupdate
        $warga = Warga::findOrFail($warga_id);

        // 2. VALIDATION (Wajib Tugas)
        //    Penting: Tambahkan pengecualian unik untuk NIK (no_ktp)
        $validated = $request->validate([
            // Abaikan NIK (no_ktp) yang sedang diedit (PK adalah warga_id)
            'no_ktp'        => 'required|digits:16|unique:warga,no_ktp,' . $warga_id . ',warga_id',
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:20',
            'pekerjaan'     => 'required|string|max:50',
            'telp'          => 'required|string|max:15',
            'email'         => 'nullable|email',
        ]);

            // 3. Simpan Perubahan ke Database
            $warga->update($validated);

            // 4. REDIRECT & FLASH DATA (Wajib Tugas)
            return redirect()->route('warga.index')->with('success', 'Data warga **' . $warga->nama . '** berhasil diperbarui!');
        }

            /**
             * Remove the specified resource from storage.
             */
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
