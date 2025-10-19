<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Jika Anda sudah menerapkan otentikasi
use Illuminate\Support\Str;

// Untuk upload file
class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil Data Statistik (untuk Card)
        $total_masuk       = Pengaduan::count();
        $belum_diproses    = Pengaduan::where('status', 'Baru')->count();
        $selesai_ditangani = Pengaduan::where('status', 'Selesai')->count();

        // 2. Ambil Data Tabel (Hanya 5 Terbaru)
        $pengaduan_terbaru = Pengaduan::with('warga')->latest()->take(5)->get();

        // 3. Kirim semua data ke view
        return view('admin.index', compact('total_masuk', 'belum_diproses', 'selesai_ditangani', 'pengaduan_terbaru'));
    }

    public function lihat() //[route: pengaduan.index]
    {
        // Mengambil semua data pengaduan, sekaligus memuat (with('warga')) data pelapor untuk efisiensi
        $semua_pengaduan = Pengaduan::with('warga')->latest()->get();

        // Mengirim data ke view
        return view('admin.pengaduan.index', compact('semua_pengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengaduan.create');
    }

    /**
     * Display the specified resource.
     */
    public function show($pengaduan_id)
    {
        // Ambil data pengaduan, termasuk data warga (relasi)
        $pengaduan = Pengaduan::with('warga')->findOrFail($pengaduan_id);

        // Tampilkan view detail (misalnya resources/views/admin/pengaduan/show.blade.php)
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $pengaduan_id)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduan_id);

        // VALIDASI untuk Tindak Lanjut (termasuk status baru)
        $request->validate([
            'catatan_tindak_lanjut' => 'nullable|string',
            'status'                => 'required|in:Baru,Diproses,Selesai',
        ]);

        // Simpan data Tindak Lanjut dan ubah status
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Status dan Tindak Lanjut berhasil diperbarui menjadi **' . $pengaduan->status . '**.');
    }
    // app/Http/Controllers/PengaduanController.php

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'judul'          => 'required|string|max:255',
            'kategori_id'    => 'required|integer|in:1,2,3',
            'deskripsi'      => 'required|string',
            'lokasi_text'    => 'required|string|max:255',
            'rt'             => 'required|digits_between:1,3',
            'rw'             => 'required|digits_between:1,3',
            'lampiran_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. TENTUKAN WARGA ID (Perbaikan FK)
        $wargaPertama = Warga::first();

        if (! $wargaPertama) {
            // Jika tidak ada data warga, batalkan dan kembalikan error
            return redirect()->back()->withInput()->with('error', 'Gagal: Tidak dapat menemukan data Warga. Mohon daftarkan Warga terlebih dahulu.');
        }
        $wargaId = $wargaPertama->warga_id;

        // 3. HANDLE FILE UPLOAD
        $filePath = null;
        if ($request->hasFile('lampiran_bukti')) {
            $filePath                        = $request->file('lampiran_bukti')->store('public/pengaduan');
            $validatedData['lampiran_bukti'] = str_replace('public/', 'storage/', $filePath);
        } else {
            $validatedData['lampiran_bukti'] = null;
        }

        // 4. GENERATE NOMOR TIKET UNIK (Koreksi Panjang)
        // Total 15 karakter (PND + dHi + 7 Random)
        $nomorTiket = 'PND' . now()->format('dHi') . Str::random(2);

        // 5. SIMPAN DATA KE DATABASE
        Pengaduan::create([
            'nomor_tiket'    => $nomorTiket,
            'warga_id'       => $wargaId,
            'kategori_id'    => $validatedData['kategori_id'],
            'judul'          => $validatedData['judul'],
            'deskripsi'      => $validatedData['deskripsi'],
            'lokasi_text'    => $validatedData['lokasi_text'],
            'rt'             => $validatedData['rt'],
            'rw'             => $validatedData['rw'],
            'lampiran_bukti' => $validatedData['lampiran_bukti'],
            'status'         => 'Baru',
        ]);

        // 6. REDIRECT & FLASH DATA
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan dengan nomor tiket **' . $nomorTiket . '** berhasil diajukan!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pengaduan_id)
    {
        $pengaduan   = Pengaduan::findOrFail($pengaduan_id);
        $nomor_tiket = $pengaduan->nomor_tiket; // Ambil nomor tiket untuk pesan sukses


        // 2. HAPUS FILE TERTANAM
        if ($pengaduan->lampiran_bukti) {
            $filePath = str_replace('storage/', 'public/', $pengaduan->lampiran_bukti);
            Storage::delete($filePath);
        }

        // 3. HAPUS DATA DARI DATABASE
        $pengaduan->delete();

        // 4. REDIRECT & FLASH DATA
        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan dengan nomor tiket **' . $nomor_tiket . '** berhasil dihapus, dan lampiran bukti telah dihapus!');
    }
    public function updateStatus(Request $request, $pengaduan_id)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduan_id);

        // 1. VALIDATION untuk data Tindak Lanjut
        $request->validate([
            'catatan_tindak_lanjut' => 'nullable|string',
            'status'                => 'required|in:Baru,Diproses,Selesai',
        ]);

        // 2. Simpan perubahan status
        $pengaduan->status = $request->status;

        $pengaduan->save(); // Simpan perubahan status

        // 3. Redirect dan Flash Data
        return redirect()->route('pengaduan.show', $pengaduan->pengaduan_id)
            ->with('success', 'Status pengaduan berhasil diperbarui menjadi **' . $pengaduan->status . '**!');
    }
}
