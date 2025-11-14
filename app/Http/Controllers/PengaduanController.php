<?php
namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Jika Anda sudah menerapkan otentikasi

// Untuk upload file
class PengaduanController extends Controller
{

    public function index() //[route: pengaduan.index]
    {
        // Mengambil semua data pengaduan, sekaligus memuat (with('warga')) data pelapor untuk efisiensi
        $semua_pengaduan = Pengaduan::with('warga')->latest()->get();

        // Mengirim data ke view
        return view('pages.pengaduan.index', compact('semua_pengaduan'));
    }

    public function create()
    {
        $semua_warga = Warga::all();
        return view('pages.pengaduan.create', compact('semua_warga'));
    }

    /**
     * Display the specified resource.
     */
    public function show($pengaduan_id)
    {
        // Ambil data pengaduan, termasuk data warga dan kategori  (relasi)
        $pengaduan = Pengaduan::with('warga')->findOrFail($pengaduan_id);

        // Tampilkan view detail (misalnya resources/views/admin/pengaduan/show.blade.php)
        return view('pages.pengaduan.show', compact('pengaduan'));
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
        // 1. Cari Pengaduan
        $pengaduan = Pengaduan::findOrFail($pengaduan_id);

        // 2. VALIDASI DATA STATUS DAN CATATAN
        $request->validate([
            // Validasi ini memastikan status baru valid
            'status'                => 'required|in:Baru,Diproses,Selesai',
            // Catatan Tindak Lanjut tidak wajib diisi (nullable)
            'catatan_tindak_lanjut' => 'nullable|string|max:500',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        // 3. (OPSIONAL) SIMPAN RIWAYAT TINDAK LANJUT
        // Disarankan: Buat entri baru di tabel Tindak Lanjut jika ada catatan
        if ($request->filled('catatan_tindak_lanjut')) {
            // Catatan: Asumsi Anda akan mengisi kolom 'petugas' dari sesi Auth
            TindakLanjut::create([
                'pengaduan_id' => $pengaduan->pengaduan_id,
                'petugas'      => 'Admin System', // Ganti dengan Auth::user()->name jika sudah diimplementasikan
                'aksi'         => 'Update Status',
                'catatan'      => $request->catatan_tindak_lanjut,
            ]);
        }

        // 4. UPDATE STATUS UTAMA Pengaduan
        $pengaduan->status = $request->status;
        $pengaduan->save();

        // 5. REDIRECT & FLASH DATA
        return redirect()->route('pengaduan.show', $pengaduan_id)
            ->with('success', 'Status pengaduan berhasil diperbarui menjadi **' . $pengaduan->status . '**.');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'warga_id'       => 'required|integer|exists:warga,warga_id',
            'judul'          => 'required|string|max:255',
            'kategori_id'    => 'required|integer|in:1,2,3',
            'deskripsi'      => 'required|string',
            'lokasi_text'    => 'required|string|max:255',
            'rt'             => 'required|digits_between:1,3',
            'rw'             => 'required|digits_between:1,3',
            'lampiran_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $wargaId = $validatedData['warga_id']; // Ganti dengan logika otentikasi jika ada

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

}
