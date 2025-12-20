<?php
namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Media;
use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{

    public function index(Request $request) //[route: pengaduan.index]
    {
        $filterableColumns = ['status'];
        $searchableColumns = ['kategori', 'judul'];
        $semua_pengaduan   = Pengaduan::with('warga', 'kategori')
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
        // Pastikan relasi media di-load
        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media'])->findOrFail($pengaduan_id);
        return view('pages.pengaduan.show', compact('pengaduan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'warga_id'         => 'required|integer|exists:warga,warga_id',
            'kategori_id'      => 'required|integer|exists:kategori_pengaduan,kategori_id',
            'judul'            => 'required|string|max:255', // Maksimal diubah ke 255
            'deskripsi'        => 'required|string',
            'lokasi_text'      => 'required|string|max:255',
            'rt'               => 'required|digits_between:1,3',
            'rw'               => 'required|digits_between:1,3',
                                                                       // PERBAIKAN PENTING: Validasi multiple file upload (gunakan array [] di input form)
            'lampiran_bukti'   => 'nullable',                          // Boleh null jika user tidak upload
            'lampiran_bukti.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi setiap file dalam array
        ]);

        $nomorTiket = 'PND' . now()->format('dHi') . Str::random(2);

        $pengaduan = Pengaduan::create([
            'nomor_tiket' => $nomorTiket,
            'warga_id'    => $validatedData['warga_id'],
            'kategori_id' => $validatedData['kategori_id'],
            'judul'       => $validatedData['judul'],
            'deskripsi'   => $validatedData['deskripsi'],
            'lokasi_text' => $validatedData['lokasi_text'],
            'rt'          => $validatedData['rt'],
            'rw'          => $validatedData['rw'],
            'status'      => 'Diproses',
        ]);

        if ($request->hasFile('lampiran_bukti')) {
            $sortOrder = 1;

            foreach ($request->file('lampiran_bukti') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path     = $file->store('pengaduan', 'public');
                Media::create([
                    'ref_table'  => 'pengaduan',
                    'ref_id'     => $pengaduan->pengaduan_id,
                    'file_name'  => $fileName,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $sortOrder++,
                    'caption'    => null,
                ]);
            }
        }
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan dengan nomor tiket ' . $nomorTiket . ' berhasil diajukan!');
    }
    public function edit($pengaduan_id)
    {
        $pengaduan = Pengaduan::with('media')->findOrFail($pengaduan_id);
        return view('pages.pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, $pengaduan_id)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduan_id);

        $validatedData = $request->validate([
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'required|string',
            'lokasi_text'      => 'required|string|max:255',
            'rt'               => 'required|digits_between:1,3',
            'rw'               => 'required|digits_between:1,3',
            'lampiran_bukti'   => 'nullable',
            'lampiran_bukti.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ================= UPDATE DATA UTAMA =================
        $pengaduan->update([
            'judul'       => $validatedData['judul'],
            'deskripsi'   => $validatedData['deskripsi'],
            'lokasi_text' => $validatedData['lokasi_text'],
            'rt'          => $validatedData['rt'],
            'rw'          => $validatedData['rw'],
        ]);

        // ================= UPLOAD LAMPIRAN =================
        if ($request->hasFile('lampiran_bukti')) {

            $sort = Media::where('ref_table', 'pengaduan')
                ->where('ref_id', $pengaduan->pengaduan_id)
                ->max('sort_order');

            $sort = $sort ? $sort + 1 : 1;

            foreach ($request->file('lampiran_bukti') as $file) {

                $fileName = time() . '_' . uniqid() . '.' . $file->extension();

                $file->storeAs('pengaduan', $fileName, 'public');

                Media::create([
                    'ref_table'  => 'pengaduan',
                    'ref_id'     => $pengaduan->pengaduan_id,
                    'file_name'  => $fileName,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $sort++,
                    'caption'    => null,
                ]);
            }
        }

        return redirect()
            ->route('pengaduan.show', $pengaduan_id)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy($pengaduan_id)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduan_id);

        // 1. HAPUS SEMUA FILE FISIK DAN RECORD DARI TABEL MEDIA (Polimorfik)
        $pengaduan->media->each(function (Media $media) {
            // Hapus file fisik dari disk
            Storage::disk('public')->delete('pengaduan/' . $media->file_name);
            $media->delete(); // Hapus record dari tabel media
        });

        // 2. HAPUS DATA PENGADUAN UTAMA
        $pengaduan->delete();

        // 3. REDIRECT & FLASH DATA
        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus, dan lampiran bukti telah dihapus!');
    }
}
