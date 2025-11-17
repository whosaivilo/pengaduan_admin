<?php
namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Media;
use App\Models\Pengaduan;
use App\Models\TindakLanjut;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Jika Anda sudah menerapkan otentikasi

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
        $semua_warga    = Warga::all();
        $semua_kategori = KategoriPengaduan::all();

        return view('pages.pengaduan.create', compact('semua_warga', 'semua_kategori'));
    }

    public function show($pengaduan_id)
    {
        $pengaduan = Pengaduan::with(['warga','media'])->findOrFail($pengaduan_id);
        return view('pages.pengaduan.show', compact('pengaduan'));
    }

    public function update(Request $request, $pengaduan_id)
    {
        // 1. Cari Pengaduan
        $pengaduan = Pengaduan::findOrFail($pengaduan_id);

        // 2. VALIDASI DATA STATUS DAN CATATAN
        $request->validate([
            'status'                => 'required|in:Baru,Diproses,Selesai',
            'catatan_tindak_lanjut' => 'nullable|string|max:500',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        // 3. (OPSIONAL) SIMPAN RIWAYAT TINDAK LANJUT
        if ($request->filled('catatan_tindak_lanjut')) {

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

        return redirect()->route('pengaduan.show', $pengaduan_id)
            ->with('success', 'Status pengaduan berhasil diperbarui menjadi **' . $pengaduan->status . '**.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'warga_id'       => 'required|integer|exists:warga,warga_id',
            'kategori_id'    => 'required|integer|exists:kategori_pengaduan,kategori_id',
            'deskripsi'      => 'required|string',
            'lokasi_text'    => 'required|string|max:255',
            'rt'             => 'required|digits_between:1,3',
            'rw'             => 'required|digits_between:1,3',
            'lampiran_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. GENERATE NOMOR TIKET UNIK (Koreksi Panjang)
        $nomorTiket = 'PND' . now()->format('dHi') . Str::random(2);

        // 5. SIMPAN DATA KE DATABASE
        $pengaduan = Pengaduan::create([
            'nomor_tiket'    => $nomorTiket,
            'warga_id'       => $validatedData['warga_id'],
            'kategori_id'    => $validatedData['kategori_id'],
            'deskripsi'      => $validatedData['deskripsi'],
            'lokasi_text'    => $validatedData['lokasi_text'],
            'rt'             => $validatedData['rt'],
            'rw'             => $validatedData['rw'],
            'lampiran_bukti' => null,
            'status'         => 'Baru',
        ]);

        //2. Upload lampiran_bukti ke tabel media
        if ($request->hasFile('lampiran_bukti')) {
            $file = $request->file('lampiran_bukti');
            $path = $file->store('lampiran_pengaduan', 'public');

            Media::create([
                'pengaduan_id' => $pengaduan->pengaduan_id,
                'path_file'    => "storage/" . $path,
                'tipe_file'    => $file->getClientMimeType(),
            ]);
        }

        // 6. REDIRECT & FLASH DATA
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan dengan nomor tiket ' . $nomorTiket . ' berhasil diajukan!');
    }

    public function destroy($pengaduan_id)
    {
        $pengaduan = Pengaduan::with('media')->findOrFail($pengaduan_id);

        // 2. HAPUS FILE TERTANAM
        foreach ($pengaduan->media as $media) {
            Storage::delete(str_replace('storage/', 'public/', $media->path_file));
            $media->delete();
        }

        // 3. HAPUS DATA DARI DATABASE
        $pengaduan->delete();

        // 4. REDIRECT & FLASH DATA
        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan dengan nomor tiket **' . $pengaduan_id . ' berhasil dihapus, dan lampiran bukti telah dihapus!');
    }

}
