<?php
namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Media;
use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Jika Anda sudah menerapkan otentikasi

// Untuk upload file
class PengaduanController extends Controller
{

    public function index(Request $request) //[route: pengaduan.index]
    {
        $filterableColumns = ['status'];
        $searchableColumns = ['kategori', 'judul'];
        // Mengambil semua data pengaduan, sekaligus memuat (with('warga')) data pelapor untuk efisiensi
        $semua_pengaduan = Pengaduan::with('warga', 'kategori')
            ->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->paginate(10)
            ->withQueryString()
            ->onEachSide(1);

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
        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media'])->findOrFail($pengaduan_id);
        return view('pages.pengaduan.show', compact('pengaduan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'warga_id'       => 'required|integer|exists:warga,warga_id',
            'kategori_id'    => 'required|integer|exists:kategori_pengaduan,kategori_id',
            'judul'          => 'required|string|max 15',
            'deskripsi'      => 'required|string',
            'lokasi_text'    => 'required|string|max:255',
            'rt'             => 'required|digits_between:1,3',
            'rw'             => 'required|digits_between:1,3',
            'lampiran_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. GENERATE NOMOR TIKET UNIK (Koreksi Panjang)
        $nomorTiket = 'PND' . now()->format('dHi') . Str::random(2);

        // 2. Upload file bukti jika ada
        $fileNameToStore = null;
        if ($request->hasFile('lampiran_bukti')) {
            $file = $request->file('lampiran_bukti');
            // Path penyimpanan: storage/app/public/lampiran_pengaduan
            $path = $file->store('lampiran', 'public');
            // Kita hanya ambil nama file saja untuk disimpan di kolom lampiran_bukti
            $fileNameToStore = basename($path);
        }

        // 5. SIMPAN DATA KE DATABASE
        $pengaduan = Pengaduan::create([
            'nomor_tiket'    => $nomorTiket,
            'warga_id'       => $validatedData['warga_id'],
            'kategori_id'    => $validatedData['kategori_id'],
            'judul'          => $validatedData['judul'],
            'deskripsi'      => $validatedData['deskripsi'],
            'lokasi_text'    => $validatedData['lokasi_text'],
            'rt'             => $validatedData['rt'],
            'rw'             => $validatedData['rw'],
            'lampiran_bukti' => $fileNameToStore,
            'status'         => 'Baru',
        ]);

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
