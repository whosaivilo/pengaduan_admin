<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /** Menampilkan daftar Media (READ: Index) */
    public function index()
    {
        $media = Media::all();
        return view('pages.media.index', compact('media'));
    }

    /** Menyimpan Media baru (CREATE Store) */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'ref_table' => 'required|string',
            'ref_id' => 'required|integer',
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        // 2. Logic Upload File
        // ... (Kode upload file ke storage) ...

        // 3. Simpan Data
        Media::create($request->all());

        return redirect()->route('media.index')->with('success', 'File berhasil diunggah.');
    }

    // ... (Metode show, edit, update, destroy akan menyusul dan disesuaikan) ...
}
