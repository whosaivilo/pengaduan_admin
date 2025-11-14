<?php

namespace App\Http\Controllers;

use App\Models\PenilaiLayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenilaiLayananController extends Controller
{
    /** Menampilkan daftar Penilaian (READ: Index) */
    public function index()
    {
        $penilaian = PenilaiLayanan::all();
        return view('pages.penilai_layanan.index', compact('penilaian'));
    }

    /** Menampilkan form tambah Penilaian (CREATE Form) */
    public function create()
    {
        // Form ini biasanya diisi Warga setelah Pengaduan selesai, tapi untuk Admin CRUD:
        return view('pages.penilai_layanan.create');
    }

    /** Menyimpan Penilaian baru (CREATE Store) */
    public function store(Request $request)
    {
        // 1. Validasi: Pastikan rating diisi dan pengaduan_id ada
        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,pengaduan_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        // 2. Simpan Data
        PenilaiLayanan::create($request->all());

        return redirect()->route('penilai_layanan.index')->with('success', 'Penilaian Layanan berhasil dicatat.');
    }

    // ... (Metode show, edit, update, destroy akan menyusul dan disesuaikan) ...
}
